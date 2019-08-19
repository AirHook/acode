<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Categories Tree Class
 *
 * This class returns the list of designers served on the hub site
 *
 * Currently serving to information
 *
 *		url_array - array of slug
 *		list_array - array of webspace_name with slug as key
 *		list of child webspaces and its info
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Webspaces, Designers
 * @author		WebGuy
 * @link		max_category_level
 */
class Categories
{
	/**
	 * Somr particular parameter properties
	 *
	 * @var	string
	 */
	public $d_url_structure = '';
	public $vendor_id = '';
	//public $with_products = FALSE;
	//public $view_status = '';
	//public $special_sale = FALSE;

	/**
	 * Max Category Level
	 *
	 * @var	string
	 */
	public $max_category_level = '';

	/**
	 * Total Count of Categories
	 *
	 * @var	integer
	 */
	public $count_all = 0;

	/**
	 * Current num_row count of treelist
	 *
	 * @var	integer
	 */
	public $row_count = 0;

	/**
	 * Select and GET first row of result set
	 *
	 * @var	object
	 */
	public $first_row = '';


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
	public function __construct()
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->max_category_level = $this->_max_category_level();
		$this->count_all = $this->_count_all();

		log_message('info', 'Categories Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Category Tree List
	 *
	 * Filter list
	 *
	 * @params	array
	 * @return	FLASE on failure or no records
	 * @return	object on success
	 */
	public function treelist($params = array())
	{
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

		// set max category level in a variable to call on function one time only
		$max_cat_level = $this->max_category_level;

		if ($this->count_all > 0) /// -- AND $max_cat_level > 0
		{
			// set select string variables
			$select = '';
			$select_pre_last = '';
			$select_pre_last1i = '';
			$select_pre_last1 = '';
			$select_pre_last2 = '';
			$special_sale = '';
			$join = '';
			$order_by = '';

			// we create the necessary select clasuses according to the max cat level there is
			for($level = 1; $level <= $max_cat_level + 1; $level++)
			{
				// --> The SELECT clause and ORDER BY clause
				if ($level <= $max_cat_level)
				{
					// set a series of parent_order field to help determine the order and the tree level
					$select .= '(CASE WHEN c'.$level.'.category_slug = c'.($level + 1).'.category_slug THEN 0 ELSE 1 END) AS parent_order'.$level.', ';

					// get the parent category view status or set NULL if has no parent
					$select_pre_last = '(CASE WHEN c'.($level + 1).'.parent_category != c'.($level + 1).'.category_id THEN (SELECT view_status FROM categories WHERE category_id = c'.($level + 1).'.parent_category) ELSE NULL END) AS parent_view_status, ';

					// check if category has products regardless of designer
					$w_vendor_id = $this->vendor_id ? "AND tbl_product.vendor_id = '".$this->vendor_id."' ": '';
					$w_d_url_structure = $this->d_url_structure ? "designer.url_structure = '".$this->d_url_structure."' ".$w_vendor_id."AND (" : '';
					$select_pre_last1i = '(SELECT COUNT(*) FROM tbl_product LEFT JOIN designer ON designer.des_id = tbl_product.designer WHERE '.$w_d_url_structure.'cat_id LIKE c'.($level + 1).'.category_id OR cat_id LIKE CONCAT(c'.($level + 1).'.category_id, \',\') OR subcat_id LIKE c'.($level + 1).'.category_id OR subcat_id LIKE CONCAT(c'.($level + 1).'.category_id, \',\') OR categories LIKE CONCAT(\'%"\', c'.($level + 1).'.category_id, \'"%\')'.($this->d_url_structure ? ")": '').' AND tbl_product.view_status = \'Y\')';
					$select_pre_last1  = '(SELECT COUNT(*) FROM tbl_product LEFT JOIN designer ON designer.des_id = tbl_product.designer WHERE '.$w_d_url_structure.'cat_id LIKE c'.($level + 1).'.category_id OR cat_id LIKE CONCAT(c'.($level + 1).'.category_id, \',\') OR subcat_id LIKE c'.($level + 1).'.category_id OR subcat_id LIKE CONCAT(c'.($level + 1).'.category_id, \',\') OR categories LIKE CONCAT(\'%"\', c'.($level + 1).'.category_id, \'"%\')'.($this->d_url_structure ? ")": '').')';
					$select_pre_last2  = $select_pre_last1.' AS with_products, ';

					// check if category has children
					//$has_children = '(SELECT COUNT(*) FROM categories cp WHERE cp.parent_category = CONCAT(c'.($level + 1).'.category_id, \',\')) AS with_children, ';
					$has_children = '(SELECT COUNT(*) FROM categories cp WHERE cp.parent_category = CONCAT(c'.($level + 1).'.category_id, \',\') AND (SELECT COUNT(*) FROM tbl_product LEFT JOIN designer ON designer.des_id = tbl_product.designer WHERE '.$w_d_url_structure.'cat_id LIKE cp.category_id OR cat_id LIKE CONCAT(cp.category_id, \',\') OR subcat_id LIKE cp.category_id OR subcat_id LIKE CONCAT(cp.category_id, \',\') OR categories LIKE CONCAT(\'%"\', cp.category_id, \'"%\')'.($this->d_url_structure ? ")": '').' AND tbl_product.view_status = \'Y\') != \'0\') AS with_children, ';

					// for sepcial sale conditions
					$special_sale = '(SELECT COUNT(*) FROM tbl_product LEFT JOIN tbl_stock ON table_stock.prod_no = tbl_product.prod_no WHERE categories = c'.($level + 1).'.category_id AND tbl_stock.custom_order = \'3\' AND tbl_product.view_status = \'Y\')';

					// get all the information of the categories
					$select_last = 'c'.($level + 1);

					// set the order by series
					$order_by .=
						($level > 1 ? ', ' : '')
						.'c'.$level.'.view_status DESC, ' // sort the view status per level first
						.'c'.$level.'.category_seque ASC, ' // then sort the seque
						.'c'.$level.'.category_slug ASC, ' // then sort the slug
						.'parent_order'.$level.' ASC ' // then sort the parent order
					;
				}
				else
				{
					$select_last = 'c'.($level);
				}

				// --> The JOIN clauses
				// start creating join clauses at level 2
				if ($level == 2)
				{
					$join = 'LEFT JOIN categories c'.$level.' ON c'.$level.'.parent_category = c'.($level - 1).'.category_id ';
				}
				elseif ($level > 2)
				{
					$join_str1 = 'c'.$level.'.parent_category = c'.($level - 1).'.category_id ';

					$join_str2 = 'AND c'.$level.'.category_level != "'.($level - 2).'" ';

					$join_str3 = 'c'.$level.'.category_id = c'.($level - 1).'.category_id AND (';
					$join_str4 = 'c'.$level.'.category_level = "'.($level - 2).'" ';

					if ($level > 3)
					{
						for($i = $level - 3; $i > 0; $i--)
						{
							$join_str2 .= 'AND c'.$level.'.category_level != "'.$i.'" ';
							$join_str4 .= 'OR c'.$level.'.category_level = "'.$i.'" ';
						}
					}

					$join_str4 .= ')';

					$join .= 'LEFT JOIN categories c'.$level.' ON ('.$join_str1.$join_str2.') OR ('.$join_str3.$join_str4.')';
				}
			}

			// --> The WHERE clauses
			// finalize where clauses based on params
			$where_first = "(".$select_last.".view_status = '0' OR ".$select_last.".view_status = '1')";
			$where_last = '';
			if ( ! empty($params))
			{
				foreach ($params as $key => $val)
				{
					switch ($key)
					{
						case 'd_url_structure':
							if ( ! empty($val))
							{
								$where_last .= "AND ".$select_last.".".$key." LIKE '%".$val."%' ";
							}
						break;

						case 'with_products':
							$where_last .= "AND ".$select_pre_last1i." ".($val ? '!=' : '=')." '0' ";
						break;

						case 'vendor_id':
							//$where_last .= "AND ".$select_pre_last1i." ".($val ? '!=' : '=')." '0' ";
						break;

						case 'view_status':
							$where_first = $select_last.".view_status = '".$val."' ";
						break;

						case 'special_sale':
							$where_first = "AND ".$special_sale." ".($val ? '!=' : '=')." '0' ";
						break;

						default:
							$has_operand = preg_match('/(<|>|!|=|\sIS NULL|\sIS NOT NULL|\sEXISTS|\sBETWEEN|\sLIKE|\sIN\s*\(|\s)/i', trim($key));
							$where_last.= " AND ".$select_last.".".$key.($has_operand ? " '" : " = '").$val."'";
					}
				}
			}

			// set the query string
			$sel = "
				SELECT
					".$select.$select_pre_last.$select_pre_last2.$has_children.$select_last.".*
				FROM
					categories c1
					".$join."
				WHERE
					".$where_first."
					AND ".$select_last.".category_id IS NOT NULL
					".$where_last."
				ORDER BY
					".$order_by.($max_cat_level > 0 ? ', ' : '')
					.$select_last.".view_status DESC, "	// finally, sort by view status first
					.$select_last.".category_seque ASC, " // then, sort by seque
					.$select_last.".category_slug ASC" // then, sort by slug
			;

			// run the query
			$query = $this->DB->query($sel);

			// for debuggin purposes
			//echo $sel; die();
			//echo $this->DB->last_query(); die();
			//echo '<pre>'; print_r($params); die();

			// get the num_rows
			$this->row_count = $query->num_rows();

			// return the query
			return $query->result();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Count All
	 *
	 * Count all categories
	 *
	 * @access	public
	 * @return	boolean FALSE/number_format
	 */
	private function _count_all()
	{
		return $this->DB->count_all('categories');
	}

	// --------------------------------------------------------------------

	/**
	 * Max category level
	 *
	 * @access	public
	 * @return	boolean FALSE/number_format
	 */
	private function _max_category_level()
	{
		$this->DB->select_max('category_level', 'max_category_level');
		$query = $this->DB->get('categories');

		if ($query->num_rows() > 0)
		{
			return $query->row()->max_category_level;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Change of categor level of children
	 *
	 * @access	public
	 * @return	boolean FALSE/number_format
	 */
	public function children_change_level($category_id = '', $levels = 0, $del = FALSE)
	{
		if ($category_id === '' OR $levels === 0)
		{
			// nothing more to do...
			return FALSE;
		}

		// load libraries/models/helpers
		$this->CI->load->library('categories/category_details');

		// initialize item details (with catch error)
		if ( ! $this->CI->category_details->initialize(array('category_id' => $category_id)))
		{
			// nothing more to do...
			return FALSE;
		}

		// check if category has children
		$get_children = $this->get_children($category_id);

		if ($get_children)
		{
			// set an array of child(id)=>parent(id) data
			$child_par_ary = array();

			// before updating levels, we check if item for deletion has parent category
			if ($category_id == $this->CI->category_details->parent_category) $item_parent = FALSE;
			else $item_parent = $this->CI->category_details->parent_category;

			foreach ($get_children as $child)
			{
				// it is safe to gather the child(id)=>parent(id) data
				// in this foreach as children are sorted by category level
				$child_par_ary[$child->category_id] = $child->parent_category;

				// check if current child is a sub child
				// by checking if parent id is present in created array key
				$sub_child = array_key_exists($child->parent_category, $child_par_ary);

				// this for delete only..................
				// first level children
				// and item has no parent, child becomes parent of it's own, or, get's item's parent
				// otherwise, children just goes up the level retaining parent category
				if ( ! $sub_child && $del)
				{
					$this->DB->set('parent_category', ($item_parent ?: $child->category_id));
				}

				// note that $levels if positive meaning going up the tree
				// else, going down the tree
				$this->DB->set('category_level', ($child->category_level - $levels));
				$this->DB->where('category_id', $child->category_id);
				$this->DB->update('categories');
			}

			return TRUE;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Child Categories
	 *
	 * @params	string
	 * @access	public
	 * @return	boolean FALSE/object or array
	 */
	public function get_children($parent_category = '', $return_array = FALSE)
	{
		if ($parent_category === '')
		{
			// nothing more to do...
			return FALSE;
		}

		// --> The WHERE clauses start
		$where = "category_id != '".$parent_category."' AND parent_category = '".$parent_category."'";

		// let's get all the category id's of the children

		// 1st level categories
		$this->DB->where('parent_category', $parent_category);
		$this->DB->where('category_id !=', $parent_category);
		$q1 = $this->DB->get('categories');

		if ($q1->num_rows() > 0)
		{
			foreach ($q1->result() as $r1)
			{
				$where .= " OR parent_category = '".$r1->category_id."'";

				if ($r1->category_level < $this->_max_category_level())
				{
					// 2nd level categories
					$this->DB->where('parent_category', $r1->category_id);
					$q2 = $this->DB->get('categories');

					if ($q2->num_rows() > 0)
					{
						foreach ($q2->result() as $r2)
						{
							$where .= " OR parent_category = '".$r2->category_id."'";

							if ($r2->category_level < $this->_max_category_level())
							{
								// 3nd level categories
								$this->DB->where('parent_category', $r2->category_id);
								$q3 = $this->DB->get('categories');

								if ($q3->num_rows() > 0)
								{
									foreach ($q3->result() as $r3)
									{
										$where .= " OR parent_category = '".$r3->category_id."'";

										if ($r3->category_level < $this->_max_category_level())
										{
											// 4th level categories
											$this->DB->where('parent_category', $r3->category_id);
											$q4 = $this->DB->get('categories');

											if ($q4->num_rows() > 0)
											{
												foreach ($q4->result() as $r4)
												{
													$where .= " OR parent_category = '".$r4->category_id."'";

													if ($r4->category_level < $this->_max_category_level())
													{
														// 5th level categories
														$this->DB->where('parent_category', $r4->category_id);
														$q5 = $this->DB->get('categories');

														if ($q5->num_rows() > 0)
														{
															foreach ($q5->result() as $r5)
															{
																$where .= " OR parent_category = '".$r5->category_id."'";

																// ...do we need a 6th level?
																// add code here when necessary
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$this->DB->select('*');
		$this->DB->select('
			(CASE
				WHEN EXISTS (SELECT * FROM tbl_product WHERE tbl_product.categories LIKE CONCAT(\'%"\', category_id, \'"%\'))
				THEN "1"
				ELSE "0"
			END) AS with_products
		');
		$this->DB->select('
			(SELECT COUNT(*)
				FROM tbl_product
				WHERE view_status = \'Y\'
					AND public = \'Y\'
					AND publish = \'1\'
					AND categories LIKE CONCAT(\'%"\', category_id, \'"%\')
			) AS with_visible_products
		');
		$this->DB->where($where);
		$this->DB->order_by('category_level', 'ASC');
		$this->DB->order_by('category_seque', 'ASC');
		$query = $this->DB->get('categories');

		//echo $this->DB->last_query(); die();

		if ($return_array)
		{
			$array = array();
			if ($query->num_rows() == 0)
			{
				// nothing more to do...
				return FALSE;
			}
			else
			{
				foreach ($query->result() as $row)
				{
					array_push($array, $row->category_id);
				}
				asort($array);

				return $array;
			}
		}
		else
		{
			if ($query->num_rows() > 0)
			{
				return $query->result();
			}
			else return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Parent Categories
	 *
	 * @params	string
	 * @access	public
	 * @return	boolean FALSE/object or array
	 */
	public function get_parents($category_id = '')
	{
		if ($category_id === '')
		{
			// nothing more to do...
			return FALSE;
		}

		$array_of_parents = array();

		$end_category_id = '';
		$current_category_id = $category_id;

		while ($current_category_id != $end_category_id)
		{
			$this->DB->select('parent_category');
			$this->DB->where('category_id', $current_category_id);
			$q = $this->DB->get('categories');
			$r = $q->row();

			if ($r->parent_category == $current_category_id)
			{
				// no parents
				$end_category_id = $current_category_id;
			}
			else
			{
				array_push($array_of_parents, $r->parent_category);
				$current_category_id = $r->parent_category;
			}
		}

		if ( ! empty($array_of_parents))
		{
			return $array_of_parents;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Select and Get Categories list
	 *
	 * @params	array
	 * @access	public
	 * @return	boolean FALSE/object
	 */
	public function select(array $where = array())
	{
		// set custom where conditions
		$where_clause = '';
		if ( ! empty($where))
		{
			$w = 0;
			foreach ($where as $key => $val)
			{
				$has_operand = preg_match('/(<|>|!|=|\sIS NULL|\sIS NOT NULL|\sEXISTS|\sBETWEEN|\sLIKE|\sIN\s*\(|\s)/i', trim($key));

				if ($val !== '')
				{
					if ($w == 0) $where_clause.= $key.($has_operand ? " '" : " = '").$val."'";
					else $where_clause.= " AND ".$key.($has_operand ? " '" : " = '").$val."'";
				}

				$w++;
			}
		}

		// user query string
		$qry = '
			SELECT *
			FROM categories
			WHERE
				'.($where_clause ? $where_clause.' AND ' : '').'
				EXISTS (
					SELECT COUNT(*)
					FROM tbl_product
					WHERE tbl_product.categories LIKE CONCAT(\'%"\', categories.category_id, \'"%\')
				)
			ORDER BY category_seque ASC
		';

		// get records
		$query = $this->DB->query($qry);

		//echo $this->DB->last_query(); die();

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$this->first_row = $query->first_row();

			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Categories list
	 *
	 * @params	string
	 * @access	public
	 * @return	boolean FALSE/array
	 */
	public function array_list(array $params = array())
	{
		$array = array();

		// set properties where available
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if ($key == 'd_url_structure')
					$this->DB->like('d_url_structure', $val, 'both');
				else
					$this->DB->where($key, $val);
			}
		}

		$this->DB->select('category_slug');
		$query = $this->DB->get('categories');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			foreach ($query->result() as $row)
			{
				if ($row->category_slug !== 'apparel')
					array_push($array, $row->category_slug);
			}
			asort($array);

			return $array;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Categoriy ID
	 *
	 * @params	string
	 * @access	public
	 * @return	strign/boolean FALSE
	 */
	public function get_id($category_slug = '')
	{
		if ( ! $category_slug)
		{
			// nothign more to do...
			return FALSE;
		}

		$this->DB->select('category_id');
		$this->DB->where('category_slug', $category_slug);
		$query = $this->DB->get('categories');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$row = $query->row();

			return $row->category_id;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Categoriy ID
	 *
	 * @params	string
	 * @access	public
	 * @return	strign/boolean FALSE
	 */
	public function get_slug($category_id = '')
	{
		if ( ! $category_id)
		{
			// nothign more to do...
			return FALSE;
		}

		$this->DB->select('category_slug');
		$this->DB->where('category_id', $category_id);
		$query = $this->DB->get('categories');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$row = $query->row();

			return $row->category_slug;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Categoriy ID
	 *
	 * @params	string
	 * @access	public
	 * @return	strign/boolean FALSE
	 */
	public function get_name($slug = '')
	{
		if ( ! $slug)
		{
			// nothign more to do...
			return FALSE;
		}

		$this->DB->select('category_name');
		$this->DB->where('category_slug', $slug);
		$query = $this->DB->get('categories');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$row = $query->row();

			return $row->category_name;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Categoriy ID
	 *
	 * @params	string
	 * @access	public
	 * @return	array/boolean FALSE
	 */
	public function get_linked_designers($category_id = '', $des_ary = array())
	{
		if ($category_id == '' OR empty($des_ary))
		{
			// nothign more to do...
			return FALSE;
		}

		$des_slugs = array();

		$this->DB->select('designer.url_structure');
		$this->DB->from('tbl_product');
		$this->DB->join('designer', 'designer.des_id = tbl_product.designer');
		$this->DB->like('categories', '"'.$category_id.'"');
		$this->DB->where_in('tbl_product.designer', $des_ary);
		$this->DB->group_by('designer.url_structure');
		$query = $this->DB->get();

		//echo $this->DB->last_query(); die();

		if ($query && $query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			foreach ($query->result() as $row)
			{
				array_push($des_slugs, $row->url_structure);
			}

			return $des_slugs;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Categoriy General Icon
	 *
	 * @params	$id -> string
	 *			$general -> TRUE (for general icons), string (designer slug for designer icons)
	 * @access	public
	 * @return	string/boolean FALSE
	 */
	public function get_icon($id = '', $slug = 'general')
	{
		if ($id == '')
		{
			// nothign more to do...
			return FALSE;
		}

		$query = $this->DB->get_where('categories', array('category_id' => $id));

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$row = $query->row();

			$ld = json_decode($row->d_url_structure , TRUE);
			$linked_designers =
				json_last_error() === JSON_ERROR_NONE
				? $ld
				: explode(',', $row->d_url_structure)
			;
			$ii = json_decode($row->icon_image , TRUE);
			$icon_images =
				json_last_error() === JSON_ERROR_NONE
				? $ii
				:	explode(',', $row->icon_image)
			;
			//$linked_designers = explode(',', $row->d_url_structure);
			//$icon_images = explode(',', $row->icon_image);

			$is_assoc = $this->_is_assoc($linked_designers);

			if ($slug !== 'general')
			{
				if ($is_assoc) $key = array_search($slug, $linked_designers);
				else $key = array_search($slug, $linked_designers) + 1;
			}
			else
			{
				if ($is_assoc) $key = 'general';
				else $key = 0;
			}

			if ( ! empty($icon_images[$key])) return $icon_images[$key];
			else return FALSE;
		}
	}

	// ----------------------------------------------------------------------

	private function _is_assoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

	// --------------------------------------------------------------------

	public function get_general_icon($id = '', $slug = 'general')
	{
		return FALSE;
	}
}
