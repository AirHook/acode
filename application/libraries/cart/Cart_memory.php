<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Cart Memory Class
 *
 * This class' takes in vital product details info of each item in the cart
 * and saves it to memory for each user so as to be able to reload cart items
 * on the premise that user did not finish cart checkout process and came
 * back after a while (possibly days) and wants to continue with previous
 * cart added items
 *
 * 2 cases to save as memory:
 * WS - use user details 'options' field - options['cart'] = array (prod_sku, size, qty)
 * CS - use cookies, unless it's a login user then use user 'options' field as well
 *
 * This options['cart'] / cookie['cart'] will only be set and will stay alive
 * only during the entire checkout process. Once order is submitted, and,
 * when cart is emtpy, the memory field must be unset.
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Cart
 * @author		WebGuy
 * @link
 */
class Cart_memory
{
	/**
	 * Cookie Name
	 *
	 * @var	string
	 */
	public $cookie_name = '';

	/**
	 * User Details
	 *
	 * @var	array
	 */
	public $user_details = array();


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
	 * @param	array
	 * @return	void
	 */
	public function __construct($param = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Cart Memory Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Add WS Memory
	 * Save cart items into wholesale user memory via options['cart'] key
	 * Values contain an array representation of each item in the cart
	 * array(array($prod_sku, $size, $qty), array($prod_sku, $size, $qty))
	 *
	 * @return	boolean
	 */
	public function cart_mem_ws()
	{
		if (
			empty($this->CI->cart->contents())
			OR empty($this->user_details)
		)
		{
			// nothing more to do...
			return FALSE;
		}

		// grab options data
		$options = $this->user_details['options'];

		// insert new memory of updated cart
		$options['cart'] = $this->CI->cart->contents();

		// update recrods
		$this->DB->set('options', json_encode($options));
		$this->DB->where('user_id', $this->user_details['user_id']);
		$this->DB->update('tbluser_data_wholesale');

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Add Cookie Memory
	 * We use cookie to remember CS cart items
	 * array(array($prod_sku, $size, $qty), array($prod_sku, $size, $qty))
	 *
	 * @return	void
	 */
	public function cart_mem_cookie()
	{
		if (empty($this->CI->cart->contents()))
		{
			// nothing more to do...
			return FALSE;
		}

		// set cookie with udpate cart details
		$params['expires'] = time()+(60*60*24*30);
		$params['path'] = '/';
		//setcookie($this->CI->webspace_details->slug.'_cart', json_encode($this->CI->cart->contents()), $options);
		if (setcookie($this->CI->webspace_details->slug.'_cart', json_encode($this->CI->cart->contents()), $params))
		{
			echo 'cookie set<br />';
		}
		else echo 'cookie not set<br />';

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Unset WS option
	 *
	 * @return	void
	 */
	public function unset_ws()
	{
		// grab options data
		$options = $this->user_details['options'];

		// add/update new item
		unset($options['cart']);

		// update recrods
		$this->DB->set('options', json_encode($options));
		$this->DB->where('user_id', $this->user_details['user_id']);
		$this->DB->update('tbluser_data_wholesale');
	}

	// --------------------------------------------------------------------

	/**
	 * Unset Cookie
	 *
	 * @return	void
	 */
	public function unset_cookie()
	{
		unset($_COOKIE[$this->CI->webspace_details->slug.'_cart']);
	}

	// --------------------------------------------------------------------

}
