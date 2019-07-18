<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					        <div class="col-sm-12 ">
					        	<?php if(isset($model)) {?>
								<h2><?php lang('heading_edit_catagory'); ?></h2>
					        	<?php } else { ?>
								<h2><?php lang('heading_add_catagory'); ?></h2>
								<?php } ?>
								<br>
					          	 <span>
					                    <?php $controller->showFlash(); ?>
					                </span>
					                <?php if(isset($model['id'])) { ?>
					               	<form action="<?php echo base_url('accounting/products/addCatagory') ."/". $model['id'] ?>" method="POST" role="form">
					               <?php } else{ ?>
					               	<form action="<?php echo base_url('accounting/products/addCatagory') ?>" method="POST" role="form">
					               <?php } ?>
					               <input type="hidden" name="id" value="<?php echo isset($model['id']) ? $model['id'] :''; ?>">
						               <div class="row">
						               		<div class="col-sm-6">
						               			<div class="form-group">
						               				<label><?php lang('lab_catagory_name'); ?></label>
						               				<input required="true" type="text" name="groupName" value="<?php echo isset($model['groupName']) ? $model['groupName'] :''; ?>" class="form-control">
						               			</div>
						               		</div>
						               	</div>
						               	<div class="row">
						               		<div class="col-sm-6">
						               			<div class="form-group">
						               				<label><?php lang('lab_narration'); ?></label>
						               				<textarea class="form-control" name="narration"><?php echo isset($model['narration']) ? $model['narration'] :''; ?></textarea>
						               			</div>
						               		</div>
						               </div>
						               <div class="row">
						               		<div class="col-sm-6">
							               		<div class="form-group">
			               							<select name="status" class="form-control">
			               								<option value="active" <?php echo (isset($model['status']) && $model['status'] == 'active') ? 'selected' : ''; ?>><?php lang('opt_active'); ?></option>
			               								<option value="inactive" <?php echo (isset($model['status']) && $model['status'] == 'inactive') ? 'selected' : ''; ?>><?php lang('opt_inactive'); ?></option>
			               							</select>
							               		</div>
						               		</div>
						               	</div>
					                   <div class="row">
					                   		<div class="col-sm-4">
						                	<a href="<?php echo  base_url('accounting/products/category')?>" class="form-btn btn  btn-primary btn-default1 ">
						                		<?php lang('btn_cancel'); ?>
						                	</a>&nbsp&nbsp
						                	<input type="submit" value="<?php lang('btn_save'); ?>" name="submit" class="form-btn btn btn-shadow btn-primary "/>
						                	</div>
						                </div>
		                           </form>
					        </div>
					    </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>