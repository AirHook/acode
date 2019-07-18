		<!-- BEGIN GLOBAL MODALS -->
		<!-- LOADING -->
		<div class="modal fade bs-modal-sm" id="loading" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Loading...</h4>
					</div>
					<div class="modal-body text-center">
						<p class="modal-body-text"></p>
						<i class="fa fa-spinner fa-spin fa-3x text-danger" aria-hidden="true" style="margin:35px 0;"></i>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- RELOADING -->
		<div class="modal fade bs-modal-sm" id="reloading" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Reloading...</h4>
					</div>
					<div class="modal-body text-center">
						<p class="modal-body-text">You have been idle for quite a while.</p>
						<i class="fa fa-spinner fa-spin fa-3x text-danger" aria-hidden="true" style="margin:35px 0;"></i>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<?php
		/**
		 * Filter/Sort By for mobile devices
		 */
		?>
		<!-- FILTER BY -->
		<div class="modal fade in" id="modal-mobile-filter" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-full" style="height:97%;overflow-y: initial !important;">
				<div class="modal-content" style="height:100%;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Filter:</h4>
					</div>
					<div class="modal-body" style="height:80%;overflow-y:auto;">

						<div class="panel-group accordion" id="accordion3">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">
											Size <?php echo @$_GET['size'] ? '('.count(explode(',', $_GET['size'])).')' : ''; ?>
										</a>
									</h4>
								</div>
								<div id="collapse_3_1" class="panel-collapse collapse">
									<div class="panel-body">

										<form action="" method="GET">

											<input type="hidden" name="filter" value="" />
											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
											<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['material'] AND $_GET['material'] !== 'all'): ?>
											<input type="hidden" name="material" value="<?php echo $_GET['material']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
											<?php endif; ?>

											<input type="hidden" name="size" value="<?php echo @$_GET['size'] ?: ''; ?>" />

											<p class="action clearfix">
												<button class="btn dark pull-right" type="submit"> Apply </button>
												<?php if (@$_GET['size']) { ?>
												<a class="btn btn-link pull-right mobile-clear-filter" data-facet_type="size" href="javascript:;" style="color:black;"> Clear </a>
												<?php } ?>
											</p>

										</form>

										<div class="form-group clearfix" style="margin-bottom:5px;">
											<label class="control-label">Size:</label>
											<div class="mt-checkbox-inline" data-facet_type="size">

												<?php
												if (@$size_array)
												{
													foreach($size_array as $size)
													{
														if (@$_GET['size'])
														{
															$sizes_at_url = explode(',', $_GET['size']);
															$size_check = in_array($size, $sizes_at_url) ? 'checked="checked"' : '';
														}
														else $size_check = '';
														?>

												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="checkbox" class="facets" name="size[]" data-tag_name="size" value="<?php echo $size; ?>" <?php echo $size_check; ?> /> <?php echo 'Size '.$size; ?>
													<span></span>
												</label>

														<?php
													}
												} ?>

											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2">
											Color <?php echo @$_GET['color'] ? '('.count(explode(',', $_GET['color'])).')' : ''; ?>
										</a>
									</h4>
								</div>
								<div id="collapse_3_2" class="panel-collapse collapse">
									<!-- DOC: Add style="height:200px;overflow-y:auto;" to specify height and let it scroll instead -->
									<div class="panel-body" >

										<form action="" method="GET">

											<input type="hidden" name="filter" value="" />
											<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
											<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['material'] AND $_GET['material'] !== 'all'): ?>
											<input type="hidden" name="material" value="<?php echo $_GET['material']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
											<?php endif; ?>

											<input type="hidden" name="color" value="<?php echo @$_GET['color'] ?: ''; ?>" />

											<p class="action clearfix">
												<button class="btn dark pull-right" type="submit"> Apply </button>
												<?php if (@$_GET['color']) { ?>
												<a class="btn btn-link pull-right mobile-clear-filter" data-facet_type="color" href="javascript:;" style="color:black;"> Clear </a>
												<?php } ?>
											</p>

										</form>

										<div class="form-group clearfix" style="margin-bottom:5px;">
											<label class="control-label">Color:</label>
											<div class="mt-checkbox-inline" data-facet_type="color">

												<?php
												if (@$color_array)
												{
													foreach($color_array as $color)
													{
														if (@$_GET['color'])
														{
															$colors_at_url = explode(',', $_GET['color']);
															$color_check = in_array($color, $colors_at_url) ? 'checked="checked"' : '';
														}
														else $color_check = '';
														?>

												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="checkbox" class="facets color_facets" name="color[]" data-tag_name="color" value="<?php echo $color; ?>" <?php echo $color_check; ?> /> <?php echo ucfirst($color); ?>
													<span></span>
												</label>

														<?php
													}
												} ?>

											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3">
											Occasion <?php echo @$_GET['occasion'] ? '('.count(explode(',', $_GET['occasion'])).')' : ''; ?>
										</a>
									</h4>
								</div>
								<div id="collapse_3_3" class="panel-collapse collapse">
									<div class="panel-body">

										<form action="" method="GET">

											<input type="hidden" name="filter" value="" />
											<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['material'] AND $_GET['material'] !== 'all'): ?>
											<input type="hidden" name="material" value="<?php echo $_GET['material']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
											<?php endif; ?>

											<input type="hidden" name="occasion" value="<?php echo @$_GET['occasion'] ?: ''; ?>" />

											<p class="action clearfix">
												<button class="btn dark pull-right" type="submit"> Apply </button>
												<?php if (@$_GET['occasion']) { ?>
												<a class="btn btn-link pull-right mobile-clear-filter" data-facet_type="occasion" href="javascript:;" style="color:black;"> Clear </a>
												<?php } ?>
											</p>

										</form>

										<div class="form-group clearfix" style="margin-bottom:5px;">
											<label class="control-label">Occasion:</label>
											<div class="mt-checkbox-inline" data-facet_type="occasion">

												<?php
												if (@$occasion_array)
												{
													foreach($occasion_array as $occasion)
													{
														if (@$_GET['occasion'])
														{
															$occasions_at_url = explode(',', $_GET['occasion']);
															$occasion_check = in_array($occasion, $occasions_at_url) ? 'checked="checked"' : '';
														}
														else $occasion_check = '';
														?>

												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="checkbox" class="facets" name="occasion[]" data-tag_name="occasion" value="<?php echo $occasion; ?>" <?php echo $occasion_check; ?> /> <?php echo ucfirst($occasion); ?>
													<span></span>
												</label>

														<?php
													}
												} ?>

											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_4">
											Style <?php echo @$_GET['style'] ? '('.count(explode(',', $_GET['style'])).')' : ''; ?>
										</a>
									</h4>
								</div>
								<div id="collapse_3_4" class="panel-collapse collapse">
									<div class="panel-body">

										<form action="" method="GET">

											<input type="hidden" name="filter" value="" />
											<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
											<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['material'] AND $_GET['material'] !== 'all'): ?>
											<input type="hidden" name="material" value="<?php echo $_GET['material']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
											<?php endif; ?>

											<input type="hidden" name="style" value="<?php echo @$_GET['style'] ?: ''; ?>" />

											<p class="action clearfix">
												<button class="btn dark pull-right" type="submit"> Apply </button>
												<?php if (@$_GET['style']) { ?>
												<a class="btn btn-link pull-right mobile-clear-filter" data-facet_type="style" href="javascript:;" style="color:black;"> Clear </a>
												<?php } ?>
											</p>

										</form>

										<div class="form-group clearfix" style="margin-bottom:5px;">
											<label class="control-label">Style:</label>
											<div class="mt-checkbox-inline" data-facet_type="style">

												<?php
												if (@$styles_array)
												{
													foreach($styles_array as $style)
													{
														if (@$_GET['style'])
														{
															$styles_at_url = explode(',', $_GET['style']);
															$style_check = in_array($style, $styles_at_url) ? 'checked="checked"' : '';
														}
														else $style_check = '';
														?>

												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="checkbox" class="facets" name="style[]" data-tag_name="style" value="<?php echo $style; ?>" <?php echo $style_check; ?> /> <?php echo ucfirst($style); ?>
													<span></span>
												</label>

														<?php
													}
												} ?>

											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="panel panel-default hide">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_5">
											Material <?php echo @$_GET['material'] ? '('.count(explode(',', $_GET['material'])).')' : ''; ?>
										</a>
									</h4>
								</div>
								<div id="collapse_3_5" class="panel-collapse collapse">
									<div class="panel-body">

										<form action="" method="GET">

											<input type="hidden" name="filter" value="" />
											<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
											<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
											<?php endif; ?>

											<input type="hidden" name="material" value="<?php echo @$_GET['material'] ?: ''; ?>" />

											<p class="action clearfix">
												<button class="btn dark pull-right" type="submit"> Apply </button>
												<?php if (@$_GET['material']) { ?>
												<a class="btn btn-link pull-right mobile-clear-filter" data-facet_type="material" href="javascript:;" style="color:black;"> Clear </a>
												<?php } ?>
											</p>

										</form>

										<div class="form-group clearfix" style="margin-bottom:5px;">
											<label class="control-label">Material:</label>
											<div class="mt-checkbox-inline" data-facet_type="material">

												<?php
												if (@$materials_array)
												{
													foreach($materials_array as $material)
													{
														if (@$_GET['material'])
														{
															$materials_at_url = explode(',', $_GET['material']);
															$material_check = in_array($material, $materials_at_url) ? 'checked="checked"' : '';
														}
														else $material_check = '';
														?>

												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="checkbox" class="facets" name="material[]" data-tag_name="material" value="<?php echo $material; ?>" <?php echo $material_check; ?> /> <?php echo ucfirst($material); ?>
													<span></span>
												</label>

														<?php
													}
												} ?>

											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_6">
											Availability <?php echo @$_GET['availability'] ? '('.count(explode(',', $_GET['availability'])).')' : ''; ?>
										</a>
									</h4>
								</div>
								<div id="collapse_3_6" class="panel-collapse collapse">
									<div class="panel-body">

										<form action="" method="GET">

											<input type="hidden" name="filter" value="" />
											<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
											<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['material'] AND $_GET['material'] !== 'all'): ?>
											<input type="hidden" name="material" value="<?php echo $_GET['material']; ?>" />
											<?php endif; ?>
											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
											<?php endif; ?>

											<input type="hidden" name="availability" value="<?php echo @$_GET['availability'] ?: ''; ?>" />

											<p class="action clearfix">
												<button class="btn dark pull-right" type="submit"> Apply </button>
												<?php if (@$_GET['availability']) { ?>
												<a class="btn btn-link pull-right mobile-clear-filter" data-facet_type="availability" href="javascript:;" style="color:black;"> Clear </a>
												<?php } ?>
											</p>

										</form>

										<div class="form-group clearfix" style="margin-bottom:5px;">
											<label class="control-label">Availbility <cite>(choose one only)</cite>:</label>
											<div class="mt-radio-inline" data-facet_type="availability">

												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="radio" class="facets" name="availability1" value="instock" <?php echo @$_GET['availability'] == 'instock' ? 'checked="checked"' : ''; ?> /> In Stock
													<span></span>
												</label>
												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="radio" class="facets" name="availability1" value="preorder" <?php echo @$_GET['availability'] == 'preorder' ? 'checked="checked"' : ''; ?> /> Pre Order
													<span></span>
												</label>
												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="radio" class="facets" name="availability1" value="onsale" <?php echo @$_GET['availability'] == 'onsale' ? 'checked="checked"' : ''; ?> /> On Sale
													<span></span>
												</label>
												<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
													<input type="radio" class="facets" name="availability1" value="all" <?php echo @$_GET['availability'] == 'all' ? 'checked="checked"' : ''; ?> /> All
													<span></span>
												</label>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer" style="position:fixed;left:0;right:0;bottom:0;background:#fff;">
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<a href="<?php echo site_url($this->uri->uri_string()); ?>" class="btn dark">Clear All Filters</a>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /modal -->

		<!-- SORT BY -->
		<div class="modal fade in" id="modal-mobile-sort" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-full" style="height:97%;">
				<div class="modal-content" style="height:100%;">

					<!-- BEGIN Form ==============================================================-->
					<?php echo form_open(
						'shop/sort_by',
						array(
							'id' => 'form-mobile-select-sort_by',
							'role' => 'form'
						)
					); ?>

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Sort:</h4>
					</div>
					<div class="modal-body" style="overflow-y:scroll;">

						<input type="hidden" name="uri_string" value="<?php echo $this->uri->uri_string(); ?>" />

						<div class="form-body">
							<div class="form-group">
								<div class="input-group">
									<div class="icheck-list">
										<label>
											<input type="radio" name="sort_by" value="featured" class="icheck" data-radio="iradio_square" <?php echo $this->session->sort_by == 'featured' ? 'checked' : ''; ?>>
											Featured <cite class="small">Not yet available</cite> </label>
										<label>
											<input type="radio" name="sort_by" value="best_sellers" class="icheck" data-radio="iradio_square" <?php echo $this->session->sort_by == 'best_sellers' ? 'checked' : ''; ?>>
											Best Sellers <cite class="small">Not yet available</cite> </label>
										<label>
											<input type="radio" name="sort_by" value="top_rated" class="icheck" data-radio="iradio_square" <?php echo $this->session->sort_by == 'top_rated' ? 'checked' : ''; ?>>
											Top Rated <cite class="small">Not yet available</cite> </label>
										<label>
											<input type="radio" name="sort_by" value="newest" class="icheck" data-radio="iradio_square" <?php echo $this->session->sort_by == 'newest' ? 'checked' : ''; ?>>
											Newest </label>
										<label>
											<input type="radio" name="sort_by" value="low-high" class="icheck" data-radio="iradio_square" <?php echo $this->session->sort_by == 'low-high' ? 'checked' : ''; ?>>
											Price: Low to High </label>
										<label>
											<input type="radio" name="sort_by" value="high-low" class="icheck" data-radio="iradio_square" <?php echo $this->session->sort_by == 'high-low' ? 'checked' : ''; ?>>
											Price: High to Low </label>
										<label>
											<input type="radio" name="sort_by" value="on_sale" class="icheck" data-radio="iradio_square" <?php echo $this->session->sort_by == 'on_sale' ? 'checked' : ''; ?>>
											On Sale </label>
										<label>
											<input type="radio" name="sort_by" value="default" class="icheck" data-radio="iradio_square" <?php echo $this->session->sort_by == 'default' ? 'checked' : ''; ?>>
											Default </label>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer" style="position:fixed;left:0;right:0;bottom:0;">
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn dark">Apply Changes</button>
					</div>

					</form>
					<!-- END Form ==============================================================-->

				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /modal -->
		<!-- END GLOBAL MODALS -->
