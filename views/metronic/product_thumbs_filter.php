														<?php
														/**********
														 * Filter Desktop Drop Downs
														 */
														?>
														<span> Filter By </span>
														<hr style="margin:5px 0 10px;border-color:#888;border-width:2px;" />

														<div class="produc-thumbs-filter-facets tabbable-line">
															<ul class="nav nav-tabs list-inline">
																<?php if ($size_array && count($size_array) > 0) { ?>
																<li class="">
																	<a href="#filter_size" data-toggle="tab"> Size </a>
																</li>
																<li><span class="separator"></span></li>
																<?php } ?>
																<?php if ($color_array && count($color_array) > 0) { ?>
																<li>
																	<a href="#filter_color" data-toggle="tab"> Color </a>
																</li>
																<li><span class="separator"></span></li>
																<?php } ?>
																<?php if ($occassion_array && count($occassion_array) > 0) { ?>
																<li>
																	<a href="#filter_occassion" data-toggle="tab"> Occassion </a>
																</li>
																<li><span class="separator"></span></li>
																<?php } ?>
																<?php if ($styles_array && count($styles_array) > 0) { ?>
																<li>
																	<a href="#filter_style" data-toggle="tab"> Styles </a>
																</li>
																<li><span class="separator"></span></li>
																<?php } ?>
																<?php if ($materials_array && count($materials_array) > 0) { ?>
																<li>
																	<a href="#filter_material" data-toggle="tab"> Materials </a>
																</li>
																<li><span class="separator"></span></li>
																<?php } ?>
																<li>
																	<a href="#filter_availability" data-toggle="tab"> Availability </a>
																</li>
															</ul>
															<div class="tab-content">

																<?php if ($size_array && count($size_array) > 0) { ?>

																<div class="tab-pane" id="filter_size">

																	<form action="" method="GET">

																		<input type="hidden" name="filter" value="" />
																		<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
																		<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
																		<?php endif; ?>
																		<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
																		<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
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
																			<a class="btn btn-link pull-right" href="javascript:;" onclick="$(this).closest('.tab-pane').removeClass('active');$('.produc-thumbs-filter .produc-thumbs-filter-facets > .nav-tabs > li').removeClass('active');" style="color:black;"> Cancel </a>
																		</p>

																	</form>

																	<div class="form-group clearfix" style="margin-bottom:5px;">
																		<label class="control-label">Size:</label>
																		<div class="mt-checkbox-inline" data-facet_type="size">

																			<?php
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
																			} ?>

																		</div>
																	</div>
																</div>

																<?php } ?>

																<?php if ($color_array && count($color_array) > 0) { ?>

																<div class="tab-pane" id="filter_color">

																	<form action="" method="GET">

																		<input type="hidden" name="filter" value="" />
																		<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
																		<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
																		<?php endif; ?>
																		<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
																		<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
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
																			<a class="btn btn-link pull-right" href="javascript:;" onclick="$(this).closest('.tab-pane').removeClass('active');$('.produc-thumbs-filter .produc-thumbs-filter-facets > .nav-tabs > li').removeClass('active');" style="color:black;"> Cancel </a>
																		</p>

																	</form>

																	<div class="form-group clearfix" style="margin-bottom:5px;">
																		<label class="control-label">Color:</label>
																		<div class="mt-checkbox-inline" data-facet_type="color">

																			<?php
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
																				<input type="checkbox" class="facets" name="color[]" data-tag_name="color" value="<?php echo $color; ?>" <?php echo $color_check; ?> /> <?php echo ucfirst($color); ?>
																				<span></span>
																			</label>

																				<?php
																			} ?>

																		</div>
																	</div>
																</div>

																<?php } ?>

																<?php if ($occassion_array && count($occassion_array) > 0) { ?>

																<div class="tab-pane" id="filter_occassion">

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

																		<input type="hidden" name="occassion" value="<?php echo @$_GET['occassion'] ?: ''; ?>" />

																		<p class="action clearfix">
																			<button class="btn dark pull-right" type="submit"> Apply </button>
																			<a class="btn btn-link pull-right" href="javascript:;" onclick="$(this).closest('.tab-pane').removeClass('active');$('.produc-thumbs-filter .produc-thumbs-filter-facets > .nav-tabs > li').removeClass('active');" style="color:black;"> Cancel </a>
																		</p>

																	</form>

																	<div class="form-group clearfix" style="margin-bottom:5px;">
																		<label class="control-label">Occassion:</label>occassion
																		<div class="mt-checkbox-inline" data-facet_type="occassion">

																			<?php
																			foreach($occassion_array as $occassion)
																			{
																				if (@$_GET['occassion'])
																				{
																					$occassions_at_url = explode(',', $_GET['occassion']);
																					$occassion_check = in_array($occassion, $occassions_at_url) ? 'checked="checked"' : '';
																				}
																				else $occassion_check = '';
																				?>

																			<label class="mt-checkbox mt-checkbox-outline col-xs-5 col-sm-2 col-md-2 col-lg-2">
																				<input type="checkbox" class="facets" name="occassion[]" data-tag_name="occassion" value="<?php echo $occassion; ?>" <?php echo $occassion_check; ?> /> <?php echo ucfirst($occassion); ?>
																				<span></span>
																			</label>

																				<?php
																			} ?>

																		</div>
																	</div>
																</div>

																<?php } ?>

																<?php if ($styles_array && count($styles_array) > 0) { ?>

																<div class="tab-pane" id="filter_style">

																	<form action="" method="GET">

																		<input type="hidden" name="filter" value="" />
																		<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
																		<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
																		<?php endif; ?>
																		<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
																		<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
																		<?php endif; ?>
																		<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
																		<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
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
																			<a class="btn btn-link pull-right" href="javascript:;" onclick="$(this).closest('.tab-pane').removeClass('active');$('.produc-thumbs-filter .produc-thumbs-filter-facets > .nav-tabs > li').removeClass('active');" style="color:black;"> Cancel </a>
																		</p>

																	</form>

																	<div class="form-group clearfix" style="margin-bottom:5px;">
																		<label class="control-label">Style:</label>
																		<div class="mt-checkbox-inline" data-facet_type="style">

																			<?php
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
																			} ?>

																		</div>
																	</div>
																</div>
																<?php } ?>

																<?php if ($materials_array && count($materials_array) > 0) { ?>

																<div class="tab-pane" id="filter_material">

																	<form action="" method="GET">

																		<input type="hidden" name="filter" value="" />
																		<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
																		<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
																		<?php endif; ?>
																		<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
																		<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
																		<?php endif; ?>
																		<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
																		<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
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
																			<a class="btn btn-link pull-right" href="javascript:;" onclick="$(this).closest('.tab-pane').removeClass('active');$('.produc-thumbs-filter .produc-thumbs-filter-facets > .nav-tabs > li').removeClass('active');" style="color:black;"> Cancel </a>
																		</p>

																	</form>

																	<div class="form-group clearfix" style="margin-bottom:5px;">
																		<label class="control-label">Material:</label>
																		<div class="mt-checkbox-inline" data-facet_type="material">

																			<?php
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
																			} ?>

																		</div>
																	</div>
																</div>

																<?php } ?>

																<div class="tab-pane" id="filter_availability">

																	<form action="" method="GET">

																		<input type="hidden" name="filter" value="" />
																		<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
																		<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
																		<?php endif; ?>
																		<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
																		<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
																		<?php endif; ?>
																		<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
																		<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
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
																			<a class="btn btn-link pull-right" href="javascript:;" onclick="$(this).closest('.tab-pane').removeClass('active');$('.produc-thumbs-filter .produc-thumbs-filter-facets > .nav-tabs > li').removeClass('active');" style="color:black;"> Cancel </a>
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

														<?php
														if (
															(@$_GET['size'] AND $_GET['size'] !== 'all')
															OR (@$_GET['color'] AND $_GET['color'] !== 'all')
															OR (@$_GET['occassion'] AND $_GET['occassion'] !== 'all')
															OR (@$_GET['style'] AND $_GET['style'] !== 'all')
															OR (@$_GET['material'] AND $_GET['material'] !== 'all')
															OR (@$_GET['price'] AND $_GET['price'] !== 'default')
															OR (@$_GET['availability'] AND $_GET['availability'] !== 'all')
														)
														{
															?>
														<div class="product-thumbs-filter-tagsinput" style="padding-top:10px;">

															<form action="" id="form_facet-tagsinput" method="GET">

																<input type="hidden" name="filter" value="" />
																<?php if (@$_GET['size'] AND $_GET['size'] !== 'all') { ?>
																<input type="text" class="facet-tagsinput" data-role="tagsinput" name="size" value="<?php echo $_GET['size']; ?>" />
																<?php } ?>
																<?php if (@$_GET['color'] AND $_GET['color'] !== 'all') { ?>
																<input type="text" class="facet-tagsinput" data-role="tagsinput" name="color" value="<?php echo $_GET['color']; ?>" />
																<?php } ?>
																<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all') { ?>
																<input type="text" class="facet-tagsinput" data-role="tagsinput" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
																<?php } ?>
																<?php if (@$_GET['style'] AND $_GET['style'] !== 'all') { ?>
																<input type="text" class="facet-tagsinput" data-role="tagsinput" name="style" value="<?php echo $_GET['style']; ?>" />
																<?php } ?>
																<?php if (@$_GET['material'] AND $_GET['material'] !== 'all') { ?>
																<input type="text" class="facet-tagsinput" data-role="tagsinput" name="material" value="<?php echo $_GET['material']; ?>" />
																<?php } ?>
																<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all') { ?>
																<input type="text" class="facet-tagsinput" data-role="tagsinput" name="availability" value="<?php echo $_GET['availability']; ?>" />
																<?php } ?>

															</form>

														</div>
															<?php
														}
														?>
