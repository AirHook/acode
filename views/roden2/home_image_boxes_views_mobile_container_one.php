										<?php
										/**********
										 * First image container
										 */
										?>
										<div class="container-one">
											<div class="inner">
												<div class="image-block box" style="width:400px;">
												
													<?php
													/**********
													 * Images size within this container is 600 x 886
													 */
													?>
													
													<?php
													// get the sliders for container four
													$selm1 = "
														SELECT *
														FROM tbl_index_image
														WHERE
															template = 'roden'
															AND options = 'm1'
														ORDER BY seq ASC
													";
													$qrym1 = $db->query($selm1);
													?>
													
													<?php if ($qrym1->num_rows() > 0): ?>

													<div class="fadeslideshow_wrapper">
														<div id="fadeshow_m1" class="fadeslideshow_container">
															<ul>
																
																<?php foreach($qrym1->result_array() as $row): ?>
																
																<li>
																	<a href="<?php echo $row['link'] ?: '#'; ?>" target="">
																	<img src="<?php echo base_url(); ?>roden_assets/uploads/sliders/<?php echo $row['image_name']; ?>" />
																	</a>
																</li>
																
																<?php endforeach; ?>
																
															</ul>
														</div>
													</div>
													
													<?php else: ?>

													<img class="not-loaded" src="<?php echo (@$homepage_options['one']['image_mobile'] AND file_exists('../roden_assets/uploads/'.$homepage_options['one']['image_mobile'])) ? base_url().'roden_assets/uploads/'.$homepage_options['one']['image_mobile'] : base_url().'roden_assets/images/051016_may_mobile_01.jpg'; ?>" alt="" style="width:100%;"/>
													
													<?php
													$msg = @_check_image_size('../roden_assets/uploads/'.$homepage_options['one']['image_mobile'], array('600', '886'));
													if ($msg AND is_string($msg)):
													?>
													<button type="button" class="small notice-over-image"><?php echo $msg; ?></button>
													<?php endif; ?>
													
													<div class="overbox"></div>
													<div class="overtext title">
														<button type="button" class="small" onclick="openModal('imgBox8');">Change Image</button>
													</div>
													
													<?php endif; ?>
													
												</div>
												<div class="copy-container mobile-cta">
													<div class="title-block hide-tablet box" style="min-height:100px;">
													
														<?php if (@$homepage_options['one']['one_title1'] AND $homepage_options['one']['one_title1'] != '&nbsp;'): ?>
														
														<h1><?php echo (@$homepage_options['one']['one_title1'] AND $homepage_options['one']['one_title1'] != '&nbsp;') ? $homepage_options['one']['one_title1'] : '<span style="color:#fafafa;">Title 1</span>'; ?> <i><?php echo (@$homepage_options['one']['one_title2'] AND $homepage_options['one']['one_title2'] != '&nbsp;') ? $homepage_options['one']['one_title2'] : '<span style="color:#efefef;">Title 2</span>'; ?></i></h1>
														
														<?php else: ?>
														
														<h1>Boho <i>Forever</i></h1>
														
														<?php endif; ?>
														
														<div class="overbox"></div>
														<div class="overtext title">
															<button type="button" class="small" onclick="openModal('one_title');">Edit</button>
														</div>
													</div>
													<div class="copy-block hide-tablet box" style="min-height:100px;">
													
														<p>
															<span style="color:#8d8d8d;">
															The above title and the button below are the same as that on desktop view. Changes here will reflect on desktop view and vice versa.
															<br /><br />
															Both title and button will show atop and at bottom of image at left in mobile view.
															</span>
														</p>

													</div>
													<div class="cta-block box">
													
														<?php if (@$homepage_options['one']['one_button_text1'] AND @$homepage_options['one']['one_button_text1'] != '&nbsp;'): ?>
														
														<a href="<?php echo (@$homepage_options['one']['one_button_link1'] AND @$homepage_options['one']['one_button_link1'] != '&nbsp;') ? $homepage_options['one']['one_button_link1'] : '#'; ?>">
															<p class="cta">
																<span><?php echo $homepage_options['one']['one_button_text1']; ?></span>
															</p>
														</a>
														
														<?php else: ?>
														
														<a href="<?php echo (@$homepage_options['one']['one_button_link1'] AND @$homepage_options['one']['one_button_link1'] != '&nbsp;') ? $homepage_options['one']['one_button_link1'] : '#'; ?>">
															<p class="cta">
																<span>Shop new</span>
															</p>
														</a>
														
														<?php endif; ?>
														
														<p style="text-align:left;">Button Link:<br /><?php echo (@$homepage_options['one']['one_button_link1'] AND @$homepage_options['one']['one_button_link1'] != '&nbsp;') ? $homepage_options['one']['one_button_link1'] : '#'; ?></p>
														
														<div class="overbox"></div>
														<div class="overtext title">
															<button type="button" class="small"  onclick="openModal('one_button');">Edit</button>
														</div>
													</div>
												</div>
											</div>
											<!-- .inner -->
											
											<div style="clear:both;"></div>
											
											<div class="slider-table" style="margin:20px 0;">
										
												<?php
												/**********
												 * Slider Table
												 */
												?>
												<table width="100%" border="0" cellspacing="1" cellpadding="5">
												
													<col style="width:70px;" />
													<col style="width:225px;" />
													<col />
													<col />
												
													<tr style="background-color:#dddddd;">
														<td height="40" colspan="4">
															<button type="button" style="background-color: #4CAF50;border: none;color: white;padding: 10px 20px;margin-left: 10px;text-align: center;text-decoration: none;font-size: 16px;cursor: pointer;opacity: 1;" onclick="openModal('addSlideBoxm1');">Add a Slide</button>
															To activate slider for container <strong>mobile one</strong>, add at least one image...
														</td>
													</tr>
													
													<tr style="height:40px;">
														<td bgcolor="#DDDDDD" align="center">
															<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Seq</font></b>
														</td>
														<td bgcolor="#DDDDDD" align="center">
															<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Image</font></b>
														</td>
														<td bgcolor="#DDDDDD" align="center">
															<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Information</font></b>
														</td>
														<td align="center" bgcolor="#DDDDDD">
															<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Options</font></b>
														</td>
													</tr>
													
													<?php @mysql_data_seek($qrym1, 0); // set the pointer back to the beginning ?>
													<?php if (mysql_num_rows($qrym1) > 0): while($row = mysql_fetch_array($qrym1)): ?>
													
													<tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
														<td>
															<p><?php echo @$row['seq']; ?></p>
														</td>
														<td align="center">
															<?php $src_image = "../roden_assets/uploads/sliders/".$row['image_name']; ?>
															<img src="<?php echo @$src_image; ?>" width="130" />
														</td>
														<td class="text" align="left" style="padding-left:20px;">
															<p><span style="display:inline-block;width:130px;">Image File Name:</span><?php echo @$row['image_name'];?></p>
															<p><span style="display:inline-block;width:130px;">Title:</span><?php echo @$row['title'];?></p>
															<p>Link:<br /><?php echo @$row['link'];?></p>
														</td>
														<td class="text" style="padding-left:10px;text-align:left;">
															<a href="javascript:LoadPopup('<?php echo '../roden_assets/uploads/sliders/'.@$row['image_name'];?>','<?php echo @$row['image_id'];?>','<?php echo $height + 40;?>','<?php echo $width + 30;?>');" style="display:none;">View</a>
															<a href="javascript:void(0);" onclick="
															document.getElementById('editSlideBoxm1-slider_id').value='<?php echo $row['image_id']; ?>';
															document.getElementById('editSlideBoxm1-original_image').value='<?php echo $row['image_name']; ?>';
															document.getElementById('editSlideBoxm1-slide_seque').value='<?php echo $row['seq']; ?>';
															document.getElementById('editSlideBoxm1-slide_title').value='<?php echo $row['title']; ?>';
															document.getElementById('editSlideBoxm1-slide_link').value='<?php echo $row['link']; ?>';
															openModal('editSlideBoxm1');
															">Edit</a>
															<br />
															<a href="<?php echo SITE_URL.'admin/home_image_boxes_form_submit_slides.php?action=del&id='.$row['image_id'].'&img='.$row['image_name'].'&view=mobile'; ?>" onClick="javascript:return confirm('Are you sure you want to remove the slide?');">Remove</a>
														</td>
														
													</tr>
													
													<?php endwhile; else: ?>
													
													<tr style="background-color:#f3f3f3;">
														<td height="70" colspan="4" align="center">
															<b><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif">No Slides Found.</font></b> <em><a href="javascript:void(0);" onclick="openModal('addSlideBoxm1');">(Add a slide)</a></em>
														</td>
													</tr>
													
													<?php endif; ?>
													
												</table>
												
											</div>
											<!-- .slider-table -->

										</div>
										<!-- .container-one -->
