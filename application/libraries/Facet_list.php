<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Facet List Class
 *
 * This class list all facets on a certain facet group
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Facets
 * @author		WebGuy
 * @link
 */
class Facet_list
{
	/**
	 * First row results object
	 *
	 * @var	object
	 */
	public $first_row = '';

	/**
	 * Current num_row count of object
	 * With or without limits
	 *
	 * @var	integer
	 */
	public $row_count = 0;


	/**
	 * This Class database object holder
	 *
	 * @var	object
	 */
	protected $DB = '';

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
	 * @param	array	$param	Initialization parameter - the item id
	 *
	 * @return	void
	 */
	public function __construct(array $param = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Facets Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Get all facets
	 *
	 * @return	void
	 */
	public function get($facet = '')
	{
		if (empty($facet))
		{
			// nothing more to do...
			return FALSE;
		}

		// facet related query builder classes
		switch ($facet)
		{
			case 'color_facets':
				$table = 'tblcolors';
				$this->DB->order_by('color_name', 'asc');
			break;

			case 'styles':
				$table = 'tblstyle';
				$this->DB->order_by('style_name', 'asc');
			break;

			case 'events':
				$table = 'tblevent';
				$this->DB->order_by('event_name', 'asc');
			break;

			case 'materials':
				$table = 'tblmaterial';
				$this->DB->order_by('material_name', 'asc');
			break;

			case 'trends':
				$table = 'tbltrend';
				$this->DB->order_by('trend_name', 'asc');
			break;

			case 'seasons':
				$table = 'tblseason';
				$this->DB->order_by('season_name', 'asc');
			break;
		}

		$query = $this->DB->get($table);

		//echo $this->DB->last_query(); die();

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$this->row_count = $query->num_rows();
			$this->first_row = $query->first_row();

			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

}
