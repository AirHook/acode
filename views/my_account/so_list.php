<!-- BEGIN FORM-->
<!-- FORM =======================================================================-->
<?php echo form_open(
	$this->uri->segment(1).'/sales_orders/bulk_actions',
	array(
		'class'=>'form-horizontal',
		'id'=>'form-sales_orders_bulk_actions'
	)
); ?>

<?php
/*********
 * Notification area
 */
?>
<div class="norifications">
	<?php if ($this->session->flashdata('success') == 'add') { ?>
	<div class="alert alert-success auto-remove">
		<button class="close" data-close="alert"></button> New Sales Order ADDED!
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('success') == 'edit') { ?>
	<div class="alert alert-success auto-remove">
		<button class="close" data-close="alert"></button> Sales Order information updated.
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('success') == 'delete') { ?>
	<div class="alert alert-success auto-remove">
		<button class="close" data-close="alert"></button> Sales Order permanently removed from records.
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('success') == 'order_details_sent') { ?>
	<div class="alert alert-success auto-remove">
		<button class="close" data-close="alert"></button> Sales Order details sent via email.
	</div>
	<?php } ?>
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
		<li class="<?php echo $this->uri->uri_string() == 'my_account/sales/listorders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/listorders'); ?>">
				All Sales Orders
			</a>
		</li>
		<li class="<?php echo $this->uri->segment(3) == 'onorder' ? 'active' : ''; ?>">
			<a href="javascript:;" class="tooltips" data-original-title="Currently under construction">
				Pending SO
			</a>
		</li>
		<li class="<?php echo $this->uri->segment(3) == 'onorder' ? 'active' : ''; ?>">
			<a href="javascript:;" class="tooltips" data-original-title="Currently under construction">
				Completed SO
			</a>
		</li>
	</ul>

	<br />

	<?php if (@$search) { ?>
	<h1><small><em>Search results for:</em></small> "<?php echo @$search_string; ?>"</h1>
	<br />
	<?php } ?>

	<div class="row">

		<div class="col-lg-3 col-md-4">
			<select class="bs-select form-control" id="bulk_actions_select" name="bulk_action" disabled>
				<option value="" selected="selected">Bulk Actions</option>
				<option value="pe">Set as Pending</option>
				<option value="re">Set as Return</option>
				<option value="ho">Set as On Hold</option>
				<option value="co">Set as Complete</option>
				<option value="del">Permanently Delete</option>
			</select>
		</div>
		<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

	</div>
	<button class="btn green hidden-lg hidden-md" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

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
			<th style="width:100px;"> Actions </th>
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
					site_url($this->uri->segment(1).'/sales/listorders/details/'.$order->sales_order_id)
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
			<!-- SO# -->
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
			<!-- SO Date -->
			<td>
				<?php echo @date('Y-m-d', $order->sales_order_date); ?>
			</td>
			<!-- Items -->
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
			<!-- Store Name -->
			<td> <?php echo $order->store_name ?: $order->ws_store_name; ?> </td>
			<!-- Designer -->
			<td> <?php echo $order->designer ?: 'Mixed Designers'; ?> </td>
			<!-- Author -->
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
			<!-- Status -->
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
			<!-- Actions -->
			<td class="dropdown-wrap dropdown-fix">
				<div class="btn-group" >
					<button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
						<i class="fa fa-angle-down"></i>
					</button>
					<!-- DOC: Remove "pull-right" class to default to left alignment -->
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="javascript:;">
								<i class=""></i> <cite>Click to Change Status</cite>  </a>
						</li>
						<li class="divider"> </li>
						<li>
							<a data-toggle="modal" href="#pending-<?php echo $order->sales_order_id; ?>">
								<i class="fa fa-<?php echo $order->status == '0' ? 'check': ''; ?>"></i> Pending </a>
						</li>
						<li>
							<a data-toggle="modal" href="#return-<?php echo $order->sales_order_id; ?>">
								<i class="fa fa-<?php echo $order->status == '8' ? 'check': ''; ?>"></i> Cancelled </a>
						</li>
						<li>
							<a data-toggle="modal" href="#on_hold-<?php echo $order->sales_order_id; ?>">
								<i class="fa fa-<?php echo $order->status == '7' ? 'check': ''; ?>"></i> On Hold </a>
						</li>
						<li>
							<a data-toggle="modal" href="#complete-<?php echo $order->sales_order_id; ?>">
								<i class="fa fa-<?php echo $order->status == '5' ? 'check': ''; ?>"></i> Complete </a>
						</li>
						<li class="divider"> </li>
						<li>
							<a href="<?php echo $edit_link; ?>">
								<i class="icon-pencil"></i> View Details </a>
						</li>
					</ul>
				</div>
				<!-- PENDING -->
				<div class="modal fade bs-modal-sm" id="pending-<?php echo $order->sales_order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Update Order Info</h4>
							</div>
							<div class="modal-body"> Set order as PENDING? </div>
							<div class="modal-footer">
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders/status/update/'.$order->sales_order_id.'/4') : site_url($this->config->slash_item('admin_folder').'sales_orders/status/update/'.$order->sales_order_id.'/4'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
									<span class="ladda-label">Confirm?</span>
									<span class="ladda-spinner"></span>
								</a>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- PENDING -->
				<div class="modal fade bs-modal-sm" id="return-<?php echo $order->sales_order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Update Order Info</h4>
							</div>
							<div class="modal-body"> Set order as RETURN? </div>
							<div class="modal-footer">
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders/status/update/'.$order->sales_order_id.'/3') : site_url($this->config->slash_item('admin_folder').'sales_orders/status/update/'.$order->sales_order_id.'/3'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
									<span class="ladda-label">Confirm?</span>
									<span class="ladda-spinner"></span>
								</a>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- ON HOLD -->
				<div class="modal fade bs-modal-sm" id="on_hold-<?php echo $order->sales_order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Update Order Info</h4>
							</div>
							<div class="modal-body"> Set order as ON HOLD? </div>
							<div class="modal-footer">
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders/status/update/'.$order->sales_order_id.'/2') : site_url($this->config->slash_item('admin_folder').'sales_orders/status/update/'.$order->sales_order_id.'/2'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
									<span class="ladda-label">Confirm?</span>
									<span class="ladda-spinner"></span>
								</a>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- COMPLETE -->
				<div class="modal fade bs-modal-sm" id="complete-<?php echo $order->sales_order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Update Order Info</h4>
							</div>
							<div class="modal-body"> Set order as COMPLETE? </div>
							<div class="modal-footer">
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders/status/update/'.$order->sales_order_id.'/1') : site_url($this->config->slash_item('admin_folder').'sales_orders/status/update/'.$order->sales_order_id.'/1'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
									<span class="ladda-label">Confirm?</span>
									<span class="ladda-spinner"></span>
								</a>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- ITEM DELETE -->
				<div class="modal fade bs-modal-sm" id="delete-<?php echo $order->sales_order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Warning!</h4>
							</div>
							<div class="modal-body"> Deleting Sales Orders is not an option at the moment. Please contact your administrator if it is necessary to delete a certain PO. </div>
							<div class="modal-footer">
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders/delete/index/'.$order->sales_order_id) : site_url($this->config->slash_item('admin_folder').'sales_orders/delete/index/'.$order->sales_order_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button hide" data-style="expand-left">
									<span class="ladda-label">Confirm?</span>
									<span class="ladda-spinner"></span>
								</a>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
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
				<button onclick="$('#form-sales_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

<!-- BULK RETURN -->
<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-re" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Return!</h4>
			</div>
			<div class="modal-body"> Set multiple items as RETURN? </div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				<button onclick="$('#form-sales_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
				<button onclick="$('#form-sales_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
				<button onclick="$('#form-sales_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
				<h4 class="modal-title">NOTICE!</h4>
			</div>
			<div class="modal-body"> Deleting Sales Orders is not an option at the moment. Please contact your administrator if it is necessary to delete a certain PO. </div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				<button onclick="$('#form-sales_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button hide" data-style="expand-left">
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