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
			$this->session->set_userdata('admin_so_slug_segs', $this->input->post('slugs_link'));
		}
		else $slug_segs = array();

		// load pertinent library/model/helpers
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');

		// admin - either all designers or per designer admin
		// get designer/s for the category tree
		$designers =
			$this->webspace_details->options['site_type'] == 'hub_site'
			? $this->designers_list->select()
			: $this->designers_list->select(
				array(
					'des_id' => $this->webspace_details->des_id
				)
			)
		;

		$count_designers = count($designers);
		if ($designers)
		{
			// set slug segs name to capture info
			$slug_segs_name = array();

			$descnt = 1;
			foreach ($designers as $designer_details)
			{
				// get the designer category tree
				$des_subcats = $this->categories_tree->treelist(
					array(
						'd_url_structure' => $designer_details->url_structure,
						//'vendor_id' => $this->session->admin_po_vendor_id,
						'with_products' => TRUE
					)
				);
				$row_count = $this->categories_tree->row_count;
				$max_level = $this->categories_tree->max_category_level;

				if (@$des_subcats)
				{
					// set or check active slug
					$slug_segs = @$slug_segs ?: array();
					$cnt_slug_segs = count($slug_segs) - 2;

					// generate designer slugs and name for link and front end
					$slugs_link = array($designer_details->url_structure);
					$slugs_link_name = array();

					// designer level
					// set active where necessary
					if (strpos(implode('/', $slug_segs), $designer_details->url_structure) !== FALSE)
					{
						$active = 'bold';
						array_push($slug_segs_name, $designer_details->designer);
					}
					else $active = '';

                    // get active category names
                    if ($active == 'bold' OR $active == 'bold active')
                    {
                        array_push($slugs_link_name, $designer_details->designer);
                    }
					?>

		<div style="display:inline-block;vertical-align:top;">
			<ul class="designer-categories-tree list-unstyled">
				<li class="<?php echo $active; ?> designer-level" data-slug="<?php echo $designer_details->url_structure; ?>" data-slugs_link="<?php echo implode('/', $slugs_link); ?>">
					<a href="javascript:;" data-slug="<?php echo $designer_details->url_structure; ?>" style="font-size:0.8em;" data-slugs_link="<?php echo implode('/', $slugs_link); ?>">
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
					foreach ($des_subcats as $category)
					{
						// set margin
						$margin = 'padding-left:'.($marg * ($category->category_level + 2)).'px;';

						// if first row...
						if ($ic == 1)
						{
							// create link
							array_push($slugs_link, $category->category_slug);

							// save as previous level
							// always starts at 0
							$prev_level = $category->category_level;
						}
						else
						{
							// if same category level
							if ($category->category_level == $prev_level)
							{
								// create new link
								$pop = array_pop($slugs_link); // remove previous last seg
								array_push($slugs_link, $category->category_slug); // replace with new one
							}

							// NOTE: next greater level is always greater by only 1 level
							if ($category->category_level == $prev_level + 1)
							{
								// append to previous link
								array_push($slugs_link, $category->category_slug);
							}

							// if next category level is lower
							if ($category->category_level < $prev_level)
							{
								for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
								{
									// update link
									$pop = array_pop($slugs_link);
								}

								// append to link
								array_push($slugs_link, $category->category_slug);
							}
						}

						// if slug_segs
						if ( ! empty($slug_segs))
						{
							// set active where necessary
							if (strpos(implode('/', $slug_segs), implode('/', $slugs_link)) !== FALSE)
							{
								$active = $cnt_slug_segs == $category->category_level ? 'bold active' : 'bold';
								array_push($slug_segs_name, $category->category_name);
							}
							else $active = '';
						}

						// get active category names
						if ($active == 'bold' OR $active == 'bold active')
						{
							array_push($slugs_link_name, $category->category_name);
						}

						// if this is last row, set slug segs
						$cat_crumbs = '';
						if ($ic == $row_count)
						{
							// capture the active slugs
							//$slug_segs = @$slug_segs ?: $slugs_link;
							//$slug_segs_name = $slug_segs_name ?: $slugs_link_name;
							$p_slug_segs = 'data-slug_segs="'.implode('/', $slug_segs).'" ';
							$p_slug_segs_name = 'data-slug_segs_name="'.implode(' &nbsp;&raquo;&nbsp; ', $slug_segs_name).'" ';

							// need to show the category crumbs for use at front end
							if ($descnt == $count_designers)
							{
								$cat_crumbs = '<input type="hidden" name="cat_crumbs" value="'.implode(' &nbsp;&raquo;&nbsp; ', $slug_segs_name).'" />';
							}
						}

						// first row is usually the top main category...
						echo '<li class="category_list '
							.$active
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
							.'" data-slugs_link="'
							.implode('/', $slugs_link)
							.'">'
							.'<a href="javascript:;" style="font-size:0.8em;'
							.$margin
							.'" data-slugs_link="'
							.implode('/', $slugs_link)
							.'" data-des_slug="'
							.$designer_details->url_structure
							.'">'
							.$category->category_name
							.'</a>'
							.$cat_crumbs
							.'</li>'
						;

						$prev_level = $category->category_level;
						$ic++;
					}

					echo '</ul></div>';
				}

				$descnt++;
			}
		}

		exit;
	}

	// ----------------------------------------------------------------------

}
