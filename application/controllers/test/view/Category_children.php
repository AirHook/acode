<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 *
 */
class Category_children extends MY_Controller
{
	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index($parent_category = '185', $designer = '', $return_array = FALSE, $primary_subcat = '')
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
		if ($designer) $this->DB->like('d_url_structure', $designer);
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

				//return $array;
				echo '<pre>';
				print_r($array);
			}
		}
		else
		{
			if ($query->num_rows() > 0)
			{
				//return $query->result();
				echo '<pre>';
				foreach($query->result() as $category)
				{
					print_r($category);
					echo '<br />';
				}
			}
			//else return FALSE;
		}

		exit;
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

}
