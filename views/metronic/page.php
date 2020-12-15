                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<?php if ($page == '')
										{ ?>

										<h3>
                                            <?php
                                            if (@$page_details)
                                            {
                                                echo strtoupper($page_details->page_name);
                                            }
                                            else
                                            {
                                                echo strtoupper($page_title);
                                            }
                                            ?>
                                        </h3>
                                        <br />
										<div class="page-text-body">
											<?php
                                            if (@$page_details)
                                            {
                                                echo $page_details->content;
                                            }
                                            else
                                            {
                                                if (@$page_text)
                                                {
                                                    echo str_replace('Instylenewyork.com', ucwords($this->webspace_details->site), @$page_text);
                                                }
                                                else
                                                {
                                                    echo 'Page content inserted here. To begin, edit content at admin.';
                                                }
                                            }
                                            ?>
										</div>

                                            <?php
										}
										elseif ($page == 'events')
										{ ?>

											<h3><?php echo strtoupper($page_title); ?></h3>
											<p>
												<?php echo $this->webspace_details->name; ?> is present in many global trade shows and fashion venues. See schedule below.
											</p>
											<hr />

											<?php if ($view_events): ?>

												<table cellpadding="0" cellspacing="0" border="0">

													<?php foreach ($view_events as $event): ?>

													<tr>
														<td style="padding:30px 0;">
															<?php echo nl2br(strip_tags($event->n_text)); ?><br />
														</td>
													</tr>

													<?php endforeach; ?>

												</table>

											<?php else: ?>

												<p style="text-transform:uppercase;font-size:1.15em;margin:50px 0;">
													There are currently no scheduled events for <?php echo $this->webspace_details->name; ?>.
												</p>

											<?php endif; ?>

                                            <?php
										}
										elseif ($page == 'press')
										{ ?>

											<h3><?php echo strtoupper($page_title); ?></h3>
											<p>
												<div align="left" style="font-size:14px;">CLICK ANY COVER TO VIEW ARTICLE</div>
												<br />
												<div align="left">
													For press inquiries, please email <a href="mailto:<?php echo $this->webspace_details->info_email; ?>"><?php echo $this->webspace_details->info_email; ?></a>.
												</div>
											</p>

											<div class="row">

											<?php
											if ($presses):

												foreach ($presses as $rows): ?>

													<div class="col col-xs-6 col-sm-3">
														<!--
														<a class="press_group_1" href="<?php echo base_url(); ?>images/press/press_1/<?php echo $rows->img_1; ?>" title="<?php echo $rows->title; ?>">
														-->
														<a class="press_group_1" href="javascript:;" title="<?php echo $rows->title; ?>">
															<img alt="<?php echo $rows->title; ?>" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/press/press_cover/thumb/<?php echo $rows->cover_img; ?>" style="border:1px solid #666666;" />
														</a>
														<p><?php echo $rows->title; ?></p>
													</div>

												<?php endforeach; ?>

											<?php endif; ?>

											</div>

										<?php
										}
										elseif ($page == 'how_to_oder')
										{
											$this->load->view($this->webspace_details->options['theme'].'/'.$page);
											//$this->load->view($this->config->slash_item('template').$page);
										}
										else
										{
											//$this->load->view($this->webspace_details->options['theme'].'/'.$page);
											//$this->load->view($this->config->slash_item('template').$page);
											$this->load->view('metronic/'.$page);
										} ?>

                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
