<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_category_tree extends MY_Controller {

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

		// grab the post variable and set sesssion
		if ($this->input->post('slugs_link'))
		{
			$slug_segs = explode('/', $this->input->post('slugs_link'));
			//$this->session->set_userdata('admin_sa_slug_segs', $this->input->post('slugs_link'));
		}
		else $slug_segs = array();
		$page = $this->input->post('page') ?: 'create';

		// load pertinent library/model/helpers
		$this->load->library('designers/designers_list');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories_tree');

		// get the designer slug
		$des_slug =
			$this->session->sa_des_slug
			?: (
				$this->session->sa_mod_des_slug
				?: $this->input->post('des_slug')
			)
		;

		// get the designer and it's category tree
		// which by this time, a designer has already been selected

		// get designer details
		$designer_details = $this->designer_details->initialize(
			array(
				'url_structure' => $des_slug
			)
		);
		// get the designer category tree
		$param1['with_products'] = TRUE;
		if ($des_slug != 'shop7thavenue') $param1['d_url_structure'] = $des_slug;
		$des_subcats = $this->categories_tree->treelist($param1);
		$row_count = $this->categories_tree->row_count;
		$max_level = $this->categories_tree->max_category_level;

		// set or check active slug
		//$slug_segs = @$slug_segs ?: array(); // set on grab of post data
		$cnt_slug_segs = count($slug_segs) - 1;

		// designer top level list is always active
		// ergo, set as first slugs_link
		$slugs_link = array($designer_details->url_structure);
		$slugs_link_name = array($designer_details->designer);
		$active = 'bold';
		?>

			<li class="<?php echo $active; ?> designer-level" data-slug="<?php echo $designer_details->url_structure; ?>">
				<a href="javascript:;" data-des_slug="<?php echo $designer_details->url_structure; ?>" style="font-size:0.8em;" data-slugs_link="<?php echo implode('/', $slugs_link); ?>"  data-page="<?php echo $page; ?>">
					<?php echo $designer_details->designer; ?>
				</a>
			</li>

		<?php
		/**********
		 * Cateogry tree list
		 */
		$ic = 1;
		$marg = 15;
		$first_max_level = $max_level;
		$p_slug_segs = '';
		$p_slug_segs_name = '';
		$last = '';
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

			// if first row...
			if ($ic == 1)
			{
				// create link
				array_push($slugs_link, $category->category_slug);

				// get active category names
				if ($active == 'bold' OR $active == 'bold active')
				{
					array_push($slugs_link_name, $category->category_name);
				}

				// save as previous level
				// always starts at 0
				$prev_level = $category->category_level;
			}
			else
			{
				// if same category level
				if ($category->category_level == $prev_level)
				{
					// capture the active slugs before next same level iteration
					$slug_segs = @$slug_segs ?: $slugs_link;

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
					// capture the active slugs before next level iteration
					$slug_segs = @$slug_segs ?: $slugs_link;

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

				// if this is last row, set slug segs
				if ($ic == $row_count)
				{
					$last = 'last';
					// capture the active slugs before next level iteration
					$slug_segs = @$slug_segs ?: $slugs_link;
					$slug_segs_name = @$slug_segs_name ?: $slugs_link_name;
					$p_slug_segs = 'data-slug_segs="'.implode('/', $slug_segs).'" ';
					$p_slug_segs_name = 'data-slug_segs_name="'.implode(' &nbsp;&raquo;&nbsp; ', $slug_segs_name).'" ';
				}
			}

			// first row is usually the top main category...
			echo '<li class="category_list '
				.$active
				.' level-1 '
				.$last
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
		$this->session->set_userdata('sa_slug_segs', json_encode($slug_segs));

		exit;
	}

	// ----------------------------------------------------------------------

}
