<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_category_tree extends Admin_Controller {

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
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if (
			! $this->input->post('designer')
			OR ! $this->input->post('vendor_id')
		)
		{
			unset($_SESSION['admin_po_vendor_id']);
			unset($_SESSION['admin_po_des_url_structure']);

			// nothing more to do...
			echo '';
			exit;
		}

		// grab the post variable
		//$designer = 'basixblacklabel'; //$this->input->post('designer');
		//$vendor_id = '22'; //$this->input->post('vendor_id');
		$designer = $this->input->post('designer');
		$vendor_id = $this->input->post('vendor_id');
		$slug_segs = $this->input->post('slug_segs');

		// set sessions
		$this->session->set_userdata('admin_po_vendor_id', $vendor_id);
		$this->session->set_userdata('admin_po_des_url_structure', $designer);

		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories_tree');

		// get details
		$designer_details = $this->designer_details->initialize(
			array(
				'designer.url_structure' => $designer
			)
		);

		// get the designer category tree
		$des_subcats = $this->categories_tree->treelist(
			array(
				'd_url_structure' => $designer_details->url_structure,
				'vendor_id' => $vendor_id,
				'with_products' => TRUE
			)
		);
		$row_count = $this->categories_tree->row_count;
		$max_level = $this->categories_tree->max_category_level;

		if (
			empty($des_subcats)
			OR $row_count == 0
		)
		{
			// return nothing...
			echo '';
			exit;
		}

		// set or check active slug
		$slug_segs = $slug_segs ? explode('/', $slug_segs) : array();
		$cnt_slug_segs = count($slug_segs) - 1;

		// in the beginning, whether from select vendor or cat-tree click
		// designer top level list is always active
		// ergo, set as first slugs_link
		$slugs_link = array($designer_details->url_structure);
		$slugs_link_name = array();
		$active = 'bold';

		// start the unstyle list with the designer as top most list
		$html = '<li class="'
			.$active
			.' designer-level" data-slug="'
			.$designer_details->url_structure
			.'"><a href="javascript:;" data-des_slug="'
			.$designer_details->url_structure
			.'" style="font-size:0.8em;" data-slugs_link="'
			.implode('/', $slugs_link)
			.'">'
			.$designer_details->designer
			.'</a></li>'
		;

		$ic = 1;
		$marg = 15;
		$first_max_level = $max_level;
		$p_slug_segs = '';
		$p_slug_segs_name = '';
		foreach ($des_subcats as $category)
		{
			// set margin
			$margin = 'padding-left:'.($marg * ($category->category_level + 2)).'px;';

			// if there is no slug_segs
			if ( ! $slug_segs OR empty($slug_segs))
			{
				if ($first_max_level > $max_level) $active = '';
				else
				{
					if ($category->category_level < $first_max_level) $active = 'bold';
					if ($category->category_level == $first_max_level)
					{
						$active = 'bold active';
						$first_max_level++;
					}
				}
			}
			else
			{
				// set active where necessary
				if (in_array($category->category_slug, $slug_segs))
				{
					$active = $cnt_slug_segs == $category->category_level ? 'bold active' : 'bold';
				}
				else $active = '';
			}

			// let do first row...
			if ($ic == 1)
			{
				// create link array
				array_push($slugs_link, $category->category_slug);

                // get active category names
                if ($active == 'bold' OR $active == 'bold active')
                {
                    array_push($slugs_link_name, $category->category_name);
                }

				// save as previous level
				$prev_level = $category->category_level;
			}
			else
			{
				// if same category level
				if ($category->category_level == $prev_level)
				{
					// capture the first active slugs segments before next same level iteration
					$slug_segs = !empty($slug_segs) ? $slug_segs : $slugs_link;

					// create new link
					$pop = array_pop($slugs_link); // remove previous last seg
					array_push($slugs_link, $category->category_slug); // replace with new one

					// get active category names
	                if ($active == 'bold' OR $active == 'bold active')
	                {
	                    array_push($slugs_link_name, $category->category_name);
	                }
				}

				// NOTE: next greater level is always greater by only 1 level
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($slugs_link, $category->category_slug);

					// get active category names
	                if ($active == 'bold' OR $active == 'bold active')
	                {
	                    array_push($slugs_link_name, $category->category_name);
	                }
				}

				// if next category level is lower
				if ($category->category_level < $prev_level)
				{
					// capture the active slugs segments before next lower level iteration
					$slug_segs = !empty($slug_segs) ? $slug_segs : $slugs_link;

					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						// update link
						$pop = array_pop($slugs_link);
					}

					// append to link
					array_push($slugs_link, $category->category_slug);

					// get active category names
	                if ($active == 'bold' OR $active == 'bold active')
	                {
	                    array_push($slugs_link_name, $category->category_name);
	                }
				}
			}

			// if this is last row, set slug segs
			if ($ic == $row_count)
			{
				// capture the active slugs before next level iteration
				$slug_segs = !empty($slug_segs) ? $slug_segs : $slugs_link;
				$slug_segs_name = !empty($slug_segs_name) ? $slug_segs_name : $slugs_link_name;
				$p_slug_segs = 'data-slug_segs="'.implode('/', $slug_segs).'" ';
				$p_slug_segs_name = 'data-slug_segs_name="'.implode(' &nbsp;&raquo;&nbsp; ', $slug_segs_name).'" ';
			}

			// first row is usually the top main category...
			$html.= '<li class="category_list '
				.$active
				.' level-1 '
				.'" data-category_id="'
				.$category->category_id
				.'" data-parent_category="'
				.$category->parent_category.
				'" data-category_slug="'
				.$category->category_slug
				.'" data-category_name="'
				.$category->category_name
				.'" data-category_level="'
				.$category->category_level
				.'" data-slug="'
				.$category->category_slug
				.'" '
				.$p_slug_segs
				.$p_slug_segs_name
				.'>'
				.'<a href="javascript:;" style="font-size:0.8em;'
				.$margin
				.'" data-slugs_link="'
				.implode('/', $slugs_link)
				.'" data-des_slug="'
				.$designer_details->url_structure
				.'">'
				.$category->category_name
				.'</a></li>'
			;

			$prev_level = $category->category_level;
			$ic++;
		}

		// set slug_segs session
		$this->session->set_userdata('admin_po_slug_segs', json_encode($slug_segs));

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
