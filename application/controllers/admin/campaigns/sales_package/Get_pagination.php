<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_pagination extends Admin_Controller {

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
		$num_links = 4;
		$lowest_cur = $cur > $num_links ? $cur - $num_links : 1;
		$highest_cur = $cur < ($end_cur - $num_links) ? $cur + $num_links : $end_cur;

		// set prev and next cur
		$prev_cur = $cur - 1;
		$next_cur = $cur + 1;

		$html = '<li>&nbsp; &nbsp;</li>';

		if ($cur == 2)
		{
			$html.= '
				<li>
					<a href="#cur_users_1" data-toggle="tab" data-cur="1">
						<i class="fa fa-angle-left"></i>
					</a>
				</li>
			';
		}

		if ($cur >= 3)
		{
			$html.= '
				<li>
					<a href="#cur_users_1" data-toggle="tab" data-cur="1">
						<i class="fa fa-angle-double-left"></i>
					</a>
				</li>
				<li>
					<a href="#cur_users_'.$prev_cur.'" data-toggle="tab" data-cur="'.$prev_cur.'">
						<i class="fa fa-angle-left"></i>
					</a>
				</li>
			';
		}

		for ($c = $lowest_cur;$c <= $highest_cur;$c++)
		{
			$active = $c == $cur ? 'active' : '';

			$html.= '
				<li class="'.$active.'">
					<a href="#cur_users_'.$c.'" data-toggle="tab" data-cur="'.$c.'"> '.(($lowest_cur > 1 && $lowest_cur == $c) ? '... ' : '').$c.(($highest_cur < $end_cur && $highest_cur == $c) ? ' ...' : '').' </a>
				</li>
			';
		}

		if ($cur <= ($end_cur - 2))
		{
			$html.= '
				<li>
					<a href="#cur_users_'.$next_cur.'" data-toggle="tab" data-cur="'.$next_cur.'">
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
				<li>
					<a href="#cur_users_'.$end_cur.'" data-toggle="tab" data-cur="'.$end_cur.'">
						<i class="fa fa-angle-double-right"></i>
					</a>
				</li>
			';
		}

		if ($cur == ($end_cur - 1))
		{
			$html.= '
				<li>
					<a href="#cur_users_'.$next_cur.'" data-toggle="tab" data-cur="'.$next_cur.'">
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
			';
		}

		$html.= '<li>&nbsp; &nbsp;</li>';

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
