<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_pagination extends MY_Controller {

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
	 * Index - Sales Package View
	 *
	 * Open and view existing sales package for edit/sending
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('users/admin_user_details');

		// get admin login details
		if ($this->session->admin_loggedin)
		{
			$this->admin_user_details->initialize(
				array(
					'admin_id' => $this->session->admin_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'There is no post data.';
			exit;
		}

		// grab the post variable
		//$cur = '8';
		$cur = $this->input->post('cur');
		$end_cur = $this->input->post('end_cur');

		// get lowest and highest 5 tabs from current
		$num_links = 2;
		$lowest_cur = $cur > $num_links ? $cur - $num_links : 1;
		$highest_cur = $cur < ($end_cur - $num_links) ? $cur + $num_links : $end_cur;

		// set prev and next cur
		$prev_cur = $cur - 1;
		$next_cur = $cur + 1;

		$html = '';
		if ($cur == 2)
		{
			$html.= '
				<li class="prev-page">
					<a href="javascript:;" data-cur_page="1">
						<i class="fa fa-angle-left"></i>
					</a>
				</li>
			';
		}

		if ($cur >= 3)
		{
			$html.= '
				<li class="frist-page">
					<a href="javascript:;" data-cur_page="1">
						<i class="fa fa-angle-double-left"></i>
					</a>
				</li>
				<li class="prev-page">
					<a href="javascript:;" data-cur_page="'.$prev_cur.'">
						<i class="fa fa-angle-left"></i>
					</a>
				</li>
			';
		}

		for ($c = $lowest_cur;$c <= $highest_cur;$c++)
		{
			$active = $c == $cur ? 'active' : '';
			$page_one = $c == 1 ? 'page-one' : '';

			$html.= '
				<li class="page-number '.$page_one.' '.$active.'">
					<a href="javascript:;" data-cur_page="'.$c.'"> '.(($lowest_cur > 1 && $lowest_cur == $c) ? '... ' : '').$c.(($highest_cur < $end_cur && $highest_cur == $c) ? ' ...' : '').' </a>
				</li>
			';
		}

		if ($cur <= ($end_cur - 2))
		{
			$html.= '
				<li class="next-page">
					<a href="javascript:;" data-cur_page="'.$next_cur.'">
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
				<li class="last-page">
					<a href="javascript:;" data-cur_page="'.$end_cur.'">
						<i class="fa fa-angle-double-right"></i>
					</a>
				</li>
			';
		}

		if ($cur == ($end_cur - 1))
		{
			$html.= '
				<li class="next-page">
					<a href="javascript:;" data-cur_page="'.$next_cur.'">
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
			';
		}

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
