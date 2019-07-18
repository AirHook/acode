<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row  overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content">
                    <h2><?php lang('heading_product_catagories'); ?> 
						<span class="pull-right">
						<?php if ($controller->has_access_of('add_product_category')) { ?>
							<a  href="<?php echo base_url('accounting/products/addCatagory') ?>" class="btn  btn-primary "> <i class="fa fa-plus"></i> <?php lang('btn_add_product_catagory'); ?></a>&nbsp;
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
                                        	<th><?php lang('lab_s_no'); ?></th>
                                            <th><?php lang('lab_catagory_name'); ?></th>
                                            <th><?php lang('lab_description'); ?></th>
                                            <th><?php lang('lab_status'); ?></th>
											<th><?php lang('lab_actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											if(!empty($catagories)){ 
												$serial_no =1;
												foreach(array_reverse($catagories) as $values){
													?>
													<tr>
														<td>
															<?php echo $serial_no++; ?>
														</td>
														<td>
															<?php echo isset($values->groupName) ? $values->groupName :''; ?>
														</td>
														<td>
															<?php echo isset($values->narration) ? $values->narration :''; ?>
														</td>
														<td>
															<?php 
															    echo isset($values->status) ? $values->status :'';
															   ?>
														</td>
														<td>
														<?php if ($controller->has_access_of('edit_product_category')) { ?>

															<a href="<?php echo base_url('accounting/products/addCatagory') ."/". $values->id ;?>" class="fa-btn">
																<i class="fa fa-edit"></i>
															</a>
														<?php } ?>
															&nbsp;
															&nbsp;
														<?php if ($controller->has_access_of('delete_product_category')) { ?>
															<a href="<?php echo base_url('accounting/products/delete') ."/". $values->id; ?>/tbl_productgroup" class="fa-btn delete-confirm">
																<i class="fa fa-trash-o"></i>
															</a>
														<?php } ?>
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
