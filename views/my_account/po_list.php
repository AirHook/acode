<?php
/*********
 * Notification area
 */
?>
<div class="notifications">
	<?php if ($this->session->flashdata('success') == 'order_details_sent') { ?>
	<div class="alert alert-success auto-remove">
		<button class="close" data-close="alert"></button> Purshase Order details sent via email.
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
	<div class="alert alert-danger auto-remove">
		<button class="close" data-close="alert"></button> An error occured. Please try again.
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
		<li class="<?php echo $this->uri->uri_string() == 'my_account/vendors/orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/vendors/orders'); ?>">
				All Purchase Orders
			</a>
		</li>
	</ul>
	<br />
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
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-orders" data-orders_count="<?php echo $this->purchase_orders_list->row_count; ?>">
	<thead>
		<tr>
			<th class="hidden-xs hidden-sm" style="width:30px"> <!-- counter --> </th>
			<th class="text-center" style="width:30px">
				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
					<input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-orders .checkboxes" />
					<span></span>
				</label>
			</th>
			<th> PO<br />Number </th>
			<th> PO<br />Date </th>
			<th> Product<br />Items </th>
			<th> Store<br />Name </th>
			<th> Designer </th>
			<th> Vendor </th>
			<th style="width:100px;"> Status </th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($orders)
		{
			$i = 1;
			foreach ($orders as $order)
			{
				$edit_link = '/my_account/vendors/orders/details/index/'.$order->po_id;
		?>
		<tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
			<td class="hidden-xs hidden-sm">
				<?php echo $i; ?>
			</td>
			<td class="text-center">
				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
					<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $order->po_id; ?>" />
					<span></span>
				</label>
			</td>
			<td>
				<a href="<?php echo $edit_link; ?>">
					<?php
					$po_number = $order->po_number;
					for($c = strlen($po_number);$c < 6;$c++)
					{
						$po_number = '0'.$po_number;
					}
					echo $po_number;
					?>
				</a>
				<a href="<?php echo $edit_link; ?>" class="hidden_first_edit_link_" style="font-size:0.7em;display:inline-block;">
					<cite>view details</cite>
				</a>
			</td>
			<td>
				<?php
				$date = @date('Y-m-d', $order->po_date);
				echo $date;
				?>
			</td>
			<td>
				<?php
				$items = json_decode($order->items, TRUE);
				foreach ($items as $key => $val)
				{
					//echo $val['prod_no'];
					echo $key;
					if (count($items) > 1) break;
				}
				if (count($items) > 1) echo ' <a href="'.$edit_link.'"><i class="fa fa-plus text-success tooltips" data-original-title="...more items"></i></a>';
				?>
			</td>
			<td> <?php echo $order->store_name; ?> </td>
			<td> <?php echo $order->designer; ?> </td>
			<td> <?php echo $order->vendor_code; ?> </td>
			<td>
				<?php
				switch ($order->status)
				{
					case '0':
						$label = 'info';
						$text = 'Pending';
					break;
					case '4':
						$label = 'info';
						$text = 'In Transit';
					break;
					case '5':
						$label = 'success';
						$text = 'Complete';
					break;
					case '6':
						$label = 'danger';
						$text = 'On Hold';
					break;
					case '7':
						$label = 'warning';
						$text = 'Cancelled';
					break;
					case '1':
					case '2':
					case '3':
					default:
						$label = 'info';
						$text = 'Vendor Action';
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
<!-- END FORM-->