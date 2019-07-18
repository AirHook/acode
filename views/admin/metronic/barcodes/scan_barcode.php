<!-- BEGIN PAGE CONTENT BODY -->
<?php $controller =& get_instance(); 
?>
<div class="row physical_inventory">
    <!-- BEGIN PRODUCT INVENTORY SIDEBAR -->
    <div class="col-sm-9 pull-left">
		<!-- BEGIN Portlet PORTLET-->
		<div class="portlet box blue form">
			<div class="portlet-title">
				<div class="caption">
					Scaning Barcode
				</div>
			</div>
			<div class="portlet-body">
				<?php $controller->showFlash(); ?>
				 <!-- <form action="<?php echo site_url($this->config->slash_item('admin_folder').'inventory/barcode_scaning/manage_stocks')?>" method="POST">  -->
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" >
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Scan barcode here</label>
								<input type="text" autocomplete="off" value="<?php echo isset($code) ? $code :''; ?>" class="form-control" required="" name="code" placeholder="Scan barcode here..">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<!-- <button type="submit" name="submit" value="inventory_in" class="btn btn-info">Inventory In</button>
							<button type="submit" name="submit" value="inventory_out" class="btn btn-primary">Inventory Out</button> -->
							<a href="javascript:void(0)" data-action="<?php echo site_url($this->config->slash_item('admin_folder').'inventory/barcode_scaning/manage_stocks/inventory_in')?>" class="btn btn-info update_stock">Inventory In</a>
							<a  href="javascript:void(0)" data-action="<?php echo site_url($this->config->slash_item('admin_folder').'inventory/barcode_scaning/manage_stocks/inventory_out')?>" class="btn btn-primary update_stock">Inventory Out</a> 
						</div>
					</div>
				<!-- </form> -->
			</div>
		</div>
		<!-- END Portlet PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT BODY -->
