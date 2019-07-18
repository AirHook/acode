<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Edit Item
	 *
	 * Edit selected item
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'categories');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('categories/categories_tree');
		$this->load->library('categories/category_details');
		$this->load->library('designers/designers_list');
		$this->load->library('products/products_list');
		$this->load->library('form_validation');

		// initialize certain properties
		if ( ! $this->category_details->initialize(array('category_id' => $id)))
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// if no id is present, send back to list..
			redirect($this->config->slash_item('admin_folder').'categories');
		}

		// set validation rules
		$this->form_validation->set_rules('view_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('category_slug', 'Category Slug', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// set data
			// category tree list for selection of Parent Category
			if ($this->webspace_details->options['site_type'] != 'hub_site')
			{
				$this->data['categories'] = $this->categories_tree->treelist(
					array(
						'd_url_structure' => ($this->webspace_details->slug ?: ''),
						'with_products' => TRUE
					)
				);
			}
			else $this->data['categories'] = $this->categories_tree->treelist(array('view_status'=>'1'));
			// designer list for the linking of category to designers
			$this->data['designers'] = $this->designers_list->select();
			// get the category children
			$this->data['children'] = $this->categories_tree->get_children($id, TRUE);

			// set some switches
			/* *
			$this->data['active_linked_designer_tab'] =
				$this->session->userdata('active_linked_designer_tab') ?:
				(
					(
						$this->config->item('site_slug') == 'basixblacklabel'
						OR $this->webspace_details->slug == 'basixblacklabel'
					)
					? 'basix-black-label' // backwards compatibility for basix
					: (
						@$this->webspace_details->options['site_type'] === 'hub_site'
						? 'general'
						: ($this->webspace_details->slug ?: $this->config->item('site_slug')) // should default to the webspace slug for sat_sites
					)
				)
			;
			// */

			// set data variables...
			$this->data['file'] = 'categories_edit';
			$this->data['page_title'] = 'Category Edit';
			$this->data['page_description'] = 'Edit Category Details';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			//echo '<pre>';
			//print_r($this->input->post());
			//die();

			// save post data
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process/add some variables
			if ($post_ary['descriptions'] && $this->input->post('d_url_structure'))
			{
				foreach ($post_ary['descriptions'] as $key => $val)
				{
					if ($key != 'general' && ! in_array($key, $post_ary['d_url_structure'])) unset($post_ary['descriptions'][$key]);
				}
			}
			$post_ary['description'] = $post_ary['descriptions'];
			unset($post_ary['descriptions']);
			if ($post_ary['title'] && $this->input->post('d_url_structure'))
			{
				foreach ($post_ary['title'] as $key => $val)
				{
					if ($key != 'general' &&  ! in_array($key, $post_ary['d_url_structure'])) unset($post_ary['title'][$key]);
				}
			}
			if ($post_ary['keyword'] && $this->input->post('d_url_structure'))
			{
				foreach ($post_ary['keyword'] as $key => $val)
				{
					if ($key != 'general' &&  ! in_array($key, $post_ary['d_url_structure'])) unset($post_ary['keyword'][$key]);
				}
			}
			if ($post_ary['alttags'] && $this->input->post('d_url_structure'))
			{
				foreach ($post_ary['alttags'] as $key => $val)
				{
					if ($key != 'general' &&  ! in_array($key, $post_ary['d_url_structure'])) unset($post_ary['alttags'][$key]);
				}
			}
			if ($post_ary['footer'] && $this->input->post('d_url_structure'))
			{
				foreach ($post_ary['footer'] as $key => $val)
				{
					if ($key != 'general' &&  ! in_array($key, $post_ary['d_url_structure'])) unset($post_ary['footer'][$key]);
				}
			}

			// we have to process icon_images and convert it to json format
			$icon_images =
				is_array($this->category_details->icons)
				? $this->category_details->icons
				: $this->category_details->icons ? explode(',', $this->category_details->icons) : '';
			;

			if ( ! empty($icon_images))
			{
				if (array() === $icon_images) $is_assoc = FALSE;
				$is_assoc = array_keys($icon_images) !== range(0, count($icon_images) - 1);
			}
			else $is_assoc = FALSE;

				//
				/* *
				if (empty($icon_images)) echo 'emtpy<br />';
				if ( ! empty($icon_images)) echo 'not emtpy<br />';
				echo '<pre>';
				echo $this->category_details->icons ? 'full' : 'empty';

				die();
				// */

			if ($is_assoc)
			{
				// retain current data
				$post_ary['icon_image'] = $icon_images;
				/*
				foreach ($icon_images as $key => $val)
				{
					if ($key != 'general' &&  ! in_array($key, $post_ary['d_url_structure'])) unset($icon_images[$key]);
				}
				*/
			}
			else
			{
				if ( ! empty($icon_images))
				{
					// let's save the items in the new assoc array starting with the general icon
					$post_ary['icon_image']['general'] = $icon_images[0];
					$i = 1;
					foreach ($post_ary['d_url_structure'] as $key => $val)
					{
						if (isset($icon_images[$i])) $post_ary['icon_image'][$val] = $icon_images[$i];
						$i++;
					}
				}
				//else $post_ary['icon_image'] = array();
			}

			// now convert all arrays to json
			$post_ary['d_url_structure'] = json_encode($post_ary['d_url_structure']);
			$post_ary['description'] = json_encode($post_ary['description']);
			$post_ary['title'] = json_encode($post_ary['title']);
			$post_ary['keyword'] = json_encode($post_ary['keyword']);
			$post_ary['alttags'] = json_encode($post_ary['alttags']);
			$post_ary['footer'] = json_encode($post_ary['footer']);
			if ($post_ary['icon_image']) $post_ary['icon_image'] = json_encode($post_ary['icon_image']);

			// process the change in parent category
			// we basically only need to change parent category
			// as such, category checkboxes are acting as radio button
			// so there is always only one category chosen as parent category
			// or none at all...
			// but we need to determine the category level of the new parent category
			// to know how much to move the category levels of the child categories
			// also, we need to automatically add parent categories to products of the child category
			if (isset($post_ary['categories']) && ! empty($post_ary['categories']))
			{
				$post_ary['parent_category'] = implode($post_ary['categories']);

				// if changed, we need to get the category level of the parent category
				// and update children category levels
				// apart from updating current items category level as well
				if ($this->category_details->parent_category != $post_ary['parent_category'])
				{
					// set category level and update children
					$levels = ($this->category_details->category_level - 1) - $post_ary['parent_category_level'];
					$post_ary['category_level'] = $this->category_details->category_level - $levels;

					// update product list of the category and it's children to include new parent category
					$new_parent = $post_ary['parent_category'];
					$this->products_list->update_categories($this->category_details->category_id, $new_parent);
				}
				else $levels = 0;
			}
			else
			{
				if ($this->category_details->category_id !== $this->category_details->parent_category)
				{
					// no selected parent category, let make itself a parent on its own
					$post_ary['parent_category'] = $this->category_details->category_id;
					$levels = $this->category_details->category_level - 0; // since it is a parent by itself
					$post_ary['category_level'] = $this->category_details->category_level - $levels;

					// update product list and remove ancestral categories from the cateogyr and its children
					$new_parent = $post_ary['parent_category'];
					$this->products_list->update_categories($this->category_details->category_id, $new_parent);
				}
				else $levels = 0;
			}

			// unset unneeded variables
			//unset($post_ary['passconf']);
			unset($post_ary['categories']);
			unset($post_ary['parent_category_level']);
			unset($post_ary['categories']);

			// connect to database
			$DB = $this->load->database('instyle', TRUE);

			// update category record
			$DB->where('category_id', $id);
			$DB->update('categories', $post_ary);

			// change levels of children where necessary
			// negative number means level down, otherwise level up
			if ($levels != 0) $this->categories_tree->children_change_level($id, $levels);

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			redirect($this->config->slash_item('admin_folder').'categories/edit/index/'.$id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/metronic');

		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// dropzone
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			';
			// bootstap tabdrop
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
			';
			// dropzone
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle validation
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-categories_edit.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
