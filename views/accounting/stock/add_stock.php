<?php $controller =& get_instance(); 
$controller->load->model('product_model');
?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					        <div class="col-sm-12 ">
					        	<?php if(isset($model['id'])) {?>
								<h2><?php lang('heading_edit_stock'); ?></h2>
					        	<?php } else { ?>
								<h2><?php lang('heading_add_new_stock'); ?></h2>
								<?php } ?>
								<br>
					          	 <span>
					                  <?php $controller->showFlash(); ?>
					                </span>
					                <?php if(isset($model['id'])) { ?>
					               	<form action="<?php echo base_url('accounting/products/addStock') ."/". $model['id']?>" method="POST" role="form">
					                 <input type="hidden" name="id" value="<?php echo isset($model['id']) ? $model['id'] :''; ?>">
					               <?php } else{ ?>
					               	<form action="<?php echo base_url('accounting/products/addStock') ?>" method="POST" role="form">
					               <?php } ?>
					               	<div class="row">
						               		<div class="col-sm-6">
						               			<div class="form-group">
						               				<label><?php lang('lab_supplier'); ?></label>
						               				<select class="form-control select2" name="supplier_id">
						               				<?php 
						               					$result=$controller->product_model->getAll('suppliers');
						               					if(!empty($result)){
						               						foreach($result as $value){
						               				 ?>
						               					<option value="<?php echo isset($value->id) ? $value->id :''; ?>">
						               						<?php echo isset($value->first_name) ? $value->first_name ." ". $value->last_name :''; ?>
						               					</option>
						               				<?php } } ?>
						               				</select>
						               			</div>
						               		</div>
							             </div>
						               <div class="row">
						               		<div class="col-sm-6">
						               			<div class="row">
						               			    <div class="col-sm-11">
								               			<div class="form-group">
								               				 <label><?php lang('lab_search_product'); ?></label>
								               				<span class="stockItems searching">
								               					<input type="text" placeholder="<?php lang('lab_search_product'); ?>" class="form-control">
								               				</span>
								               			</div>
							               			</div>
								               		<div class="col-sm-1" style="    margin-top: 22px;">
		                                    			<a href="#" class="btn btn-primary pull-right "><i class="fa fa-plus"></i></a>
			                                        </div>
						               			</div>
						               		</div> 
						               	</div>
						               	<br>
									    <div class="row">
					                            <div class="col-sm-12">
					                                <div class="form-group">
					                                    <div class="row">
					                                        <div class="col-sm-12">
					                                            <table class="table table-stripped products_list">
					                                                <thead>
					                                                    <tr>
					                                                        <th><?php lang('lab_name'); ?></th>
					                                                        <th><?php lang('lab_description'); ?></th>
					                                                        <th><?php lang('lab_quantity'); ?></th>
					                                                        <th><?php lang('lab_price'); ?></th>
					                                                        <th><?php lang('lab_total'); ?></th>
					                                                        <th></th>
					                                                    </tr>
					                                                </thead>
					                                                <tbody class="allproducts" data-price="edit">
						                                                
						                                            </tbody>
					                                                <tfoot>
					                                                    <tr>
					                                                        <th colspan="5"><?php lang('lab_total_amount'); ?></th>
					                                                        <th>$<span class="total"></span></th>
					                                                        <th></th>
					                                                    </tr>
					                                                </tfoot>
					                                            </table>
					                                        </div>
					                                    </div>
					                                </div>
					                            </div>
					                        </div>
				                        <div class="row">
					                   		<div class="col-sm-4">
						                	<a href="<?php echo  base_url('accounting/products/stock')?>" class="form-btn btn  btn-primary btn-default1 ">
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