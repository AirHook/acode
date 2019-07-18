<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Sidebar Categories Tree Class
 *
 * This class creates a category tree usually for use on sidebars to
 * navigate between categories
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Categories
 * @author		WebGuy
 * @link
 */
class Sidebar_categories
{
	/**
	 * Params
	 *
	 * @var	mixed
	 */
	public $base_url = '';
	public $url_segments = array();
	public $categories = '';
	public $categories_count = 0;
	public $a_styles = '';
	public $ul_classes = '';
	public $sub_ul_margin = '';
	public $li_classes = '';
	public $li_styles = '';


	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @params	string
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		// load libaries/models/helpers
		//$this->CI->load->helper('url');

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($params);
		log_message('info', 'Sidebar Categories Tree Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Class
	 *
	 * @return	mixed properties
	 */
	public function initialize($params = array())
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// set properties where available
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if (property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}

		// trim base_url of beginning and end slashes and add end slash
		$this->base_url = trim($this->base_url, '/').'/';

		// set url segments where empty
		$this->url_segments = $this->url_segments ?: $this->CI->uri->segment_array();

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Create List
	 *
	 * @return	string
	 */
	public function create_list()
	{
		$html = '<ul class="list-unstyled nested-nav '.$this->ul_classes.'" style="margin-left:15px;" data-row_count="'.$this->categories_count.'">';

		$li_a_link = array();
		$ic = 1;
		foreach ($this->categories as $category)
		{
			// set active for active category
			$active = in_array($category->category_slug, $this->url_segments) ? 'active' : '';

			// let do first row...
			if ($ic == 1)
			{
				// create link
				array_push($li_a_link, $category->category_slug);

				// first row is usually the top main category...
				$html.= '<li class="category_list '.$category->category_id.' '.$this->li_classes.'" style="'.$this->li_styles.'" '.$active.'>';
				$html.= '<a href="'.site_url($this->base_url.implode('/', $li_a_link)).'" style="'.$this->a_styles.'">';
				$html.= ($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '');
				$html.= '</a>';

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

				$html.= '</li><li class="category_list '.$category->category_id.' '.$this->li_classes.'" style="'.$this->li_styles.'" '.$active.'>';
				$html.= '<a href="'.site_url($this->base_url.implode('/', $li_a_link)).'" style="'.$this->a_styles.'">';
				$html.= ($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '');
				$html.= '</a>';
			}

			// NOTE: next greater level is always greater by only 1 level
			// if so, create new open list <ul>
			if ($category->category_level == $prev_level + 1)
			{
				// append to link
				array_push($li_a_link, $category->category_slug);

				$html.= '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'" style="'.$this->sub_ul_margin.'">';
				$html.= '<li class="category_list '.$category->category_id.' '.$this->li_classes.'" style="'.$this->li_styles.'" '.$active.'>';
				$html.= '<a href="'.site_url($this->base_url.implode('/', $li_a_link)).'" style="'.$this->a_styles.'">';
				$html.= ($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '');
				$html.= '</a>';
			}

			// if next category level is lower, close previous </li></ul> and open another one
			// dont forget to count the depth of levels
			if ($category->category_level < $prev_level)
			{
				// for each depth, cloase ul and pop link
				for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
				{
					$html.= '</li></ul>';

					// update link
					$pop = array_pop($li_a_link);
				}

				// append to remainder link
				array_push($li_a_link, $category->category_slug);

				$html.= '<ul class="list-unstyled '.($category->category_level == '1' ? 'ul-first-level' : '').'" style="'.$this->sub_ul_margin.'">';
				$html.= '<li class="category_list '.$category->category_id.' '.$this->li_classes.'" style="'.$this->li_styles.'" '.$active.'>';
				$html.= '<a href="'.site_url($this->base_url.implode('/', $li_a_link)).'" style="'.$this->a_styles.'">';
				$html.= ($active ? '<strong>' : '').$category->category_name.($active ? '</strong>' : '');
				$html.= '</a>';
			}

			// if this is last row, close it
			// again, check count of depth of levels
			if ($ic == $this->categories_count)
			{
				// for each depth, cloase ul and pop link
				for ($deep = $category->category_level; $deep > 0; $deep--)
				{
					$html.= '</li></ul>';
				}
				$html.= '</li>';
			}

			$prev_level = $category->category_level;
			$ic++;
		}

		$html.= '</ul>';

		return $html;
	}

	// --------------------------------------------------------------------

}
