<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Create Category Treelist
 *
 * @package		CodeIgniter
 * @subpackage	Custom Helpers
 * @category	Categories
 * @author		WebGuy
 * @link
 */

// ------------------------------------------------------------------------

/**
 * Create Category Treelist the Metronic way
 *
 * Create Category Treelist containted in a div as form control with class "height-auto"
 * and another div that is set as a scroller, then listed as <ul>
 *
 * NOTE:	Make user to wrap the helper function create_category_treelist()
 *			the following:
 *
 *			<div class="form-control height-auto">
 *				<div class="scroller" style="height:175px;" data-always-visible="1" data-handle-color="#637283">
 *
 *			... and don't foregt to close all tags
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_category_treelist'))
	{
		function create_category_treelist(
			array $categories, // the list of categories to list in a tree like manner
			array $linked_to, // links or attached to categories
			$row_count = 0,
			$sort_checked = FALSE
		)
		{
			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled">';

			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already selected
				$select = in_array($category->category_id, $linked_to) ? 'checked': '';

				// let do first row...
				if ($ic == 1)
				{
					// first row is usually the top main category...
					echo '<li><label><input type="checkbox" name="categories[]" class="category_treelist '.$category->category_id.' '.($select ? 'is-the-selected' : '').'" value="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$select.'> '.($select ? '<strong>' : '').$category->category_name.($select ? '</strong>' : '').' </label>';

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					echo '</li><li><label><input type="checkbox" name="categories[]" class="category_treelist '.$category->category_id.' '.($select ? 'is-the-selected' : '').'" value="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$select.'> '.($select ? '<strong>' : '').$category->category_name.($select ? '</strong>' : '').' </label>';
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					echo '<ul class="list-unstyled"><li><label><input type="checkbox" name="categories[]" class="category_treelist '.$category->category_id.' '.($select ? 'is-the-selected' : '').'" value="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$select.'> '.($select ? '<strong>' : '').$category->category_name.($select ? '</strong>' : '').' </label>';
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';
					}

					echo '<ul class="list-unstyled"><li><label><input type="checkbox" name="categories[]" class="category_treelist '.$category->category_id.' '.($select ? 'is-the-selected' : '').'" value="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$select.'> '.($select ? '<strong>' : '').$category->category_name.($select ? '</strong>' : '').' </label>';
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Category Parent Treelist the Metronic way
 * Parents and availabel parents only
 * Children are not shown
 *
 * Create Category Prent Treelist containted in a div as form control with class "height-auto"
 * and another div that is set as a scroller, then listed as <ul>
 *
 * NOTE:	Make user to wrap the helper function create_category_treelist()
 *			the following:
 *
 *			<div class="form-control height-auto">
 *				<div class="scroller" style="height:175px;" data-always-visible="1" data-handle-color="#637283">
 *
 *			... and don't foregt to close all tags
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_category_parent_treelist'))
	{
		function create_category_parent_treelist (
			array $categories, // the list of categories to list in a tree like manner already
			array $linked_to, // parent_category
			$row_count = 0,
			$self,
			$children // array of id's that are children of $self
		)
		{
			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			//echo '<ul class="list-unstyled">';
			$ul_start = '<ul class="list-unstyled">';

			$li_list = '';

			$ic = 1;
			$prev_self_and_child = FALSE;
			foreach ($categories as $category)
			{
				// set select if parent category is the selected category
				$select = in_array($category->category_id, $linked_to) ? 'checked': '';

				// no need to show self and children
				$self_and_child =
					(
						($children && in_array($category->category_id, $children))
						OR $category->category_id == $self
					)
					? TRUE
					: FALSE
				;
				$self_and_child = FALSE;

				if (
					($children && in_array($category->category_id, $children))
					OR $category->category_id == $self
				)
				{
					$self_class = 'font-style:italic;color:#959595;';
				}
				else $self_class = '';

				// let's highlight $self
				if ($category->category_id == $self)
				{
					$self_class = 'font-style:italic;color:#959595;text-decoration:underline;';
					$self_self = 'data-original-title="Current category on edit." data-placement="right"';
				}
				else
				{
					$self_self = '';
				}

				// let's highlight $self's children
				if ($children && in_array($category->category_id, $children))
				{
					$self_child = 'data-original-title="Child of category on edit." data-placement="right"';
				}
				else
				{
					$self_child = '';
				}

				// let do first row...
				if ($ic == 1)
				{
					if ( ! $self_and_child)
					{
						// first row is usually the top main category...
						$li_list.= '<li><label class="'.(($self_self OR $self_child) ? 'tooltips' : '').'" '.$self_self.' '.$self_child.'><input type="checkbox" name="categories[]" class="category_treelist '.$category->category_id.' '.($select ? 'is-the-selected' : '').'" value="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$select.' '.($self_class ? 'disabled' : '').'> '.($select ? '<strong>' : '').'<span style="'.$self_class.'">'.$category->category_name.'</span>'.($select ? '</strong>' : '').' </label>';

						// save as previous level
						$prev_level = $category->category_level;

						$ic++;
					}

					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					if ( ! $self_and_child)
					{
						$li_list.= '</li><li><label class="'.(($self_self OR $self_child) ? 'tooltips' : '').'" '.$self_self.' '.$self_child.'><input type="checkbox" name="categories[]" class="category_treelist '.$category->category_id.' '.($select ? 'is-the-selected' : '').'" value="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$select.' '.($self_class ? 'disabled' : '').'> '.($select ? '<strong>' : '').'<span style="'.$self_class.'">'.$category->category_name.'</span>'.($select ? '</strong>' : '').' </label>';

						$prev_self_and_child = FALSE;
					}
					else
					{
						$prev_self_and_child = TRUE;
					}
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					if ( ! $self_and_child)
					{
						$li_list.= '<ul class="list-unstyled"><li><label class="'.(($self_self OR $self_child) ? 'tooltips' : '').'" '.$self_self.' '.$self_child.'><input type="checkbox" name="categories[]" class="category_treelist '.$category->category_id.' '.($select ? 'is-the-selected' : '').'" value="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$select.' '.($self_class ? 'disabled' : '').'> '.($select ? '<strong>' : '').'<span style="'.$self_class.'">'.$category->category_name.'</span>'.($select ? '</strong>' : '').' </label>';

						$prev_self_and_child = FALSE;
					}
					else
					{
						$prev_self_and_child = TRUE;
					}
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					if ( ! $self_and_child)
					{
						for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
						{
							$li_list.= '</li></ul>';
						}
					}

					if ( ! $self_and_child)
					{
						$li_list.= '<ul class="list-unstyled"><li><label class="'.(($self_self OR $self_child) ? 'tooltips' : '').'" '.$self_self.' '.$self_child.'><input type="checkbox" name="categories[]" class="category_treelist '.$category->category_id.' '.($select ? 'is-the-selected' : '').'" value="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$select.' '.($self_class ? 'disabled' : '').'> '.($select ? '<strong>' : '').'<span style="'.$self_class.'">'.$category->category_name.'</span>'.($select ? '</strong>' : '').' </label>';

						$prev_self_and_child = FALSE;
					}
					else
					{
						$prev_self_and_child = TRUE;
					}
				}

				// if this is last row, close it
				// again, check count of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						$li_list.= '</li></ul>';
					}
					$li_list.= '</li>';
				}

				if ( ! $prev_self_and_child) $prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			//echo '</ul>';
			$ul_end = '</ul>';

			if ($li_list != '') return $ul_start.$li_list.$ul_end;
			return '';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Product Sidebar Category Tree List at Frontend Thumbs page
 *
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_product_sidebar_category_list'))
	{
		function create_product_sidebar_category_list (
			array $categories, // the list of categories to list in a tree like manner already
			array $uri_segments, // categories in the uri
			$row_count = 0,
			$d_url_structure = '' // designer slug for designer based categorization
		)
		{
			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled nested-nav" style="margin-right:30px;" data-row_count="'.$row_count.'">';

			//$li_a_link = $d_url_structure ? array($d_url_structure) : array();
			$li_a_link = array();
			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already active
				$active = in_array($category->category_slug, $uri_segments) ? 'active': '';


				// let do first row...
				if ($ic == 1)
				{
					// create link
					$li_a_link = array($category->category_slug);

					// first row is usually the top main category...
					echo '<li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a class="collapse collapse-marker" href="" data-original-title="Collapse/Expand" title=""></a><a href="'.site_url('shop/'.($d_url_structure ? $d_url_structure.'/' : '').implode('/', $li_a_link)).'"> '.($active ? '<strong>' : '').strtoupper($category->category_name).($active ? '</strong>' : '').' </a>';

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					// create new link
					$pop = array_pop($li_a_link);
					array_push($li_a_link, $category->category_slug);

					echo '</li><li class="category_list '.$category->category_id.' " data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('shop/'.($d_url_structure ? $d_url_structure.'/' : '').implode('/', $li_a_link)).'"> '.(($active OR $category->category_level == '1') ? '<strong>' : '').$category->category_name.(($active OR $category->category_level == '1') ? '</strong>' : '').' </a>';
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('shop/'.($d_url_structure ? $d_url_structure.'/' : '').implode('/', $li_a_link)).'"> '.(($active OR $category->category_level == '1') ? '<strong>' : '').$category->category_name.(($active OR $category->category_level == '1') ? '</strong>' : '').' </a>';
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';

						// update link
						$pop = array_pop($li_a_link);
					}

					// append to link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('shop/'.($d_url_structure ? $d_url_structure.'/' : '').implode('/', $li_a_link)).'"> '.(($active OR $category->category_level == '1') ? '<strong>' : '').$category->category_name.(($active OR $category->category_level == '1') ? '</strong>' : '').' </a>';
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li data-row_count="'.$row_count.'"></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Admin Product Sidebar Category Tree List at Frontend Thumbs page
 *
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_admin_product_sidebar_category_list'))
	{
		function create_admin_product_sidebar_category_list (
			array $categories, // the list of categories to list in a tree like manner already
			array $uri_segments, // categories in the uri
			$row_count = 0
		)
		{
			// set instances
			$CI =& get_instance();

			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled nested-nav" style="" data-row_count="'.$row_count.'">';

			$uri_segment_array = $CI->uri->segment_array();
			array_shift($uri_segment_array);
			array_shift($uri_segment_array);
			array_shift($uri_segment_array);

			$temp_uri_segments = $uri_segments;
			if (in_array($CI->session->active_designer, $uri_segments))
			{
				$li_a_link = array($CI->session->active_designer);
			}
			else $li_a_link = array_diff($uri_segments, $uri_segment_array);
			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already active
				if ($uri_segments === $uri_segment_array)
				{
					$active = in_array($category->category_slug, $uri_segments) ? 'active': '';
				}
				else $active = '';

				// let do first row...
				if ($ic == 1)
				{
					// create link
					array_push($li_a_link, $category->category_slug);

					// first row is usually the top main category...
					echo '<li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/products/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/products/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					// create new link
					$pop = array_pop($li_a_link);
					array_push($li_a_link, $category->category_slug);

					echo '</li><li class="category_list '.$category->category_id.' " data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/products/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/products/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/products/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/products/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';

						// update link
						$pop = array_pop($li_a_link);
					}

					// append to link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/products/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/products/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li data-row_count="'.$row_count.'"></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Admin Product Sidebar Category Tree List at Frontend Thumbs page
 *
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_admin_product_csv_sidebar_category_list'))
	{
		function create_admin_product_csv_sidebar_category_list (
			array $categories, // the list of categories to list in a tree like manner already
			array $uri_segments, // categories in the uri
			$row_count = 0
		)
		{
			// set instances
			$CI =& get_instance();

			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled nested-nav" style="" data-row_count="'.$row_count.'">';

			$uri_segment_array = $CI->uri->segment_array();
			array_shift($uri_segment_array); // admin
			array_shift($uri_segment_array); // products
			array_shift($uri_segment_array); // csv
            array_shift($uri_segment_array); // index

			$temp_uri_segments = $uri_segments;
			if (in_array($CI->session->active_designer, $uri_segments))
			{
				$li_a_link = array($CI->session->active_designer);
			}
			else $li_a_link = array_diff($uri_segments, $uri_segment_array);
			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already active
				if ($uri_segments === $uri_segment_array)
				{
					$active = in_array($category->category_slug, $uri_segments) ? 'active': '';
				}
				else $active = '';

				// let do first row...
				if ($ic == 1)
				{
					// create link
					array_push($li_a_link, $category->category_slug);

					// first row is usually the top main category...
					echo '<li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/products/csv/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/products/csv/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					// create new link
					$pop = array_pop($li_a_link);
					array_push($li_a_link, $category->category_slug);

					echo '</li><li class="category_list '.$category->category_id.' " data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/products/csv/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/products/csv/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/products/csv/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/products/csv/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';

						// update link
						$pop = array_pop($li_a_link);
					}

					// append to link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/products/csv/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/products/csv/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li data-row_count="'.$row_count.'"></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Sales Package Product Sidebar Category Tree List
 *
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_sale_package_product_sidebar_category_list'))
	{
		function create_sale_package_product_sidebar_category_list (
			array $categories, // the list of categories to list in a tree like manner already
			array $uri_segments, // categories in the uri
			$row_count = 0
		)
		{
			// set instances
			$CI =& get_instance();

			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled nested-nav" style="" data-row_count="'.$row_count.'">';

			$uri_segment_array = $CI->uri->segment_array();
			if ($CI->uri->segment(1) === 'sales')
			{
				array_shift($uri_segment_array); // salse
				array_shift($uri_segment_array); // sales_package
				array_shift($uri_segment_array); // edit
				array_shift($uri_segment_array); // step2
				array_shift($uri_segment_array); // sales_package_id

				$link_pre = 'sales/sales_package/edit/step2/'.$CI->uri->segment(5).'/';
			}
			else
			{
				array_shift($uri_segment_array); // admin
				array_shift($uri_segment_array); // campaigns
				array_shift($uri_segment_array); // sales_package
				array_shift($uri_segment_array); // edit
				array_shift($uri_segment_array); // step2
				array_shift($uri_segment_array); // sales_package_id

				$link_pre = 'admin/campaigns/sales_package/edit/step2/'.$CI->uri->segment(6).'/';
			}

			$temp_uri_segments = $uri_segments;
			if (in_array($CI->session->active_designer, $uri_segments))
			{
				$li_a_link = array($CI->session->active_designer);
			}
			else $li_a_link = array_diff($uri_segments, $uri_segment_array);
			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already active
				if ($uri_segments === $uri_segment_array)
				{
					$active = in_array($category->category_slug, $uri_segments) ? 'active': '';
				}
				else $active = '';

				// let do first row...
				if ($ic == 1)
				{
					// create link
					array_push($li_a_link, $category->category_slug);

					// first row is usually the top main category...
					echo '<li class="category_list '
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
						.'" '
						.$active
						.'><a href="'
						.site_url($link_pre.implode('/', $li_a_link))
						.'" style="'
						.(
							$CI->uri->uri_string() == $link_pre.implode('/', $li_a_link)
							? 'color:#23527c;text-decoration:underline;'
							: ''
						)
						.'"> '
						.($active ? '<strong>' : '')
						.$category->category_name
						.($active ? '</strong>' : '')
						.' </a>'
					;

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					// create new link
					$pop = array_pop($li_a_link);
					array_push($li_a_link, $category->category_slug);

					echo '</li><li class="category_list '
						.$category->category_id
						.' " data-category_id="'
						.$category->category_id
						.'" data-parent_category="'
						.$category->parent_category
						.'" data-category_slug="'
						.$category->category_slug
						.'" data-category_name="'
						.$category->category_name
						.'" data-category_level="'
						.$category->category_level
						.'" '
						.$active
						.'><a href="'
						.site_url($link_pre.implode('/', $li_a_link))
						.'" style="'
						.(
							$CI->uri->uri_string() == $link_pre.implode('/', $li_a_link)
							? 'color:#23527c;text-decoration:underline;'
							: ''
						)
						.'"> '
						.($active ? '<strong>' : '')
						.$category->category_name
						.($active ? '</strong>' : '')
						.' </a>'
					;
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '
						.($category->category_level == '1' ? 'ul-first-level' : '')
						.'"><li class="category_list '
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
						.'" '
						.$active
						.'><a href="'
						.site_url($link_pre.implode('/', $li_a_link))
						.'" style="'
						.(
							$CI->uri->uri_string() == $link_pre.implode('/', $li_a_link)
							? 'color:#23527c;text-decoration:underline;'
							: ''
						)
						.'"> '
						.($active ? '<strong>' : '')
						.$category->category_name
						.($active ? '</strong>' : '')
						.' </a>'
					;
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';

						// update link
						$pop = array_pop($li_a_link);
					}

					// append to link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '
						.($category->category_level == '1' ? 'ul-first-level' : '')
						.'"><li class="category_list '
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
						.'" '
						.$active
						.'><a href="'
						.site_url($link_pre.implode('/', $li_a_link))
						.'" style="'
						.(
							$CI->uri->uri_string() == $link_pre.implode('/', $li_a_link)
							? 'color:#23527c;text-decoration:underline;'
							: ''
						)
						.'"> '.
						($active ? '<strong>' : '')
						.$category->category_name
						.($active ? '</strong>' : '')
						.' </a>'
					;
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li data-row_count="'.$row_count.'"></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Sales Package Product Sidebar Category Tree List
 *
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_sale_package_sidebar_category_list'))
	{
		function create_sale_package_sidebar_category_list (
			array $categories, // the list of categories to list in a tree like manner already
			array $uri_segments, // categories in the uri
			$row_count = 0
		)
		{
			// set instances
			$CI =& get_instance();

			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled nested-nav" style="" data-row_count="'.$row_count.'">';

			$uri_segment_array = $CI->uri->segment_array();
			if ($CI->uri->segment(2) === 'dashboard')
			{
				array_shift($uri_segment_array); // salse
				array_shift($uri_segment_array); // dashboard
			}
			else
			{
				array_shift($uri_segment_array); // sales
				array_shift($uri_segment_array); // create
				array_shift($uri_segment_array); // step1
			}

			$link_pre =
				$CI->uri->segment(2) === 'purchase_orders'
				? 'sales/purchase_orders/create/step2/'
				: 'sales/create/step1/'
			;

			$temp_uri_segments = $uri_segments;
			if (in_array($CI->session->active_designer, $uri_segments))
			{
				$li_a_link = array($CI->session->active_designer);
			}
			else $li_a_link = array_diff($uri_segments, $uri_segment_array);
			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already active
				if ($uri_segments === $uri_segment_array)
				{
					$active = in_array($category->category_slug, $uri_segments) ? 'active': '';
				}
				else $active = '';

				// let do first row...
				if ($ic == 1)
				{
					// create link
					array_push($li_a_link, $category->category_slug);

					// first row is usually the top main category...
					echo '<li class="category_list '
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
						.'" '
						.$active
						.'><a href="'
						.site_url($link_pre.implode('/', $li_a_link))
						.'" style="'
						.(
							$CI->uri->uri_string() == $link_pre.implode('/', $li_a_link)
							? 'color:#23527c;text-decoration:underline;'
							: ''
						)
						.'"> '
						.($active ? '<strong>' : '')
						.$category->category_name
						.($active ? '</strong>' : '')
						.' </a>'
					;

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					// create new link
					$pop = array_pop($li_a_link);
					array_push($li_a_link, $category->category_slug);

					echo '</li><li class="category_list '
						.$category->category_id
						.' " data-category_id="'
						.$category->category_id
						.'" data-parent_category="'
						.$category->parent_category
						.'" data-category_slug="'
						.$category->category_slug
						.'" data-category_name="'
						.$category->category_name
						.'" data-category_level="'
						.$category->category_level
						.'" '
						.$active
						.'><a href="'
						.site_url($link_pre.implode('/', $li_a_link))
						.'" style="'
						.(
							$CI->uri->uri_string() == $link_pre.implode('/', $li_a_link)
							? 'color:#23527c;text-decoration:underline;'
							: ''
						)
						.'"> '
						.($active ? '<strong>' : '')
						.$category->category_name
						.($active ? '</strong>' : '')
						.' </a>'
					;
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '
						.($category->category_level == '1' ? 'ul-first-level' : '')
						.'"><li class="category_list '
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
						.'" '
						.$active
						.'><a href="'
						.site_url($link_pre.implode('/', $li_a_link))
						.'" style="'
						.(
							$CI->uri->uri_string() == $link_pre.implode('/', $li_a_link)
							? 'color:#23527c;text-decoration:underline;'
							: ''
						)
						.'"> '
						.($active ? '<strong>' : '')
						.$category->category_name
						.($active ? '</strong>' : '')
						.' </a>'
					;
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';

						// update link
						$pop = array_pop($li_a_link);
					}

					// append to link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '
						.($category->category_level == '1' ? 'ul-first-level' : '')
						.'"><li class="category_list '
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
						.'" '
						.$active
						.'><a href="'
						.site_url($link_pre.implode('/', $li_a_link))
						.'" style="'
						.(
							$CI->uri->uri_string() == $link_pre.implode('/', $li_a_link)
							? 'color:#23527c;text-decoration:underline;'
							: ''
						)
						.'"> '.
						($active ? '<strong>' : '')
						.$category->category_name
						.($active ? '</strong>' : '')
						.' </a>'
					;
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li data-row_count="'.$row_count.'"></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Admin Product Sidebar Category Tree List at Frontend Thumbs page
 *
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_admin_product_stocks_csv_sidebar_category_list'))
	{
		function create_admin_product_stocks_csv_sidebar_category_list (
			array $categories, // the list of categories to list in a tree like manner already
			array $uri_segments, // categories in the uri
			$row_count = 0
		)
		{
			// set instances
			$CI =& get_instance();

			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled nested-nav" style="" data-row_count="'.$row_count.'">';

			$uri_segment_array = $CI->uri->segment_array();
			array_shift($uri_segment_array); // admin
			array_shift($uri_segment_array); // products
			array_shift($uri_segment_array); // csv
			array_shift($uri_segment_array); // stocks_update
            array_shift($uri_segment_array); // index

			$temp_uri_segments = $uri_segments;
			if (in_array($CI->session->active_designer, $uri_segments))
			{
				$li_a_link = array($CI->session->active_designer);
			}
			else $li_a_link = array_diff($uri_segments, $uri_segment_array);
			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already active
				if ($uri_segments === $uri_segment_array)
				{
					$active = in_array($category->category_slug, $uri_segments) ? 'active': '';
				}
				else $active = '';

				// let do first row...
				if ($ic == 1)
				{
					// create link
					array_push($li_a_link, $category->category_slug);

					// first row is usually the top main category...
					echo '<li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.($category->with_children > 0 ? '#select_children' : site_url('admin/products/csv/stocks_update/index/'.implode('/', $li_a_link))).'" '.($category->with_children > 0 ? 'data-toggle="modal"' : '').' style="'.($CI->uri->uri_string() == 'admin/products/csv/stocks_update/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					// create new link
					$pop = array_pop($li_a_link);
					array_push($li_a_link, $category->category_slug);

					echo '</li><li class="category_list '.$category->category_id.' data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.($category->with_children > 0 ? '#select_children' : site_url('admin/products/csv/stocks_update/index/'.implode('/', $li_a_link))).'" '.($category->with_children > 0 ? 'data-toggle="modal"' : '').' style="'.($CI->uri->uri_string() == 'admin/products/csv/stocks_update/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.($category->with_children > 0 ? '#select_children' : site_url('admin/products/csv/stocks_update/index/'.implode('/', $li_a_link))).'" '.($category->with_children > 0 ? 'data-toggle="modal"' : '').' style="'.($CI->uri->uri_string() == 'admin/products/csv/stocks_update/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';

						// update link
						$pop = array_pop($li_a_link);
					}

					// append to link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.($category->with_children > 0 ? '#select_children' : site_url('admin/products/csv/stocks_update/index/'.implode('/', $li_a_link))).'" '.($category->with_children > 0 ? 'data-toggle="modal"' : '').' style="'.($CI->uri->uri_string() == 'admin/products/csv/stocks_update/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li data-row_count="'.$row_count.'"></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';

			// craete the modal
			echo '
				<!-- CSV STOCKS SELCT CHILDREN MODAL -->
				<div class="modal fade bs-modal-sm" id="select_children" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							</div>
							<div class="modal-body">
								<p class="modal-body-text">Please select lowest children category.</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
			';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Admin Product Sidebar Category Tree List at Frontend Thumbs page
 *
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_admin_inventory_physical_sidebar_category_list'))
	{
		function create_admin_inventory_physical_sidebar_category_list (
			array $categories, // the list of categories to list in a tree like manner already
			array $uri_segments, // categories in the uri
			$row_count = 0
		)
		{
			// set instances
			$CI =& get_instance();

			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled nested-nav" style="" data-row_count="'.$row_count.'">';

			$uri_segment_array = $CI->uri->segment_array();
			array_shift($uri_segment_array); // admin
			array_shift($uri_segment_array); // inventory
			array_shift($uri_segment_array); // physical/available/onorder
			array_shift($uri_segment_array); // index

			$temp_uri_segments = $uri_segments;
			if (in_array($CI->session->active_designer, $uri_segments))
			{
				$li_a_link = array($CI->session->active_designer);
			}
			else $li_a_link = array_diff($uri_segments, $uri_segment_array);
			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already active
				if ($uri_segments === $uri_segment_array)
				{
					$active = in_array($category->category_slug, $uri_segments) ? 'active': '';
				}
				else $active = '';

				// let do first row...
				if ($ic == 1)
				{
					// create link
					array_push($li_a_link, $category->category_slug);

					// first row is usually the top main category...
					echo '<li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/inventory/'.$CI->uri->segment(3).'/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/inventory/'.$CI->uri->segment(3).'/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					// create new link
					$pop = array_pop($li_a_link);
					array_push($li_a_link, $category->category_slug);

					echo '</li><li class="category_list '.$category->category_id.' " data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/inventory/'.$CI->uri->segment(3).'/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/inventory/'.$CI->uri->segment(3).'/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/inventory/'.$CI->uri->segment(3).'/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/inventory/'.$CI->uri->segment(3).'/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';

						// update link
						$pop = array_pop($li_a_link);
					}

					// append to link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url('admin/inventory/'.$CI->uri->segment(3).'/index/'.implode('/', $li_a_link)).'" style="'.($CI->uri->uri_string() == 'admin/inventory/'.$CI->uri->segment(3).'/index/'.implode('/', $li_a_link) ? 'color:#23527c;text-decoration:underline;' : '').'"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li data-row_count="'.$row_count.'"></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';
		}
	}

// ------------------------------------------------------------------------

/**
 * Create Admin Product Sidebar Category Tree List at Frontend Thumbs page
 *
 *
 * @access	public
 * @params	object and strings
 * @return	string/boolean false
 */
	if ( ! function_exists('create_admin_po_create_sidebar_category_list'))
	{
		function create_admin_po_create_sidebar_category_list (
			array $categories, // the list of categories to list in a tree like manner already
			array $uri_segments, // categories in the uri
			$row_count = 0
		)
		{
			// set instances
			$CI =& get_instance();

			if (empty($categories))
			{
				// nothing more to help with...
				return FALSE;
			}

			if (
				! $row_count
				OR $row_count == 0
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// open the list
			echo '<ul class="list-unstyled nested-nav" style="margin-left:15px;" data-row_count="'.$row_count.'">';

			$pre_link = 'admin/purchase_orders/create/step2/';

			// strip off segments from uri
			$uri_segment_array = $CI->uri->segment_array();
			array_shift($uri_segment_array); // admin
			array_shift($uri_segment_array); // purchase_order
			array_shift($uri_segment_array); // create
			array_shift($uri_segment_array); // step2

			/*
			// add designer to url link
			$temp_uri_segments = $uri_segments;
			if (in_array($CI->session->active_designer, $uri_segments))
			{
				$li_a_link = array($CI->session->active_designer);
			}
			else $li_a_link = array_diff($uri_segments, $uri_segment_array);
			*/
			// generate url link
			$li_a_link = array();
			$ic = 1;
			foreach ($categories as $category)
			{
				// set select if category is already active
				if ($uri_segments === $uri_segment_array)
				{
					$active = in_array($category->category_slug, $uri_segments) ? 'active': '';
				}
				else $active = '';

				// let do first row...
				if ($ic == 1)
				{
					// create link
					array_push($li_a_link, $category->category_slug);

					// first row is usually the top main category...
					echo '<li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url($pre_link.implode('/', $li_a_link)).'" style="font-size:0.8em;"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';

					// save as previous level
					$prev_level = $category->category_level;

					$ic++;
					continue;
				}

				// if same category level, close previous </li> and open another one
				if ($category->category_level == $prev_level)
				{
					// create new link
					$pop = array_pop($li_a_link);
					array_push($li_a_link, $category->category_slug);

					echo '</li><li class="category_list '.$category->category_id.' " data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url($pre_link.implode('/', $li_a_link)).'" style="font-size:0.8em;"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// NOTE: next greater level is always greater by only 1 level
				// if so, create new open list <ul>
				if ($category->category_level == $prev_level + 1)
				{
					// append to previous link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'" style="margin-left:15px;"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url($pre_link.implode('/', $li_a_link)).'" style="font-size:0.8em;"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if next category level is lower, close previous </li></ul> and open another one
				// dont forget to count the depth of levels
				if ($category->category_level < $prev_level)
				{
					for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
					{
						echo '</li></ul>';

						// update link
						$pop = array_pop($li_a_link);
					}

					// append to link
					array_push($li_a_link, $category->category_slug);

					echo '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'" style="margin-left:15px;"><li class="category_list '.$category->category_id.'" data-category_id="'.$category->category_id.'" data-parent_category="'.$category->parent_category.'" data-category_slug="'.$category->category_slug.'" data-category_name="'.$category->category_name.'" data-category_level="'.$category->category_level.'" '.$active.'><a href="'.site_url($pre_link.implode('/', $li_a_link)).'" style="font-size:0.8em;"> '.($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '').' </a>';
				}

				// if this is last row, close it
				// again, check coutn of depth of levels
				if ($ic == $row_count)
				{
					for ($deep = $category->category_level; $deep > 0; $deep--)
					{
						echo '</li data-row_count="'.$row_count.'"></ul>';
					}
					echo '</li>';
				}

				$prev_level = $category->category_level;
				$ic++;
			}

			// close the list
			echo '</ul>';
		}
	}

// ------------------------------------------------------------------------

/* End of file Sate_country_helper.php */
/* Location: ./application/helpers/Sate_country_helper.php */
