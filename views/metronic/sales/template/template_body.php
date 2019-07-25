                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container-fluid">

                                    <!-- BEGIN PAGE BREADCRUMBS -->
									<?php //$this->load->view('metronic/sales/template/template_breadcrumb'); ?>
                                    <!-- END PAGE BREADCRUMBS -->

                                    <div class="row">

                						<!-- BEGIN PAGE SIDEBAR -->
                						<div class="col-md-2">

                                            <!-- BEGIN PAGE SIDEBAR -->
        									<?php $this->load->view('metronic/sales/template/template_body_sidebar'); ?>
                                            <!-- END PAGE SIDEBAR -->

                                        </div>
                                        <!-- END PAGE SIDEBAR -->

                                        <!-- BEGIN PAGE BODY CONTENT -->
                                        <div class="col-md-10">

                                            <!-- BEGIN PAGE CONTENT INNER -->
                                            <?php
                    						if (@$file)
                    						{
                    							// condition statement to cater for common files between
                    							// sales resource and admin
                    							switch($file)
                    							{
                    								case 'users_wholesale':
                                                    case 'users_wholesale_edit':
                                                    case 'users_wholesale_add':
                    								case 'sales_orders':
                                                    case 'sales_orders_details':
                                                    case 'sales_orders_add':
                                                    case 'so_details':
                                                    case 'so_list':
                                                    case 'so_create_steps':
                                                    case 'purchase_orders';
                                                    case 'purchase_orders_add';
                                                    case 'purchase_orders_details';
                                                    case 'po_list';
                                                    case 'po_details';
                                                    case 'po_modify';
                    									$pre = 'admin/metronic/';
                    								break;
                    								default:
                    									$pre = 'metronic/sales/';
                    							}

                    							$this->load->view($pre.$file);
                    						}
                    						else
                    						{
                                                $this->load->view($pre.(@$file ?: 'blank_page'));
                                            }
                                            ?>
                                            <!-- END PAGE CONTENT INNER -->

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- END PAGE CONTENT BODY -->
