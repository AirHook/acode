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
			// nothing more to do...
			echo 'error';
			exit;
		}

		// grab the post variable
		$designer = $this->input->post('designer');
		$vendor_id = $this->input->post('vendor_id');

		// set session
		$this->session->set_userdata('admin_so_vendor_id', $vendor_id);

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

		$slug_segs =
			$this->session->admin_so_slug_segs
			? json_decode($this->session->admin_so_slug_segs, TRUE)
			: array()
		;

		$active = 'active';

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
			exit;
		}

		// set or check active slug
		// in the beginning, whether from select vendor or cat-tree click
		// designer top level list is always active
		// ergo, set as first slugs_link
		$slugs_link = array($designer_details->url_structure);

		// start the unstyle list with the designer as top most list
		$html = '<ul class="list-unstyled nested-nav ">';
		$html.= '<li class="'
			.$active
			.' designer-level" data-slug="'
			.$designer_details->url_structure
			.'"><a href="javascript:;" data-des_slug="'
			.$designer_details->url_structure
			.'" style="font-size:0.8em;" data-slugs_link="'
			.implode('/', $slugs_link)
			.'">'
			.$designer_details->designer
			.'</a>'
		;

		$html.= '<ul class="list-unstyled nested-nav" style="margin-left:15px;" data-row_count="'.$row_count.'">';

		$ic = 1;
		foreach ($des_subcats as $category)
		{
			// let do first row...
			if ($ic == 1)
			{
				// create link
				array_push($slugs_link, $category->category_slug);

				// first row is usually the top main category...
				$html.= '<li class="category_list '
					.$active
					.' level-1 '
					.$category->category_id
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
					.$active
					.'><a href="javascript:;" style="font-size:0.8em;" data-slugs_link="'
					.implode('/', $slugs_link)
					.'" data-des_slug="'
					.$designer_details->url_structure
					.'">'
					.$category->category_name
					.'</a>'
				;

				// save as previous level
				$prev_level = $category->category_level;

				$ic++;
				continue;
			}

			// if same category level, close previous </li> and open another one
			if ($category->category_level == $prev_level)
			{
				// unset active
				$active = '';
				// capture the active slugs before next same level iteration
				$slug_segs = @$slug_segs ?: $slugs_link;

				// create new link
				$pop = array_pop($slugs_link); // remove previous last seg
				array_push($slugs_link, $category->category_slug); // replace with new one

				$html.= '</li><li class="category_list '
					.$active
					.' level-'
					.$ic
					.' '
					.$category->category_id
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
					.$active
					.'><a href="javascript:;" style="font-size:0.8em;" data-slugs_link="'
					.implode('/', $slugs_link)
					.'" data-des_slug="'
					.$designer_details->url_structure
					.'">'
					.$category->category_name
					.'</a>'
				;
			}

			// NOTE: next greater level is always greater by only 1 level
			// if so, create new open list <ul>
			if ($category->category_level == $prev_level + 1)
			{
				// append to previous link
				array_push($slugs_link, $category->category_slug);

				$html.= '<ul class="list-unstyled '
					.($category->category_level == '1' ? 'ul-first-level' : '')
					.'" style="margin-left:15px;"><li class="category_list '
					.$active
					.' level-'
					.$ic
					.' '
					.$category->category_id
					.'" data-category_id="'
					.$category->category_id
					.'" data-parent_category="'
					.$category->parent_category
					.'" data-category_slug="'
					.$category->category_slug
					.'" data-category_name="'
					.$category->category_name
					.'" data-category_level="'
					.$category->category_level
					.'" data-slug="'
					.$category->category_slug
					.'" '
					.$active
					.'><a href="javascript:;" style="font-size:0.8em;" data-slugs_link="'
					.implode('/', $slugs_link)
					.'" data-des_slug="'
					.$designer_details->url_structure
					.'">'
					.$category->category_name
					.'</a>'
				;
			}

			// if next category level is lower, close previous </li></ul> and open another one
			// dont forget to count the depth of levels
			if ($category->category_level < $prev_level)
			{
				// unset active
				$active = '';
				// capture the active slugs before next level iteration
				$slug_segs = @$slug_segs ?: $slugs_link;

				for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
				{
					$html.= '</li></ul>';

					// update link
					$pop = array_pop($slugs_link);
				}

				// append to link
				array_push($slugs_link, $category->category_slug);

				$html.= '<ul class="list-unstyled '
					.($category->category_level == '1' ? 'ul-first-level' : '')
					.'" style="margin-left:15px;"><li class="category_list '
					.$active
					.' level-'
					.$ic
					.' '
					.$category->category_id
					.'" data-category_id="'
					.$category->category_id
					.'" data-parent_category="'
					.$category->parent_category
					.'" data-category_slug="'
					.$category->category_slug
					.'" data-category_name="'
					.$category->category_name
					.'" data-category_level="'
					.$category->category_level
					.'" data-slug="'
					.$category->category_slug
					.'" '
					.$active
					.'><a href="javascript:;" style="font-size:0.8em;" data-slugs_link="'
					.implode('/', $slugs_link)
					.'" data-des_slug="'
					.$designer_details->url_structure
					.'">'
					.$category->category_name
					.'</a>'
				;
			}

			// if this is last row, close it
			// again, check count of depth of levels
			if ($ic == $row_count)
			{
				// unset active
				$active = '';
				// capture the active slugs before next level iteration
				$slug_segs = @$slug_segs ?: $slugs_link;

				for ($deep = $category->category_level; $deep > 0; $deep--)
				{
					$html.= '</li data-row_count="'.$row_count.'"></ul>';
				}
				$html.= '</li>';
			}

			$prev_level = $category->category_level;
			$ic++;
		}

		// set slug_segs session
		$this->session->set_userdata('admin_so_slug_segs', json_encode($slug_segs));

		$html.= '</li></ul><span id="slug_segs" class="hidden">'.implode('/', $slug_segs).'</span>';
		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
