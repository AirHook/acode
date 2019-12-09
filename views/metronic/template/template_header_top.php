                        <!-- BEGIN HEADER TOP -->
                        <div class="page-header-top">
							<!-- DOC: change between class "container-fluid" and "container" for fluid or boxed layout -->
                            <div class="container">

								<!-- BEGIN MOBILE HEADER SEARCH BOX -->
								<div class="mobile-search" style="display:none;height:85px;">
									<!-- BEGIN RESPONSIVE MENU TOGGLER -->
									<a href="javascript:;" class="menu-toggler " style="float:left;margin-left:-10px;margin-right:5px;position:relative;top:3px;"></a>
									<!-- END RESPONSIVE MENU TOGGLER -->

									<!-- bof ============================================================-->
									<form class="search-form" action="<?php echo site_url('search'); ?>" method="POST" style="padding:8px 6px 0px 0px;">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
										<input type="hidden" name="search" value="TRUE" />
										<a href="javascript:;" class="search-toggler" style="color:#2f353b;"><i class="fa fa-close" style="float:right;position:relative;top:10px;"></i></a>
										<div class="input-group" style="width:80%;">
											<input type="text" id="search_by_style" class="form-control" placeholder="Search" name="style_no" style="text-transform:uppercase;">
											<span class="input-group-btn hidden-sm hidden-md hidden-lg">
												<a href="javascript:;" class="btn dark submit" style="background:#2f353b;">
													<i class="icon-magnifier"></i>
												</a>
											</span>
										</div>
									</form>

									<!-- BEGIN CLOSE MOBILE SEARCH BOX TOGGLER -->
									<!-- END CLOSE MOBILE SEARCH BOX TOGGLER -->
								</div>
								<!-- END MOBILE HEADER SEARCH BOX -->

								<div class="top-default">

									<!-- BEGIN RESPONSIVE MENU TOGGLER -->
									<!-- DOC: Shown only on mobile devices -->
									<a href="javascript:;" class="menu-toggler-2 hidden-sm hidden-md hidden-lg" style="float:left;margin-left:-6px;position:relative;color:black;">
									<i class="fa fa-bars"></i></a>
									<!-- END RESPONSIVE MENU TOGGLER -->

									<!-- BEGIN LOGO -->
									<div class="page-logo">
										<a href="<?php echo site_url(); ?>">
											<?php

                                                // get respective logo for desinger pages
    											if (
    												$this->uri->segment(2)
    												OR $this->uri->segment(3)

    											)
    											{
    												$designer = $this->designer_details->initialize(array('url_structure'=>$this->uri->segment(2)));
                                                    if ( ! $designer)
                                                    {
                                                        $designer = $this->designer_details->initialize(array('url_structure'=>$this->uri->segment(3)));
                                                    }

    												if ($designer)
    												{
    													$des_logo = $this->designer_details->logo;
    												}
    												else $des_logo = '';
    											}
    											else
                                                {
                                                    if (@$this->webspace_details->options['site_type'] == 'sat_site')
                                                    {
                                                        $designer = $this->designer_details->initialize(
                                                            array(
                                                                'url_structure' => $this->webspace_details->slug
                                                            )
                                                        );

                                                        $des_logo = $this->designer_details->logo;
                                                    }
                                                    else $des_logo = '';
                                                }

                                                // set $logo per designer or as per webspace details
    											$logo = $des_logo
    												? $this->config->item('PROD_IMG_URL').$this->designer_details->logo
    												: @$this->webspace_details->options['logo']
    											;

    											if ($logo)
    											{ ?>

    											<img src="<?php echo $logo; ?>" alt="logo" class="logo-default" />
    												<?php
    											}
    											else
    											{ ?>

    											<img src="<?php echo base_url(); ?>assets/images/logo/logo-<?php echo $this->webspace_details->slug; ?>.png" alt="logo" class="logo-default" data-info="<?php echo $des_logo; ?>" data-information="hello" />
    												<?php
                                                }

                                            ?>
										</a>
									</div>
									<!-- END LOGO -->

									<!-- BEGIN RESPONSIVE MENU TOGGLER -->
									<!-- DOC: Shown only on tablet devices -->
									<a href="javascript:;" class="menu-toggler hidden-xs"></a>
									<!-- END RESPONSIVE MENU TOGGLER -->

									<!-- BEGIN TOP NAVIGATION MENU -->
									<div class="top-menu">
										<ul class="nav navbar-nav pull-right">

											<!-- BEGIN USER SIGNIN -->
											<!-- DOC: One for tablet and desktop view, one for mobile view -->
                                            <?php
                                            if ($this->session->user_loggedin)
                                            { ?>
                                            <li class="dropdown dropdown-user dropdown-dark hidden-xs" style="margin-left:5px;margin-right:0px;">
												<a href="<?php echo site_url('my_account/'.$this->session->user_cat.'/dashboard'); ?>" class="dropdown-toggle" >
													<span class="username"> Welcome<?php echo $this->session->user_name ? ' '.$this->session->user_name.',' : ','; ?> My Account </span>
												</a>
											</li>
                                                <?php
                                            } ?>
											<li class="dropdown dropdown-user dropdown-dark hidden-xs" style="margin-left:5px;margin-right:12px;">
												<?php
												if ($this->session->user_loggedin)
												{ ?>
                                                <a href="<?php echo site_url('account/logout'); ?>" class="dropdown-toggle" >
													<span class="username"> Log Out </span>
												</a>
													<?php
												}
												else
												{ ?>
												<a href="<?php echo site_url('account'); ?>" class="dropdown-toggle" >
													<span class="username"> LogIn / Register </span>
												</a>
													<?php
												} ?>
											</li>
											<li class="dropdown dropdown-user dropdown-dark dropdown-user-mobile hidden-sm hidden-md hidden-lg" style="">
                                                <?php
												if ($this->session->user_loggedin)
												{ ?>
                                                <a href="<?php echo site_url('my_account/'.$this->session->user_cat.'/dashboard'); ?>" class="dropdown-toggle" >
                                                    <span class="username" style="font-size:0.85em;line-height:1em;text-align:center;position:relative;bottom:2px;"> My Acct </span>
                                                </a>
                                                    <?php
                                                }
                                                else
                                                { ?>
                                                <a href="<?php echo site_url('account'); ?>" class="dropdown-toggle" >
													<span class="username" style="font-size:0.85em;line-height:1em;text-align:center;position:relative;top:6px;"> Login / Register </span>
												</a>
                                                    <?php
                                                } ?>
											</li>
                                            <?php
                                            if ($this->session->user_loggedin)
                                            { ?>
                                            <li class="dropdown dropdown-user dropdown-dark dropdown-user-mobile hidden-sm hidden-md hidden-lg" style="">
                                                <a href="<?php echo site_url('account/logout'); ?>" class="dropdown-toggle" >
                                                    <span class="username" style="font-size:0.85em;line-height:1em;text-align:center;position:relative;bottom:2px;"> Log<br>out </span>
                                                </a>
											</li>
                                                <?php
                                            } ?>
											<!-- END USER SIGNIN -->

											<!-- BEGIN HEADER SEARCH BOX -->
											<li class="hidden-xs">
												<!-- bof ============================================================-->
												<form class="search-form" action="<?php echo site_url('search'); ?>" method="POST" style="padding:8px 6px 0px 0px;">
													<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
													<input type="hidden" name="search" value="TRUE" />
													<div class="input-group">
														<input type="text" id="search_by_style" class="form-control" placeholder="Search" name="style_no" style="text-transform:uppercase;">
														<span class="input-group-btn hidden-sm hidden-md hidden-lg">
															<a href="javascript:;" class="btn submit">
																<i class="icon-magnifier"></i>
															</a>
														</span>
													</div>
												</form>
											</li>
											<!-- END HEADER SEARCH BOX -->

                                            <?php
    										/***********
    										 *	Search Box Toggler
                                             *  Toggles above <!-- BEGIN MOBILE HEADER SEARCH BOX -->
                                             *  Hidding this and permanently showing search box below for mobile devices
    										 */
    										?>
											<!-- BEGIN MOBILE HEADER SEARCH BOX TOGGLER -->
											<li class="search-toggler hiden-sm hidden-md hidden-lg hide" style="position:relative;top:11px;left:5px;font-size:1.5em;">
												<i class="fa fa-search" style="cursor:pointer;"></i>
											</li>
											<!-- END MOBILE HEADER SEARCH BOX TOGGLER -->

                                            <?php
    										/***********
    										 *	FAVORITES icon
                                             *  Hidding this temporarily
    										 */
    										?>
											<!-- BEGIN FAVORITES TOGGLER -->
                                            <?php if ($this->webspace_details->options['site_type'] == 'hub_site')
                                            { ?>
											<li class="dropdown dropdown-extended dropdown-favorite dropdown-dark hide">
												<a href="javascript:;" class="dropdown-toggle" >
													<i class="fa fa-heart-o"></i>
												</a>
											</li>
                                                <?php
                                            } ?>
											<!-- END FAVORITES TOGGLER -->

											<!-- BEGIN SHOP CART TOGGLER -->
											<li class="dropdown dropdown-extended dropdown-inbox dropdown-dark shop-cart-toggler hidden-xs <?php echo $this->webspace_details->options['site_type'] === 'sat_site'
											? 'hide' : ''; ?>">
												<a href="javascript:;" class="dropdown-toggle shopping-bag-link" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
													<img src="<?php echo base_url(); ?>assets/images/icons/shopping-bag.png" style="width:25px;height:28px;position:relative;top:-7px;" />
													<i class="icon-bag hide"></i>
													<span class="badge badge-default badge-roundless badge-cart-top-nav" style="width:25px;text-align:center;">
														<?php echo $this->cart->total_items() ?: '0'; ?>
													</span>
												</a>
												<ul class="dropdown-menu " style="border:1px solid #ccc;">
													<li class="external" style="background:white;">
                                                        <?php
                                                        if ($this->cart->contents())
                                                        { ?>
														<h3 style="color:black;">You have
															<strong><?php echo $this->cart->total_items(); ?> Items</strong> in you cart</h3>
														<a href="<?php echo site_url('cart'); ?>" style="color:black;">view all</a>
                                                            <?php
                                                        }
                                                        else
                                                        { ?>
                                                            <h3 style="color:black;">You have
    															<strong>0 Items</strong> in you cart</h3>
                                                            <?php
                                                        } ?>
													</li>
													<li class="<?php echo $this->cart->total_items() ?: 'hide_'; ?>" style="background:white;">
                                                        <!--
														<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                                        -->
                                                        <ul class="dropdown-menu-list ">

                                                            <?php
                                                            if ($this->cart->contents())
                                                            {
                                                                $i = 1;
                                                                foreach ($this->cart->contents() as $items)
                                                                {
                                                                    // incorporate new image url system
                                                                    if (
                                                                        isset($items['options']['prod_image_url'])
                                                                        && ! empty($items['options']['prod_image_url'])
                                                                    )
                                                                    {
                                                                        $href_text = str_replace('_f2', '_f3', $items['options']['prod_image_url']);
                                                                    }
                                                                    else
                                                                    {
                                                                        $href_text = str_replace('_2', '_3', $items['options']['prod_image']);
                                                                    } ?>

															<li>
																<a href="javascript:;" class="header-cart-button-cart-details" style="border-bottom:none !important;">
																	<span class="photo">
																		<img src="<?php echo $this->config->item('PROD_IMG_URL').$href_text; ?>" class="" alt="" width="40px" style="width:40px;height:60px;border-radius:0 !important;">
																	</span>
																	<span class="subject">
																		<span class="from" style="color:black;"> Product#: <?php echo $items['options']['prod_no']; ?> </span>
																		<span class="time hide"> Just Now </span>
																	</span>
																	<span class="message" style="color:black;"> Color: &nbsp; <?php echo $items['options']['color']; ?>
                                                                        <br />Size: &nbsp; <?php echo $items['options']['size']; ?>
                                                                        <br /><?php echo $items['qty']; ?> pcs </span>
																</a>
															</li>

                                                                    <?php
                                                                    $i++;
                                                                    if (@$items['options']['custom_order'] == TRUE) $custom_order = TRUE;
                                                                    else if (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
                                                                    else $custom_order = FALSE;
                                                                }
                                                            } ?>

														</ul>
													</li>
												</ul>
											</li>

                                            <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark shop-cart-toggler hidden-sm hidden-md hidden-lg mobile <?php echo $this->webspace_details->options['site_type'] === 'sat_site'
											? 'hide' : ''; ?>">
												<a href="javascript:;" class="dropdown-toggle shopping-bag-link" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
													<img src="<?php echo base_url(); ?>assets/images/icons/shopping-bag.png" style="width:25px;height:28px;position:relative;top:-7px;" />
													<i class="icon-bag hide"></i>
													<span class="badge badge-default badge-roundless badge-cart-top-nav" style="width:25px;text-align:center;">
														<?php echo $this->cart->total_items() ?: '0'; ?>
													</span>
												</a>
												<ul class="dropdown-menu " style="border:1px solid #ccc;">
													<li class="external" style="background:white;">
                                                        <?php
                                                        if ($this->cart->contents())
                                                        { ?>
														<h3 style="color:black;">You have
															<strong><?php echo $this->cart->total_items(); ?> Items</strong> in you cart</h3>
														<a href="<?php echo site_url('cart'); ?>" style="color:black;">view all</a>
                                                            <?php
                                                        }
                                                        else
                                                        { ?>
                                                            <h3 style="color:black;">You have
    															<strong>0 Items</strong> in you cart</h3>
                                                            <?php
                                                        } ?>
													</li>
													<li class="<?php echo $this->cart->total_items() ?: 'hide_'; ?>" style="background:white;">
                                                        <!--
														<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                                        -->
                                                        <ul class="dropdown-menu-list ">

                                                            <?php
                                                            if ($this->cart->contents())
                                                            {
                                                                $i = 1;
                                                                foreach ($this->cart->contents() as $items)
                                                                {
                                                                    // incorporate new image url system
                                                                    if (
                                                                        isset($items['options']['prod_image_url'])
                                                                        && ! empty($items['options']['prod_image_url'])
                                                                    )
                                                                    {
                                                                        $href_text = str_replace('_f2', '_f3', $items['options']['prod_image_url']);
                                                                    }
                                                                    else
                                                                    {
                                                                        $href_text = str_replace('_2', '_3', $items['options']['prod_image']);
                                                                    } ?>

															<li>
																<a href="javascript:;" class="header-cart-button-cart-details" style="border-bottom:none !important;">
																	<span class="photo">
																		<img src="<?php echo $this->config->item('PROD_IMG_URL').$href_text; ?>" class="" alt="" width="40px" style="width:40px;height:60px;border-radius:0 !important;">
																	</span>
																	<span class="subject">
																		<span class="from" style="color:black;"> Product#: <?php echo $items['options']['prod_no']; ?> </span>
																		<span class="time hide"> Just Now </span>
																	</span>
																	<span class="message" style="color:black;"> Color: &nbsp; <?php echo $items['options']['color']; ?>
                                                                        <br />Size: &nbsp; <?php echo $items['options']['size']; ?>
                                                                        <br /><?php echo $items['qty']; ?> pcs </span>
																</a>
															</li>

                                                                    <?php
                                                                    $i++;
                                                                    if (@$items['options']['custom_order'] == TRUE) $custom_order = TRUE;
                                                                    else if (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
                                                                    else $custom_order = FALSE;
                                                                }
                                                            } ?>

														</ul>
													</li>
												</ul>
											</li>
											<!-- END SHOP CART TOGGLER -->

											<!-- BEGIN QUICK SIDEBAR TOGGLER -->
											<!-- DOC: remove class "hide" to enable section -->
											<li class="dropdown dropdown-extended quick-sidebar-toggler hide">
												<span class="sr-only">Toggle Quick Sidebar</span>
												<i class="icon-logout"></i>
											</li>
											<!-- END QUICK SIDEBAR TOGGLER -->

										</ul>
									</div>
									<!-- END TOP NAVIGATION MENU -->

								</div>

                                <div class="hidden-sm hidden-md hidden-lg">
                                    <!-- bof ============================================================-->
                                    <form class="search-form" action="<?php echo site_url('search'); ?>" method="POST" style="padding:8px 0px 0px 0px;">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <input type="hidden" name="search" value="TRUE" />
                                        <a href="javascript:;" class="search-toggler hide" style="color:#2f353b;"><i class="fa fa-close" style="float:right;position:relative;top:10px;"></i></a>
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" id="search_by_style" class="form-control" placeholder="Search By Style Number" name="style_no" style="text-transform:uppercase;">
                                            <span class="input-group-btn hidden-sm hidden-md hidden-lg">
                                                <a href="javascript:;" class="btn dark submit" style="background:#2f353b;">
                                                    <i class="icon-magnifier"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </form>
                                    <!-- eof ============================================================-->
                                </div>

                            </div>
                        </div>
                        <!-- END HEADER TOP -->
