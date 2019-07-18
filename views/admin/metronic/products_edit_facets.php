												<?php
												/***********
												 * Noification area
												 */
												?>
												<div>
													<?php if ($this->session->flashdata('color_exists')) { ?>
													<div class="alert alert-danger auto-remove" style="margin-bottom:50px;">
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
														<i class="fa fa-warning fa-lg"></i> Color already esists...
													</div>
													<?php } ?>
												</div>
												
												<div class="note note-info">
													<h4 class="block">NOTES:</h4>
													<p> <strong>Color Facets</strong> are found within each color variant of the product item at the "Colors &amp; Images" tab. </p>
												</div>
												
												<div class="form-body" data-base_url="<?php echo base_url(); ?>" data-object_data='{"prod_id":"<?php echo $this->product_details->prod_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>","prod_no":"<?php echo $this->product_details->prod_no; ?>"}'>
												
													<?php if ($this->webspace_details->slug === 'tempoparis') { ?>
														<?php if ( ! empty($events)) { ?>
													
													<div class="form-group" >
														<label class="control-label">Seasons Facet:</label>
														<div class="mt-checkbox-inline" data-facet_type="events">
															
															<?php 
															foreach ($events as $event) { 
															$events_check = in_array(strtoupper($event->event_name), $this->product_details->event_facets) ? 'checked="checked"' : '';
															?>
															
															<label class="mt-checkbox mt-checkbox-outline col-md-3 col-sm-5">
																<input type="checkbox" class="facets" name="events[]" value="<?php echo $event->event_name; ?>" <?php echo $events_check; ?> /> <?php echo $event->event_name; ?>
																<span></span>
															</label>
															
															<?php } ?>
															
														</div>
													</div>
												
														<?php } ?>
													<?php } ?>
													
													<?php if ( ! empty($styles)) { ?>
													
													<div class="form-group">
														<label class="control-label">Styles Facet:</label>
														<div class="mt-checkbox-inline" data-facet_type="styles">
															
															<?php 
															foreach ($styles as $style) { 
															$styles_check = in_array(strtoupper($style->style_name), $this->product_details->style_facets) ? 'checked="checked"' : '';
															?>
															
															<label class="mt-checkbox mt-checkbox-outline col-md-3 col-sm-5">
																<input type="checkbox" class="facets" name="styles[]" value="<?php echo $style->style_name; ?>" <?php echo $styles_check; ?> /> <?php echo $style->style_name; ?>
																<span></span>
															</label>
															
															<?php } ?>
															
														</div>
													</div>

													<?php } ?>

													<?php if ($this->webspace_details->slug !== 'tempoparis') { ?>
														<?php if ( ! empty($events)) { ?>
													
													<div class="form-group">
														<label class="control-label">Events Facet:</label>
														<div class="mt-checkbox-inline" data-facet_type="events">
															
															<?php 
															foreach ($events as $event) { 
															$events_check = in_array(strtoupper($event->event_name), $this->product_details->event_facets) ? 'checked="checked"' : '';
															?>
															
															<label class="mt-checkbox mt-checkbox-outline col-md-3 col-sm-5">
																<input type="checkbox" class="facets" name="events[]" value="<?php echo $event->event_name; ?>" <?php echo $events_check; ?> /> <?php echo $event->event_name; ?>
																<span></span>
															</label>
															
															<?php } ?>
															
														</div>
													</div>

														<?php } ?>
													<?php } ?>
													
													<?php if ( ! empty($materials)) { ?>
													
													<div class="form-group">
														<label class="control-label">Materials Facet:</label>
														<div class="mt-checkbox-inline" data-facet_type="materials">
															
															<?php 
															foreach ($materials as $material) { 
															$materials_check = in_array(strtoupper($material->material_name), $this->product_details->material_facets) ? 'checked="checked"' : '';
															?>
															
															<label class="mt-checkbox mt-checkbox-outline col-md-3 col-sm-5">
																<input type="checkbox" class="facets" name="materials[]" value="<?php echo $material->material_name; ?>" <?php echo $materials_check; ?> /> <?php echo $material->material_name; ?>
																<span></span>
															</label>
															
															<?php } ?>
															
														</div>
													</div>

													<?php } ?>

													<?php if ( ! empty($trends)) { ?>
												
													<div class="form-group">
														<label class="control-label">Trends Facet:</label>
														<div class="mt-checkbox-inline" data-facet_type="trends">
															
															<?php 
															foreach ($trends as $trend) { 
															$trends_check = in_array(strtoupper($trend->trend_name), $this->product_details->trend_facets) ? 'checked="checked"' : '';
															?>
															
															<label class="mt-checkbox mt-checkbox-outline col-md-3 col-sm-5">
																<input type="checkbox" class="facets" name="trends[]" value="<?php echo $trend->trend_name; ?>" <?php echo $trends_check; ?> /> <?php echo $trend->trend_name; ?>
																<span></span>
															</label>
															
															<?php } ?>
															
														</div>
													</div>

													<?php } ?>

												</div>