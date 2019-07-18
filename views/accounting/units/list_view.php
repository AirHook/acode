<?php $controller =& get_instance(); 
 $controller->load->model('product_model')?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row  overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content">
                    <h2><?php lang('heading_product_units'); ?>
						<span class="pull-right">
               			 <?php if ($controller->has_access_of('add_units')) { ?>
							<a  href="#" class="btn  btn-primary  addUnit"> <i class="fa fa-plus"></i> <?php lang('btn_add_new_unit'); ?></a>&nbsp;
						<?php } ?>
						</span>

						<div class="clearfix"></div>
					</h2>
					<div class="clients-list listing">
                       <div class="full-height-scroll">
                            <div class="table-responsive">
                                <div hidden class="custom-html">
                                </div>
                                <table class="table table-striped table-hover table-hover dataTables1 order-items data-table">
                                    <thead>
                                        <tr>
                                        	<th><?php lang('lab_sr_no'); ?></th>
                                            <th><?php lang('lab_unit_name'); ?></th>
											<th><?php lang('lab_actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											if(!empty($units)){ 
												$serial_no =1;
												foreach(array_reverse($units) as $values){
													?>
													<tr>
														<td>
															<?php echo $serial_no++; ?>
														</td>
														<td>
															<?php echo isset($values->UOMName) ? $values->UOMName :''; ?>
														</td>
														<td>
       			 										<?php if ($controller->has_access_of('edit_units')) { ?>
														<a data-name="<?php echo isset($values->UOMName) ? $values->UOMName :''; ?>" data-id="<?php echo isset($values->id) ? $values->id :''; ?>" href="#" class="fa-btn addUnit">
																<i class="fa fa-edit"></i>
															</a>
															<?php } ?>
															&nbsp;
															&nbsp;
															<?php
																if(isset($values->id)){
																	$company_id=$controller->session->userdata('company_id');
																	$result=$controller->product_model->getOne('tbl_purchasepricelist',array('UOMId'=>$values->id,'company_id'=>$company_id));
																	if(empty($result)){?>
               			 										<?php if ($controller->has_access_of('delete_units')) { ?>

																	 <a href="<?php echo base_url('accounting/products/delete') ."/". $values->id; ?>/tbl_uom" class="fa-btn delete-confirm">
																		<i class="fa fa-trash-o"></i>
																	</a>
																<?php } ?>
																<?php }else{ ?>
																	<a href="#" class="btn btn-primary btn-xs"><?php lang('btn_unit_assigned'); ?></a>
																<?php } } ?>
														</td>
														
													</tr>
												<?php
												}
											}
										?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
</div>
