                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">

                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> <?php echo $page_title; ?> Table</span>
                                    </div>
									<!-- DOC: Remove "hide" class to enable -->
                                    <div class="actions hide">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="portlet-body" data-active_designer="<?php echo $active_designer; ?>">

									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
										$this->config->slash_item('admin_folder').'products/set_active_designer_category',
										array(
											'id'=>'form-admin_product_filters'
										)
									); ?>

    									<input type="hidden" name="set-from" value="product_csv" />

    									<div class="row margin-bottom-30">
    										<div class="alert alert-danger display-hide">
    											<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
    										<div class="col-xs-12 col-sm-3">
    											<div class="form-group">
    												<select class="bs-select form-control" name="designer" data-live-search="true" data-size="5">
    													<?php if ($designers) { ?>
    													<?php foreach ($designers as $designer) { ?>
    													<?php
    													if (
    														$this->webspace_details->options['site_type'] === 'hub_site'
    														&& $designer->url_structure != $this->webspace_details->slug
    														&& $designer->with_products === '1'
    													) {
    													?>
    													<option value="<?php echo $designer->url_structure; ?>" <?php echo $active_designer == $designer->url_structure ? 'selected="selected"' : ''; ?>>
    														<?php echo $designer->designer; ?>
    													</option>
    													<?php } else if (
    														$this->webspace_details->options['site_type'] !== 'hub_site'
    														&& (
    															$designer->url_structure === $this->webspace_details->slug
    															OR $designer->folder === $this->webspace_details->slug  // backwards compatibility for 'basix-black-label'
    														)
    														&& $designer->with_products === '1'
    													) { ?>
    													<option value="<?php echo $designer->url_structure; ?>" <?php echo $active_designer == $designer->url_structure ? 'selected="selected"' : ''; ?>>
    														<?php echo $designer->designer; ?>
    													</option>
    													<?php } ?>
    													<?php } ?>
    													<?php } ?>
    												</select>
    											</div>
    										</div>
    										<div class="col-xs-12 col-sm-3">
    											<div class="form-group">
    												<div class="form-control height-auto categories-checkbox_treelist">
    													<div class="category_treelist scroller" style="height:150px;" data-always-visible="1" data-handle-color="#637283">
    														<ul class="list-unstyled">

    														<?php
    														/**********
    														 * Load the categories as a list only
    														 */
    														$ic = 1;
    														foreach ($categories as $category)
    														{
    															// set if 'uncategorized' is checked or not
    															if (is_array($active_category)) $uncat_select = in_array('0', $active_category) ? 'checked': '';
    															else $uncat_select = ($active_category == '0' OR $active_category == 'uncategorized') ? 'checked': '';

    															// set select if category is already selected
    															if (is_array($active_category)) $select = in_array($category->category_id, $active_category) ? 'checked': '';
    															else $select = $active_category == $category->category_slug ? 'checked': '';

    															if (($uncat_select OR ! $select)  && $ic == 1)
    															{ ?>
    															<li>
    																<label><input type="checkbox" name="categories[]" class="category_treelist 0" value="0" data-parent_category="0" data-category_slug="uncategorized" <?php echo $uncat_select; ?>> Uncategorized </label>
    															</li>
    																<?php
    																$ic++;
    															}
    															?>

    															<li>
    																<label><input type="checkbox" name="categories[]" class="category_treelist <?php echo $category->category_id; ?>" value="<?php echo $category->category_id; ?>" data-parent_category="<?php echo $category->parent_category; ?>" data-category_slug="<?php echo $category->category_slug; ?>" <?php echo $select; ?>> <?php echo $category->category_name; ?> &nbsp; <em class="small">(<?php echo $category->category_slug; ?>)</em> </label>
    															</li>

    															<?php
    														}
    														?>

    														</ul>
    													</div>
    												</div>
    												<cite class="help-block small"> Select as many categories you want. A certain category may show no products for specific designers. </cite>
    											</div>
    										</div>
    										<div class="col-xs-12 col-sm-6">
    											<input class="btn btn-primary" type="submit" name="filter_proucts" value="Apply Filter" />
    											<br /><br />
    											<div class="note note-warning">
    												<h4 class="block">Notice! ... before editing.</h4>
    												<p> Please ensure that you know what you are doing in editing CSV files. Data is delicate and can render a product item inaccessible to public users as well as admin. </p>
    											</div>
    										</div>
    									</div>

									</form>
									<!-- End FORM ===================================================================-->
									<!-- END FORM-->

									<?php
									/**********
									 * Notifications
									 */
									?>
									<div>
										<div id="an_error_occured" class="alert alert-danger display-hide">
											<button class="close" data-close="alert"></button> An error occured. Please try again. </div>
										<div id="new_user_added" class="alert alert-success display-hide">
											<button class="close" data-close="alert"></button> New User ADDED! </div>
										<div id="information_updated" class="alert alert-success display-hide">
											<button class="close" data-close="alert"></button> Information updated </div>
										<?php if ($this->session->flashdata('error') == 'csv_headers_error') { ?>
										<div class="alert alert-danger ">
											<button class="close" data-close="alert"></button> CSV File was not authenticated properly. Please download a fresh CSV File before editing file.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'csv_update') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> CSV File being updated.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'csv_upload_update') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> CSV File uploaded and records have been updated.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> There was an error with your request. Please try again.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'zero_search_result') { ?>
										<div class="alert alert-danger">
											<button class="close" data-close="alert"></button> There were no records of the search. Please try to browse through products listing below.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'post_data_error') { ?>
										<div class="alert alert-danger ">
											<button class="close" data-close="alert"></button> An error occured in posting data. Error - <br />
											<?php echo $this->session->flashdata('error_value') ?: 'Unknown'; ?>
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'add') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> New Product ADDED!
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'edit') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Product information updated.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'delete') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Product permanently removed from records.
										</div>
										<?php } ?>
									</div>

                                    <!-- TOOLBAR -->
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
													<button id="add_new_product" class="btn sbold blue"> Add New Product
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="btn-group">
													<button id="cancel_edit" class="btn sbold red-flamingo display-hide"> Cancel Edit
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
												<div class="btn-group pull-right">
													<button class="btn green btn-solid dropdown-toggle" data-toggle="dropdown" aria-expanded="false">CSV Tools
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu pull-right tooltips " data-container="body" data-placement="left" data-original-title="Always update CSV file to enable download and to ensure getting most recent information. It is recommended to minimize selected categories especially to only 1 category on the filter before updating and downloading csv file.">
														<li>
															<a href="<?php echo site_url('admin/products/csv/update_csv_file'); ?>" onclick="$('#loading').modal('show');">
																<i class="fa fa-save"></i> Update CSV File </a>
														</li>
														<li class="divider"> </li>
														<li>
															<?php if ($csv_filename) { ?>
															<a href="<?php echo base_url(); ?>csv/products/<?php echo $csv_filename; ?>.php">
															<?php } else { ?>
															<a href="javascript:;" class="disabled-link disable-target">
															<?php } ?>
																<i class="fa fa-download"></i> Download CSV File </a>
														</li>
														<li>
															<a href="javascript:;" class="disabled-link disable-target">
															<!--<a href="#modal-csv_upload" data-toggle="modal">-->
																<i class="fa fa-upload"></i> Upload CSV File </a>
														</li>
													</ul>
												</div>
											</div>
                                        </div>
                                    </div>

                                    <?php
									/**********
									 * Editabe Datable
									 */
									?>
                                    <?php //$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'products_csv_table'); ?>

                                    <?php
                                    /*********
                                     * This style a fix to the dropdown menu inside table-responsive table-scrollable
                                     * datatables. Setting position to relative allows the main dropdown button to
                                     * follow cell during responsive mode. A jquery is also needed on the button to
                                     * toggle class to change back position to absolute so that the dropdown menu
                                     * shows even on overflow.
                                     */
                                    ?>
                                    <style>
                                        .dropdown-fix {
                                            position: relative;
                                        }
                                    </style>

                                    <?php
                                    /**********
                                     * Datatable
                                     */
                                    ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-product_list_csv" data-product_count="<?php echo @$products_count; ?>" data-number_of_colums="<?php echo @$size_mode == '1' ? '45' : '40'; ?>" data-size_mode="<?php echo @$size_mode; ?>" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                        <!-- THEAD -->
                                        <thead>
                                            <tr>
                                                <th> Edit </th>
                                                <th> Prod ID </th>
                                                <th> Prod No </th>
                                                <th> Prod Name </th>
                                                <th> <div style="width:250px;">Prod Desc</div> </th>
                                                    <th> Prod Date </th>
                                                <th> Seque </th>
                                                <th> Public/Private </th>
                                                <th> Publish </th>
                                                <th> Publish Date </th>
                                                    <th> Size Mode </th>
                                                <th> Categories </th>
                                                    <th> Cat </th>
                                                    <th> Subcat </th>
                                                <th> Retail Price </th>
                                                    <th> On Sale Price </th>
                                                <th> Wholesale Price </th>
                                                <th> Clearance Price </th>
                                                <th> Designer </th>
                                                <th> Vendor </th>
                                                    <th> Vendor Code </th>
                                                <th> Vendor Type </th>
                                                <th> <div style="width:250px;">Styles Facet</div> </th>
                                                <th> <div style="width:250px;">Events Facet</div> </th>
                                                <th> <div style="width:250px;">Materials Facet</div> </th>
                                                    <th> <div style="width:250px;">Trends Facet</div> </th>
                                                <th> <div style="width:250px;">Color Facet</div> </th>
                                                <th> Clearance </th>
                                                <th> Stock ID </th>
                                                <th> Color Name </th>
                                                    <th> Color Publish </th>
                                                <th> Primary Color </th>
                                                <th> Stock Date </th> <!-- index 32 -->
                                                <?php if (@$size_mode == '1') { ?>
                                                <th> Size 0 </th>
                                                <th> Size 2 </th>
                                                <th> Size 4 </th>
                                                <th> Size 6 </th>
                                                <th> Size 8 </th>
                                                <th> Size 10 </th>
                                                <th> Size 12 </th>
                                                <th> Size 14 </th>
                                                <th> Size 16 </th>
                                                <th> Size 18 </th>
                                                <th> Size 20 </th>
                                                <th> Size 22 </th>
                                                <?php } ?>
                                                <?php if (@$size_mode == '0') { ?>
                                                <th> Size S </th>
                                                <th> Size M </th>
                                                <th> Size L </th>
                                                <th> Size XL </th>
                                                <th> Size XXL </th>
                                                <th> Size XL1 </th>
                                                <th> Size XL2 </th>
                                                <?php } ?>
                                                <th> Del </th>
                                            </tr>
                                        </thead>

                                        <!-- TBODY -->
                                        <tbody>

                                            <?php
                                            if ($products)
                                            {
                                                $i = 1;
                                                foreach ($products as $product)
                                                {
                                                    ?>

                                            <tr class="odd gradeX" data-size_mod="<?php echo $product->size_mode; ?>">
                                                <td> <a class="edit" href="javascript:;" data-counter="<?php echo $i; ?>">Edit</a> </td>
                                                <td class="text-center"> <?php echo $product->prod_id; ?> </td>
                                                <td> <?php echo $product->prod_no; ?> </td>
                                                <td> <?php echo $product->prod_name; ?> </td>
                                                <td> <?php echo $product->prod_desc; ?> </td>
                                                <td> <?php echo $product->prod_date; ?> </td>
                                                <td> <?php echo $product->seque; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Public Options:" data-content="Y-Public, N-Private">
                                                    <?php echo $product->public; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Publish Options:" data-content="1-Publish, 11-Publish at hub, 12-Publish at satellite site, 2-Private, 0-Unpublish">
                                                    <?php echo $product->publish; ?> </td>
                                                <td> <?php echo $product->publish_date; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Size Mode Options:" data-content="1-(0,2,4,6...22), 0-(S,M,L,XL...)">
                                                    <?php echo $product->size_mode; ?> </td>
                                                <td>
                                                    <?php
                                                    /**********
                                                     * Categories - process to get slugs
                                                     */
                                                    ?>
                                                    <?php
                                                    $the_categories = json_decode($product->categories, TRUE);
                                                    foreach($categories as $category)
                                                    {
                                                        if (in_array($category->category_id, $the_categories)) echo $category->category_slug.',';
                                                    }
                                                    ?>
                                                </td>
                                                <td> <?php echo $product->c_url_structure; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Subcat Options:" data-content="<?php foreach($categories as $category) { echo $category->category_id != '1' ? $category->category_slug.', ' : ''; }?>">
                                                    <?php echo $product->sc_url_structure; ?> </td>
                                                <td> <?php echo $product->less_discount; ?> </td>
                                                <td> <?php echo $product->catalogue_price; ?> </td>
                                                <td> <?php echo $product->wholesale_price; ?> </td>
                                                <td> <?php echo $product->wholesale_price_clearance; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Designer Options:" data-content="<?php foreach($designers as $designer){ echo $designer->url_structure.', '; }?>"> <?php echo $product->d_url_structure; ?> </td>
                                                <td> <?php echo $product->vendor_name; ?> </td>
                                                <td> <?php echo $product->vendor_code; ?> </td>
                                                <td> <?php echo $product->type; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Styles Facet"> <?php echo $product->styles; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Events Facet"> <?php echo $product->events; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Materials Facet"> <?php echo $product->materials; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Trends Facet"> <?php echo $product->trends; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Colors Facet"> <?php echo $product->color_facets; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Clearance Options:" data-content="1-On Clearance, 0-Regular Sale">
                                                    <?php echo $product->clearance; ?> </td>
                                                <td> <?php echo $product->st_id; ?> </td>
                                                <td> <?php echo $product->color_name; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Per Color Publish Options:" data-content="1-Publish, 11-Publish at hub, 12-Publish at satellite site, 2-Private, 0-Unpublish">
                                                    <?php echo $product->new_color_publish; ?> </td>
                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Per Color Publish Options:" data-content="1-Primary, 0-Non primary">
                                                    <?php echo $product->primary_color; ?> </td>
                                                <td> <?php echo $product->stock_date; ?> </td>
                                                <?php if ($product->size_mode == '1') { ?>
                                                <td> <?php echo $product->size_0; ?> </td>
                                                <td> <?php echo $product->size_2; ?> </td>
                                                <td> <?php echo $product->size_4; ?> </td>
                                                <td> <?php echo $product->size_6; ?> </td>
                                                <td> <?php echo $product->size_8; ?> </td>
                                                <td> <?php echo $product->size_10; ?> </td>
                                                <td> <?php echo $product->size_12; ?> </td>
                                                <td> <?php echo $product->size_14; ?> </td>
                                                <td> <?php echo $product->size_16; ?> </td>
                                                <td> <?php echo $product->size_18; ?> </td>
                                                <td> <?php echo $product->size_20; ?> </td>
                                                <td> <?php echo $product->size_22; ?> </td>
                                                <?php } ?>
                                                <?php if ($product->size_mode == '0') { ?>
                                                <td> <?php echo $product->size_ss; ?> </td>
                                                <td> <?php echo $product->size_sm; ?> </td>
                                                <td> <?php echo $product->size_sl; ?> </td>
                                                <td> <?php echo $product->size_sxl; ?> </td>
                                                <td> <?php echo $product->size_sxxl; ?> </td>
                                                <td> <?php echo $product->size_sxl1; ?> </td>
                                                <td> <?php echo $product->size_sxl2; ?> </td>
                                                <?php } ?>
                                                <td> <a class="edit" href="javascript:;" data-counter="<?php echo $i; ?>">Edit</a> / <a class="delete" href="javascript:;">Delete</a> </td>
                                            </tr>

                                                    <?php
                                                    $i++;
                                                }
                                            } ?>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->

                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->

			<!-- BEGIN PAGE MODALS -->
			<!-- CSV FILE UPLOAD -->
			<div class="modal fade bs-modal-lg" id="modal-csv_upload" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg" id="modal-csv_upload-modal-dialog">
					<div class="modal-content" id="modal-csv_upload-modal-content">

						<!-- BEGIN FORM-->
						<!-- FORM =======================================================================-->
						<?php echo form_open(
							$this->config->slash_item('admin_folder').'products/csv/upload_csv_file',
							array(
								'method'=>'POST',
								'enctype'=>'multipart/form-data',
								'class'=>'form-horizontal',
								'id'=>'form-products_upload_csv'
							)
						); ?>

						<input type="hidden" id="base_url" name="base_url" value="<?php echo base_url(); ?>" />

						<div class="modal-header">
							<button type="button" class="close modal-close_btn" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Upload Wholesale User CSV File</h4>
						</div>
						<div class="modal-body">
							<strong>NOTES:</strong>
							<ol>
								<li>Data from CSV file will overwrite data on record.</li>
								<li>CSV File Upload is to update records only. No data from server will be deleted. If it is a must to delete records, go to the regular Product List <a href="<?php echo site_url($this->config->slash_item('admin_folder').'products'); ?>">here</a> and do a bulk action delete instead.</li>
								<li>The system will update existing record per 'Product ID'.</li>
								<li>For NEW PRODUCTs, please ensure that Product ID column is empty, then record will be added creating a new Product ID.</li>
								<li>CSV file headers will be cross checked againts set record fields and validated accordingly. If header differences are found, file will not be uploaded. Download updated CSV file instead, and then, do the edits again.</li>
							</ol>
							<div class="note note-success">
								<h4 class="block">Notorioius EXEL behaviour</h4>
								<p> Exel has an inherent way of changing data especially numbers like turning rather large regular numbers to scientific notations. It is best to edit the data directly here on this CSV Manage Products page as oppose to editing CSV files via Exel. </p>
							</div>
							<br /><br />
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="input-group input-large">
									<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
										<i class="fa fa-file fileinput-exists"></i>&nbsp;
										<span class="fileinput-filename"> </span>
									</div>
									<span class="input-group-addon btn default btn-file">
										<span class="fileinput-new"> Select file </span>
										<span class="fileinput-exists"> Change </span>
										<input type="file" name="file"> </span>
									<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
								</div>
							</div>
							<br /><br />
						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline modal-close_btn" data-dismiss="modal">Close</button>
							<button type="sbumit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left" disabled id="btn-csv_upload">
								<span class="ladda-label">Upload</span>
								<span class="ladda-spinner"></span>
							</button>
						</div>

						</form>
						<!-- End FORM =======================================================================-->
						<!-- END FORM-->

					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END PAGE MODALS -->
