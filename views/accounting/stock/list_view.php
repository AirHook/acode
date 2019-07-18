<?php $controller =& get_instance(); 
$controller->load->model('product_model');
?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row  overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content">
                    <h2><?php lang('heading_stock') ?> 
						<span class="pull-right">
							<a  href="<?php echo base_url('accounting/products/addStock') ?>" class="btn  btn-primary "> <i class="fa fa-plus"></i> <?php lang('btn_add_new') ?>  </a>&nbsp;
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
                                        	<th><?php lang('lab_s_no') ?></th>
                                            <th><?php lang('lab_item_name') ?></th>
                                            <th><?php lang('lab_catagory_name') ?></th>
                                            <th><?php lang('lab_quantity') ?></th>
                                            <th><?php lang('lab_price') ?></th>
											<th><?php lang('lab_actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											if(!empty($stockItems)){ 
												$serial_no =1;
												foreach(array_reverse($stockItems) as $values){
													?>
													<tr>
														<td>
															<?php echo $serial_no++; ?>
														</td>
														<td>
															<?php echo isset($values->title) ? $values->title :''; ?>
														</td>
														<td>
															<?php 
																if(isset($values->catagory_id)){
																	$result=$controller->product_model->getOne('catagories',array('id'=>$values->catagory_id));
																	if(!empty($result)){
																		echo isset($result->title) ? $result->title :''; 
																	} 
																} ?>
														</td>
														<td>

															<?php
																if(isset($values->price))
																   echo isset($values->price) ? $values->price :''; 
															 ?>
														</td>
														<td>
															<?php echo isset($values->description) ? $values->description :''; ?>
														</td>
														<td>
															<a href="<?php echo base_url('accounting/products/addStock')  ;?>" class="fa-btn">
																<i class="fa fa-edit"></i>
															</a>
															&nbsp;
															&nbsp;
															<a href="<?php echo base_url('accounting/products/delete')?>/stock" class="fa-btn delete-confirm">
																<i class="fa fa-trash-o"></i>
															</a>
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
