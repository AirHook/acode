                    <!-- BEGIN FOOTER -->
                    <!-- BEGIN PRE-FOOTER -->
                    <div class="page-prefooter">
						<!-- DOC: change between class "container-fluid" and "container" for fluid or boxed layout -->
                        <div class="container">
							<div class="row">
								<div class="col-xs-12 footer-block">
									<hr />
                                    <ul class="list-unstyled list-inline text-center">
                                        <?php
                                        if (
                                            $this->webspace_details->slug == 'tempoparis'
                                            OR $this->session->user_role == 'wholesale'
                                        )
                                        {
                                            $disabled_footer = 'disabled-link disable-target';
                                        }
                                        else $disabled_footer = '';
                                        ?>
                                        <li>
                                            <a href="<?php echo $disabled_footer ? 'javascript:;' : site_url('ordering'); ?>" data-original-title="" class=" <?php echo $disabled_footer; ?>">
												Ordering
											</a>
                                        </li>
										<li><span class="separator"></span></li>
                                        <li>
                                            <a href="<?php echo $disabled_footer ? 'javascript:;' : site_url('shipping'); ?>" data-original-title="" class=" <?php echo $disabled_footer; ?>">
												Shipping
											</a>
                                        </li>
										<li><span class="separator"></span></li>
                                        <li>
                                            <a href="<?php echo $disabled_footer ? 'javascript:;' : site_url('return_policy'); ?>" data-original-title="" class=" <?php echo $disabled_footer; ?>">
												Returns
											</a>
                                        </li>
										<li><span class="separator"></span></li>
                                        <li>
                                            <a href="<?php echo $disabled_footer ? 'javascript:;' : site_url('privacy_notice'); ?>" data-original-title="" class=" <?php echo $disabled_footer; ?>">
												Privacy
											</a>
                                        </li>
										<li><span class="separator"></span></li>
                                        <li>
                                            <a href="<?php echo $disabled_footer ? 'javascript:;' : site_url('faq'); ?>" data-original-title="" class=" <?php echo $disabled_footer; ?>">
												FAQ
											</a>
                                        </li>
										<li><span class="separator"></span></li>
                                        <li>
                                            <a href="<?php echo $disabled_footer ? 'javascript:;' : site_url('sitemap'); ?>" data-original-title="" class=" <?php echo $disabled_footer; ?>">
												Sitemap
											</a>
                                        </li>
										<li><span class="separator"></span></li>
                                        <li>
                                            <a href="<?php echo $disabled_footer ? 'javascript:;' : site_url('press'); ?>" data-original-title="" class=" <?php echo $disabled_footer; ?>">
												Press
											</a>
                                        </li>
										<li><span class="separator"></span></li>
                                        <li>
                                            <a href="<?php echo site_url('contact'); ?>" data-original-title="" class="">
												Contact
											</a>
                                        </li>
										<li><span class="separator"></span></li>
                                        <li>
                                            <a href="<?php echo $disabled_footer ? 'javascript:;' : site_url('terms_of_use'); ?>" data-original-title="" class=" <?php echo $disabled_footer; ?>">
												Terms Of Use
											</a>
                                        </li>
                                    </ul>

                                    <ul class="social-icons list-inline text-center">
                                        <li>
                                            <a href="javascript:;" data-original-title="facebook" class="facebook <?php echo $disabled_footer; ?>"></a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-original-title="youtube" class="youtube <?php echo $disabled_footer; ?>"></a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-original-title="pinterest" class="pintrest <?php echo $disabled_footer; ?>"></a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-original-title="instagram" class="instagram <?php echo $disabled_footer; ?>"></a>
                                        </li>
                                    </ul>

									<!-- DOC: Apply/remove class "hide" to show/hide element -->
                                    <div class="subscribe-form hidden-xs hide">
                                        <form action="javascript:;">
                                            <div class="input-group col-xs-3" style="margin:0 auto;">
                                                <input type="text" placeholder="mail@email.com" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn" type="submit">Submit</button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>

								</div>
							</div>
                        </div>
                    </div>
                    <!-- END PRE-FOOTER -->

                    <!-- BEGIN INNER FOOTER -->
                    <div class="page-footer text-center">
						<!-- DOC: change between class "container-fluid" and "container" for fluid or boxed layout -->
                        <div class="container">
							<?php echo @date('Y', @time()); ?> <span onclick="$('.session-array').toggle();">©</span> <?php echo @$this->webspace_details->name ?: 'Rcpixel'; ?>
							<!--
                            <a target="_blank" href="http://keenthemes.com">Keenthemes</a> &nbsp;|&nbsp;
                            <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a>
							-->
                        </div>
                    </div>
                    <div class="scroll-to-top">
                        <i class="icon-arrow-up"></i>
                    </div>
                    <!-- END INNER FOOTER -->
                    <!-- END FOOTER -->
