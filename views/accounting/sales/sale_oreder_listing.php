<?php $controller =& get_instance(); 

$controller->load->model('sale_model');

?>

<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">

    <div class="row  overflow-hide">

        <div class="col-sm-12 overflow-hide">

            <div class="ibox overflow-hide">

                <div class="ibox-content">

                    <h2><?php lang('heading_sale_orders'); ?>

						<span class="pull-right">
						<?php if ($controller->has_access_of('add_sale_order')) { ?>

							<a  href="<?php echo base_url('accounting/sales/addSaleOrder') ?>" class="btn  btn-primary "> <i class="fa fa-plus"></i> <?php lang('btn_add_new'); ?> </a>&nbsp;
						<?php } ?>
						</span>

						<div class="clearfix"></div>

					</h2>

					<div class="clients-list listing">

                       <div class="full-height-scroll">

                            <div class="table-responsive">

                                <div hidden class="custom-html">

                                </div>

                               <table class="table table-striped table-hover table-hover dataTables1 data-table">

                                    <thead>

                                        <tr>

                                        	<th><?php lang('lab_s_no'); ?></th>

                                        	<th><?php lang('lab_sale_order_number'); ?></th>

                                        	<th><?php lang('lab_customer_name'); ?></th>

                                        	<th><?php lang('lab_sub_total'); ?></th>

                                        	<th><?php lang('lab_discount'); ?></th>

                                        	<th><?php lang('lab_freight'); ?></th>

                                        	<th><?php lang('lab_tax'); ?></th>

                                        	<th><?php lang('lab_total'); ?></th>

                                        	<th><?php lang('lab_status'); ?></th>

                                        	<th><?php lang('lab_currency'); ?></th>

                                        	<th><?php lang('lab_date'); ?></th>

                                        	<th><?php lang('lab_action'); ?></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php if(!empty($allData)){

                                    	$serial_no=1;

                                    	foreach($allData as $value){ ?>

										<tr>

											<td><?php echo $serial_no++; ?></td>

											<td>

												<?php echo isset($value->saleorderNo) ? $value->saleorderNo :''; ?>

											</td>

											<td>

												<?php 

													if(isset($value->customerId)){

														$customerName=$controller->sale_model->getById('tbl_accountledger',$value->customerId);

														if(!empty($customerName)){

															echo isset($customerName->ledgerName) ? $customerName->ledgerName :'';

														}

													}

												 ?>

											</td>

											<td>

												<?php echo isset($value->subtotal) ? price_value($value->subtotal) :''; ?>

											</td>

											<td>

												<?php if(isset($value->percentDiscount) && $value->percentDiscount != '') {
													echo price_value($value->percentDiscount);
												} ?>

											</td>

											<td>

												<?php echo isset($value->freight) ? price_value($value->freight) :''; ?>

											</td>

											<td>

												<?php if(isset($value->tax)) { 

													   $taxNameWithType=$controller->sale_model->getOne('tbl_accountledger',array('id'=>$value->tax));

													   if(!empty($taxNameWithType)){

													   		echo isset($taxNameWithType->tax_value) ? $taxNameWithType->tax_value .' '. $taxNameWithType->tax_symbal .' '. '(' .$taxNameWithType->ledgerName. ')' :''; 

													   }

													} ?>

											</td>

											<td>

												<?php echo isset($value->total) ? price_value($value->total) :''; ?>

											</td>

											<td>

											<?php 

												if (isset($value->SaleOrderisApproved) && $value->SaleOrderisApproved == 1) 

													  lang('lab_approved');

													else

														lang('lab_pending');

												 ?>

											</td>

											<td>



												<?php 

													if(isset($value->currencyId)){

														$currency=$controller->sale_model->getById('tbl_currency',$value->currencyId);

														if(!empty($currency)){

															echo isset($currency->currency_code) ? $currency->currency_code :'';

														}

													}

												 ?>

											</td>

											

											<td>

												<?php echo isset($value->deliveryDate) ? date("M d,Y",strtotime($value->deliveryDate)) :''; ?>

											</td>

											<td>
										<?php if ($controller->has_access_of('delete_sale_order')) { ?>
												<a href="<?php echo base_url('accounting/sales/deleteOrder') ."/". $value->saleorderNo ?>" class="btn delete-confirm "><i class="fa fa-trash-o"></i></a>
										<?php } ?>
											<?php if ($controller->has_access_of('view_sale_order')) { ?>
												<a href="<?php echo base_url('accounting/sales/addSaleOrder') ."/".encode_url($value->saleorderNo) ?>" class="btn btn-xs btn-primary"><i class="fa fa-detail"></i><?php lang('btn_view_detail'); ?></a>
										<?php } ?>
											</td>

										</tr>

									<?php } } ?>

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

