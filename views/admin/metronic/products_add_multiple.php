                    <div class="row ">
					
						<div class="col-md-12">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light">
								<div class="portlet-title">
								
									<?php
									/***********
									 * Noification area
									 */
									?>
									<?php if (validation_errors()) { ?>
									<div class="alert alert-danger ">
										<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
									</div>
									<?php } ?>
									
									<div class="caption font-dark">
										<i class="icon-settings font-dark"></i>
										<span class="caption-subject bold uppercase"> <?php echo $page_title; ?></span> 
									</div>
								</div>
								<div class="portlet-body">
								
									<div class="col-md-4">
									
										<div class="row">
											<div class="col-md-12">
												<h1>Adding Multiple Products</h1>
												<hr />
												<h3>Select Designer and Category first</h3>
												<p>Adding multiple products is only available on a per designer/category basis. Thus, selecting a specific designer and category for the products to be added is a must.</p>
												<h3>Ways to add multilple products:</h3>
												<ol>
													<li>By Product Number:<br />Type in comma separated product numbers.<br />For example: D5012L, D4114L, etc...</li>
													<li>By Product Number and color code:<br />If primary color is already available, type in comma separated product numbers with color codes.<br />For example: D5012L_BLAC1, D4114L_NAVY1, etc...<br /><small><em>Make sure that color codes are correct.</em></small></li>
													<li>By Product Number and color code and wholesale price:<br />If primary color and wholesale price is available, type in comma separated product number with color code and wholesale price.<br />For example: D5012L_BLAC1_450, D4114L_NAVY1_350, etc...<br /><small><em>It is already assumed that retail price is double the wholesale price.</em></small></li>
												</ol>
												<p>Choose only one way of adding products. Mixing different product number types may cause unwanted effects on the records.</p>
											</div>
										</div>
										
									</div>
									<div class="col-md-8 margin-top-30">
									
										<!-- BEGIN FORM-->
										<!-- FORM =======================================================================-->
										<?php echo form_open($this->config->slash_item('admin_folder').'products/add/multiple', array('class'=>'form-horizontal', 'id'=>'form-styles_facets_bulk_actions')); ?>
										
										<div class="form-group">
											<label class="col-md-3 control-label">Designer:
												<span class="required"> * </span>
											</label>
											<div class="col-md-9">
												<select class="bs-select form-control" name="designer" data-live-search="true" data-size="5">
													<option value=""> - select one - </option>
													<?php if ($designers) { ?>
													<?php foreach ($designers as $designer) { ?>
													<?php if ($designer->url_structure !== SITESLUG) { ?>
													<option value="<?php echo $designer->des_id; ?>" <?php echo  set_select('designer', $designer->des_id); ?> data-url_structure="<?php echo $designer->url_structure; ?>"> <?php echo $designer->designer; ?> </option>
													<?php } } } ?>
												</select>
												<input type="hidden" name="designer_slug" value="<?php echo set_value('designer_slug'); ?>" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Categories:
												<span class="required"> * </span>
											</label>
											<div class="col-md-9">
												<select class="bs-select form-control" name="subcat_id" data-show-subtext="true"  data-live-search="true" data-size="5" >
													<option value=""> - select one - </option>
													<?php if ($designers) { ?>
													<?php foreach ($designers as $designer) { ?>
													<?php if ($designer->url_structure !== SITESLUG) { ?>
													<?php $des_categories = $this->categories->treelist(array('d_url_structure'=>$designer->url_structure)); ?>
													<?php if ($des_categories) { ?>
													<?php foreach ($des_categories as $category) { ?>
													<?php if ($category->category_slug != 'apparel') { ?>
													<option class="all-options <?php echo $designer->des_id; ?>" value="<?php echo $category->category_id; ?>" <?php echo  set_select('subcat_id', $category->category_id); ?> data-subtext="<?php echo $designer->designer; ?>" data-subcat_slug="<?php echo $category->category_slug; ?>"> &gt; <?php echo $category->category_name; ?> </option>
													<?php } } } } } } ?>
												</select>
												<input type="hidden" name="subcat_slug" value="<?php echo set_value('subcat_slug'); ?>" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-3 control-label">Product Nos:
												<span class="required"> * </span>
											</label>
											<div class="col-md-9">
												<textarea class="form-control" name="products" rows="5" placeholder="Type comma separated product numbers here" style="text-transform:uppercase;"><?php echo set_value('products'); ?></textarea>
											</div>
										</div>
										<br />
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<button type="submit" class="btn sbold blue">Submit</button>
											</div>
										</div>
										<br />
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="note note-info">
													<h4 class="block">NOTES:</h4>
													<ol>
														<li> All product added via this page are initially set to UNPUBLISH-ed. </li>
													</ol>
												</div>
											</div>
										</div>
										
										</form>
										<!-- End FORM =======================================================================-->
										<!-- END FORM-->
										
									</div>
								</div>
                            </div>
                            <!-- END \PORTLET-->
						</div>
						
                    </div>
                    <!-- END PAGE CONTENT BODY -->
					

