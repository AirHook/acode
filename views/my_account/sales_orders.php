<?php
/*********
 * Notification area
 */
?>
<div class="norifications">
	<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
	<div class="alert alert-danger auto-remove">
		<button class="close" data-close="alert"></button> An error occured. Please try again.
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('error') == 'wrong_user_role') { ?>
	<div class="alert alert-danger auto-remove">
		<button class="close" data-close="alert"></button> Hmmm... The Sales Order you are accessing isn't in your list.
	</div>
	<?php } ?>
</div>
<div class="table-toolbar">

	<style>
		.nav > li > a {
			padding: 8px 15px;
			background-color: #eee;
			color: #555;
		}
		.nav-tabs > li > a {
			font-size: 12px;
		}
		.nav-tabs > li > a:hover {
			background-color: #333;
			color: #eee;
		}
	</style>
	<ul class="nav nav-tabs">
		<li class="<?php echo $this->uri->uri_string() == 'my_account/sales/orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/orders'); ?>">
				All Sales Orders
			</a>
		</li>
	</ul>
	<br />
	<?php if (@$search) { ?>
	<h1><small><em>Search results for:</em></small> "<?php echo @$search_string; ?>"</h1>
	<br />
	<?php } ?>
</div>
<?php
/*********
 * This style a fix to the dropdown menu inside table-responsive table-scrollable
 * datatables. Setting position to relative allows the main dropdown button to
 * follow cell during responsive mode. A jquery is also needed on the button to
 * toggle class to change back position to absolute so that the dropdown menu
 * shows even on overflow
 */
?>
<style>
	.dropdown-fix {
		position: relative;
	}
</style>
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-orders" data-orders_count="<?php echo $this->sales_orders_list->row_count; ?>">
	<thead>
		<tr>
			<th class="hidden-xs hidden-sm" style="width:30px"> <!-- counter --> </th>
			<th class="text-center" style="width:30px">
				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
					<input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-orders .checkboxes" />
					<span></span>
				</label>
			</th>
			<th> SO Number </th>
			<th> SO Date </th>
			<th> Product Items </th>
			<th> Store Name </th>
			<th> Designer </th>
			<th> Author </th>
			<th style="width:100px;"> Status </th> <!-- // 1-pending,2-hold,3-return,4-intransit,5-complete -->
		</tr>
	</thead>
	<tbody>

		<?php
		if ($orders)
		{
			$i = 1;
			foreach ($orders as $order)
			{
				$edit_link =
					site_url($this->uri->segment(1).'/sales_orders/details/index/'.$order->sales_order_id)
				; ?>

		<tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
			<td class="hidden-xs hidden-sm">
				<?php echo $i; ?>
			</td>
			<td class="text-center">
				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
					<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $order->sales_order_id; ?>" />
					<span></span>
				</label>
			</td>
			<td>
				<a href="<?php echo $edit_link; ?>">
					<?php
					$so_number = $order->sales_order_number;
					for($c = strlen($so_number);$c < 6;$c++)
					{
						$so_number = '0'.$so_number;
					}
					echo $so_number;
					?>
				</a>
				<a href="<?php echo $edit_link; ?>" class="hidden_first_edit_link_" style="font-size:0.7em;display:inline-block;">
					<cite>view details</cite>
				</a>
			</td>
			<td>
				<?php echo @date('Y-m-d', $order->sales_order_date); ?>
			</td>
			<td>
				<?php
				$items = json_decode($order->items, TRUE);
				foreach ($items as $key => $val)
				{
					$exp = explode('_', $key);
					echo $exp[0] ?: $val['prod_no'];
					if (count($items) > 1) break;
				}
				if (count($items) > 1) echo ' <a href="'.$edit_link.'"><i class="fa fa-plus text-success tooltips" data-original-title="...more items"></i></a>';
				?>
			</td>
			<td> <?php echo $order->store_name ?: $order->ws_store_name; ?> </td>
			<td> <?php echo $order->designer ?: 'Mixed Designers'; ?> </td>
			<td>
				<?php
				// get the author
				if ($order->c != '2')
				{
					// aahhh... you are an admin user
					$author = $this->admin_user_details->initialize(
						array(
							'admin_id' => $order->author
						)
					);
				}
				else
				{
					$author = $this->sales_user_details->initialize(
						array(
							'admin_sales_id' => $order->author
						)
					);
				}
				?>
				<?php echo @$author->fname.' '.@$author->lname; ?>
			</td>
			<td>
				<?php
				switch ($order->status)
				{
					case '5':
						$label = 'success';
						$text = 'Complete';
					break;
					case '7':
						$label = 'danger';
						$text = 'On Hold';
					break;
					case '8':
						$label = 'warning';
						$text = 'Cancelled';
					break;
					case '4':
					default:
						$label = 'info';
						$text = 'Pending';
				}
				?>
				<span class="label label-sm label-<?php echo $label; ?>"> <?php echo $text; ?> </span>
			</td>
		</tr>
				<?php
				$i++;
			}
		} ?>

	</tbody>
</table>
</form>
<!-- End FORM =======================================================================-->