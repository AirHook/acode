<?php $controller =& get_instance(); 

$controller->load->model('purchase_model');

?>

<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">

    <div class="row  overflow-hide">

        <div class="col-sm-12 overflow-hide">

            <div class="ibox overflow-hide">

                <div class="ibox-content">

                    <h2><?php lang('heading_purchase_quotations'); ?> 

						<span class="pull-right">
						<?php if ($controller->has_access_of('add_purchase_quotation')) { ?>

							<a  href="<?php echo base_url('accounting/purchases/addPurchaseQuotation') ?>" class="btn  btn-primary "> <i class="fa fa-plus"></i> <?php lang('btn_add_new'); ?>  </a>&nbsp;
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

                                        	<th><?php lang('lab_purchase_quotation_no'); ?></th>

                                        	<th><?php lang('lab_supplier_name'); ?></th>

                                        	<th><?php lang('lab_sub_total'); ?></th>

                                        	<th><?php lang('lab_discount'); ?></th>

                                        	<th><?php lang('lab_freight'); ?></th>

                                        	<th><?php lang('lab_tax_on_invoice'); ?></th>

                                        	<th><?php lang('lab_total'); ?></th>

                                        	<th><?php lang('lab_status'); ?></th>

                                        	<th><?php lang('lab_date'); ?></th>

                                        	<th><?php lang('lab_action'); ?></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php if(!empty($purchaseQuotationMaster)){

                                    	$serial_no=1;

                                    	foreach($purchaseQuotationMaster as $value){ ?>

										<tr>

											<td><?php echo $serial_no++; ?></td>

											<td>

												<?php echo isset($value->qoutationNo) ? $value->qoutationNo :''; ?>

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
													echo $value->discount;
													echo (isset($value->discount_type) && $value->discount_type != 'amount') ? $value->discount_type : '';
												}
												?>

											</td>

											<td>

												<?php echo isset($value->freight) ? price_value($value->freight) :''; ?>

											</td>

											<td>

												<?php if(isset($value->tax)) { 

													   $taxNameWithType=$controller->purchase_model->getOne('tbl_accountledger',array('id'=>$value->tax));

													   if(!empty($taxNameWithType)){

													   		echo isset($taxNameWithType->tax_value) ? $taxNameWithType->tax_value .' '. $taxNameWithType->tax_symbal .' '. '(' .$taxNameWithType->ledgerName. ')' :''; 

													   }

													} 

												?>

											</td>

											<td>

												<?php echo isset($value->total) ? price_value($value->total) :''; ?>

											</td>

											<td>

												<?php 

												if(isset($value->status) && $value->status == 0){

													if (isset($value->isApproved) && $value->isApproved == 1){

														   lang('lab_approved');

														}else{

															lang('lab_pending');

														}

													}else{

														lang('lab_PQ_converted_into_PO');

													}

												 ?>

											</td>

											<td>

												<?php echo isset($value->deliveryDate) ? date("M d,Y",strtotime($value->deliveryDate)) :''; ?>

											</td>

											<td>
											<?php if ($controller->has_access_of('edit_purchase_quotation')) { ?>

												<a href="<?php echo base_url('accounting/purchases/deleteQuotation') ."/". $value->qoutationNo ?>" class="btn delete-confirm "><i class="fa fa-trash-o"></i></a>
											<?php } ?>
											<?php if ($controller->has_access_of('view_purchase_quotation')) { ?>
												<a href="<?php echo base_url('accounting/purchases/addPurchaseQuotation') ."/".encode_url($value->qoutationNo) ?>" class="btn btn-xs btn-primary"><i class="fa fa-detail"></i><?php lang('btn_view_detail'); ?></a>
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

