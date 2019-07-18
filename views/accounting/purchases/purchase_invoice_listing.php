<?php $controller =& get_instance(); 

$controller->load->model('purchase_model');

?>

<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">

    <div class="row  overflow-hide">

        <div class="col-sm-12 overflow-hide">

            <div class="ibox overflow-hide">

                <div class="ibox-content">

                    <h2><?php lang('heading_purchase_invoices'); ?> 

						<span class="pull-right">
						<?php if ($controller->has_access_of('add_purchase_invoice')) { ?>

							<a  href="<?php echo base_url('accounting/purchases/addPurchaseInvoice') ?>" class="btn  btn-primary "> <i class="fa fa-plus"></i> <?php lang('btn_add_new'); ?> </a>&nbsp;
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

                                        	<th><?php lang('lab_purchase_invoice_no'); ?></th>

                                        	<th><?php lang('lab_supplier_name'); ?></th>

                                        	<th><?php lang('lab_sub_total'); ?></th>

                                        	<th><?php lang('lab_discount'); ?></th>

                                        	<th><?php lang('lab_freight'); ?></th>

                                        	<th><?php lang('lab_tax'); ?></th>

                                        	<th><?php lang('lab_total'); ?></th>

                                        	<th><?php lang('lab_payment'); ?></th>
                                        	<th><?php lang('lab_balance'); ?></th>
                                        	<th><?php lang('lab_status'); ?></th>


                                        	<th><?php lang('lab_date'); ?></th>

                                        	<th><?php lang('lab_action'); ?></th>

                                            

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php if(!empty($purchaseInvoiceMaster)) {

                                    	$serial_no=1;

                                    	foreach($purchaseInvoiceMaster as $value) { ?>

										<tr>

											<td><?php echo $serial_no++; ?></td>

											<td>

												<?php echo isset($value->purchaseInvoiceNo) ?  $value->purchaseInvoiceNo :''; ?>

											</td>

											<td>

												<?php 

													if(isset($value->supplierId)){

														$resut=$controller->purchase_model->getById('tbl_accountledger',$value->supplierId);

														if(!empty($resut)){

															echo isset($resut->ledgerName) ? $resut->ledgerName :'';

														}

													}

												 ?>

											</td>

											<td>

												<?php echo isset($value->subtotal) ? price_value($value->subtotal) :''; ?>

											</td>

											<td>

												<?php 
												if(isset($value->discount) && $value->discount != '') {
													if(isset($value->discount_type) && $value->discount_type != 'amount')
														echo $value->discount.$value->discount_type;
													else
														echo price_value($value->discount);
												}
												 ?>

											</td>

											<td>

												<?php echo isset($value->freight) ? price_value($value->freight) :''; ?>

											</td>

											<td>

												<?php echo isset($value->tax_amount) ? price_value($value->tax_amount)  : ''; ?>

											</td>

											<td>

												<?php echo isset($value->total) ? price_value($value->total) :''; ?>

											</td>
											<td>

												<?php echo isset($value->payment_receive) ? price_value($value->payment_receive) :''; ?>

											</td>
											<td>

												<?php
												echo  price_value((float)$value->total - (float)$value->payment_receive);
												 ?>

											</td>
											<td>

												<?php 

												if (isset($value->purchaseInvoiceStatus) && $value->purchaseInvoiceStatus == 1) 

													  echo "Approved";

												 ?>

											</td>

											<!-- <td>



												<?php 

													if(isset($value->currencyId)){

														$currency=$controller->purchase_model->getById('tbl_currency',$value->currencyId);

														if(!empty($currency)){

															echo isset($currency->currency_code) ? $currency->currency_code :'';

														}

													}

												 ?>

											</td> -->

											

											<td>

												<?php echo isset($value->deliveryDate) ? date("M d,Y",strtotime($value->deliveryDate)) :''; ?>

											</td>

											<td>
												<?php if ($controller->has_access_of('delete_purchase_invoice')) { ?>

												<a href="<?php echo base_url('accounting/purchases/deletePurchaseInvoice') ."/". $value->purchaseInvoiceNo."/".$value->id; ?>" class="btn delete-confirm"><i class="fa fa-trash-o"></i></a>
												<?php } ?>
												<?php 
												if($value->isReturn != '1'): ?>
													<?php if($value->can_edit == '1'): ?>
												<?php if ($controller->has_access_of('edit_purchase_invoice')) { ?>
														<a href="<?php echo base_url('accounting/purchases/addPurchaseInvoice') ."/".encode_url($value->purchaseInvoiceNo) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i><?php lang('btn_edit'); ?></a>
												<?php } ?>
													<?php else: ?>
												<?php if ($controller->has_access_of('edit_purchase_invoice')) { ?>
														<a href="<?php echo base_url('accounting/purchases/purchaseReturn') ."/".$value->purchaseInvoiceNo; ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i><?php lang('btn_edit'); ?></a> 
												<?php } ?>
													<?php endif; ?>
											<?php endif; ?>
												<?php if ($controller->has_access_of('view_purchase_invoice')) { ?>
												<a href="<?php echo base_url('accounting/purchases/printInvoice') ."/".$value->purchaseInvoiceNo; ?>" class="btn btn-xs btn-primary"><i class="fa fa-detail"></i><?php lang('btn_view_detail'); ?></a>
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

