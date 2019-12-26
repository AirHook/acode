<!-- BEGIN FORM-->
<!-- FORM =======================================================================-->
<?php echo form_open(
	$this->config->slash_item('admin_folder').'orders/bulk_actions',
	array(
		'class'=>'form-horizontal',
		'id'=>'form-orders_bulk_actions'
	)
); ?>
<div class="page-head">
	<div class="container">
		<div class="page-title">
			<h1>ORDERS</h1>
		</div>
	</div>
</div>
<?php
/***********
 * Noification area
 */
?>
<div class="notifications">
	<?php if ($this->session->flashdata('success') == 'order_details_sent') { ?>
	<div class="alert alert-success auto-remove">
		<button class="close" data-close="alert"></button> Order details sent via email.
	</div>
	<?php } ?>
</div>

<div class="table-toolbar">
	<ul class="nav nav-tabs">
		<li class="<?php echo $this->uri->uri_string() == 'my_account/'.$role.'/orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/'.$role.'/orders'); ?>">
				All Orders
			</a>
		</li>
		<?php
		if($role=="wholesale") {
			if ($this->webspace_details->slug !== 'tempoparis') { ?>
			<li class="<?php echo $this->uri->segment(4) == 'pending' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/pending'); ?>">
					Pending Orders
				</a>
			</li>
			<li class="<?php echo $this->uri->segment(4) == 'onhold' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/onhold'); ?>">
					On Hold Orders
				</a>
			</li>
			<li class="<?php echo $this->uri->segment(4) == 'completed' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/completed'); ?>">
					Completed Orders
				</a>
			</li>
			<?php }
		} ?>
		<li class="<?php echo $this->uri->segment(3) == 'profile' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/'.$role.'/profile'); ?>">
				My Info
			</a>
		</li>
	</ul>
</div>

<?php
/***********
 * Top Pagination
 */
?>
<?php if ( ! $search) { ?>
<div class="row margin-bottom-10">
	<div class="col-md-12 text-justify pull-right">
		<span style="<?php echo $this->pagination->create_links() ? 'position:relative;top:15px;' : ''; ?>">
			Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
		</span>
		<?php echo $this->pagination->create_links(); ?>
	</div>
</div>
<?php } ?>

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
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-orders_" data-orders_count="<?php echo $this->orders_list->row_count; ?>">
	<thead>
		<tr>
			<th class="hidden-xs hidden-sm" style="width:30px"> <!-- counter --> </th>
			<!--th class="text-center" style="width:30px">
				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
					<input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-orders_ .checkboxes" />
					<span></span>
				</label>
			</th-->
			<th> Order # </th>
			<th> Order Date </th>
			<th class="hide"> Transaction #<br /><small><cite>(click to view details)</cite></small> </th>
			<th> Items </th>
			<th> Order<br />Qty </th>
			<th> Purchase<br />Amount </th>
			<!--th> Customer &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </th>
			<th style="width:100px;"> Role </th-->
			<th style="width:130px;"> Status </th>
		</tr>
	</thead>
	<tbody>

		<?php
		if ($orders)
		{
			$i = 1;
			foreach ($orders as $order)
			{
				$edit_link = site_url('my_account/'.$role.'/orders/details/'.$order->order_id);

				// for '.$role.' only site like tempoparis, show only '.$role.' orders
				// for now, we use this condition to remove consuemr orders
				//if ($order->store_name)
				//{
				?>

		<tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
			<!-- # -->
			<td class="hidden-xs hidden-sm">
				<?php echo $i; ?>
			</td>
			<!-- checkboxes -->
			<!--td class="text-center">
				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
					<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $order->order_id; ?>" />
					<span></span>
				</label>
			</td-->
			<!-- Order# -->
			<td>
				<a href="<?php echo $edit_link; ?>">
					<?php echo $order->order_id; ?>
				</a>
			</td>
			<!-- Date -->
			<td>
				<?php
				// using order_date timestamp
				$date = str_replace('-', '',str_replace(',',' ',$order->date_ordered));
				$date = @strtotime($date);
				//$date = @date('d-m-Y H:i',$date);
				$date = @date('Y-m-d',$date);
				//echo $date;
				echo date('Y-m-d',$order->order_date);
				?>
			</td>
			<!-- Transaction Code # -->
			<td class="hide">
				<a href="<?php echo $edit_link; ?>">
					<?php echo $order->transaction_code; ?>
				</a>
			</td>
			<!-- Items -->
			<td>
				<?php
				echo $order->prod_no;
				if ($order->number_of_orders > 1) echo ' <i class="fa fa-plus text-success tooltips" data-original-title="...more items"></i>';
				?>
			</td>
			<!-- Order Qty -->
			<td> <?php echo $order->order_qty; ?> </td>
			<!-- Purchase Amount -->
			<td> <?php echo '$ '.number_format($order->order_amount, 2); ?> </td>
			<!-- Customer Info -->
			<!--td>
				<?php
				// echo ucwords(strtolower($order->firstname.' '.$order->lastname));
				// echo $order->store_name ? '<br /><small><cite>('.$order->store_name.')</cite></small>' : '';
				?>
			</td-->
			<!-- Roel -->
			<!--td> <small><cite><?php //echo $order->c == 'ws' ? 'wholesale' : 'consumer'; ?></cite></small> </td-->
			<!-- Status -->
			<td>
				<?php
				if ($order->remarks != '0' && $order->remarks != '')
				{
					$label = 'warning';
					$text = 'Return';
				}
				else
				{
					switch ($order->status)
					{
						case '1':
							$label = 'success';
							$text = 'Complete';
						break;
						case '2':
							$label = 'danger';
							$text = 'On Hold';
						break;
						case '0':
						default:
							$label = 'info';
							$text = 'Pending';
					}
				}
				?>
				<span class="label label-sm label-<?php echo $label; ?> small"> <?php echo $text; ?> </span>
			</td>
		</tr>

					<?php
					$i++;
				//}
			}
		}
		else
		{ ?>

		<tr><td colspan="11">No records found.</td></tr>

			<?php
		} ?>

	</tbody>
</table>

<?php
/***********
 * Bottom Pagination
 */
?>
<?php if ( ! $search) { ?>
<div class="row margin-bottom-10">
	<div class="col-md-12 text-justify pull-right">
		<span>
			Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
		</span>
		<?php echo $this->pagination->create_links(); ?>
	</div>
</div>
<?php } ?>

</form>
<!-- End FORM =======================================================================-->
<!-- END FORM-->

<!-- BULK PENDING -->
<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-pe" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Pending!</h4>
			</div>
			<div class="modal-body"> Set multiple items as PENDING? </div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
					<span class="ladda-label">Confirm?</span>
					<span class="ladda-spinner"></span>
				</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- BULK ON HOLD -->
<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-ho" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">On Hold!</h4>
			</div>
			<div class="modal-body"> Set multiple items as ON HOLD? </div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
					<span class="ladda-label">Confirm?</span>
					<span class="ladda-spinner"></span>
				</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- BULK COMPLETE -->
<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-co" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Complete!</h4>
			</div>
			<div class="modal-body"> Set multiple items as COMPLETE? </div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
					<span class="ladda-label">Confirm?</span>
					<span class="ladda-spinner"></span>
				</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- BULK DELETE -->
<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-del" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Delete!</h4>
			</div>
			<div class="modal-body"> Delete multiple items? <br /> This cannot be undone! </div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
					<span class="ladda-label">Confirm?</span>
					<span class="ladda-spinner"></span>
				</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
