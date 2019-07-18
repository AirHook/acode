                        <!-- BEGIN HEADER TOP -->
                        <div class="page-header-top">
							<!-- DOC: change between class "container-fluid" and "container" for fluid or boxed layout -->
                            <div class="container-fluid">

								<!-- BEGIN MOBILE HEADER SEARCH BOX -->
								<div class="mobile-search" style="display:none;height:85px;">
									<!-- BEGIN RESPONSIVE MENU TOGGLER -->
									<a href="javascript:;" class="menu-toggler " style="float:left;margin-left:-10px;margin-right:5px;position:relative;top:3px;"></a>
									<!-- END RESPONSIVE MENU TOGGLER -->

									<!-- bof ============================================================-->
									<form class="search-form" action="<?php echo site_url('sales/search_products'); ?>" method="POST" style="padding:8px 6px 0px 0px;">
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
									<a href="javascript:;" class="menu-toggler-2 hidden-sm hidden-md hidden-lg" style="float:left;margin-left:-10px;position:relative;top:3px;color:black;">
									<i class="fa fa-bars"></i></a>
									<!-- END RESPONSIVE MENU TOGGLER -->

									<!-- BEGIN LOGO -->
									<div class="page-logo" style="<?php echo $this->uri->segment(2) == 'purchase_orders' ? 'width:280px;' : ''; ?>">
                                        <?php
                                        $this->uri->segment(2)
                                        ?>
										<a href="<?php echo $this->uri->segment(2) == 'purchase_orders' ? site_url('sales/purchase_orders') : site_url('sales'); ?>" class="logo">
                                            <h2> <?php echo $this->uri->segment(2) == 'purchase_orders' ? 'PURCHASE ORDERS' : 'SALES USER'; ?> </h2>
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

                                            <!-- BEGIN MULTI SEARCH LINK -->
                                            <?php if ($this->uri->segment(2) !== 'purchase_orders')
                                            { ?>
                                            <li class="dropdown dropdown-user dropdown-dark hidden-xs" style="margin-left:5px;margin-right:100px;">
												<a href="<?php echo site_url('sales/search_multiple'); ?>" class="dropdown-toggle">
													<span class="username"> <span style="color:red;">CLICK</span> TO SEARCH MULTIPLE STYLE NUMBERS </span>
												</a>
											</li>
                                                <?php
                                            }?>
                                            <!-- END MULTI SEARCH LINK -->

                                            <!-- BEGIN SINGLE SEARCH BOX -->
											<!-- DOC: One for tablet and desktop view, one for mobile view -->
											<li class="dropdown dropdown-user dropdown-dark dropdown-none hidden-xs" style="margin-left:5px;margin-right:5px;">
												<a href="javascript:;" class="dropdown-toggle" >
													<span class="username"> SEARCH SINGLE STYLE NUMBER </span>
												</a>
											</li>
                                            <!-- END SINGLE SEARCH BOX -->

											<!-- BEGIN HEADER SEARCH BOX -->
											<li class="hidden-xs">
                                                <!-- BEGIN FORM-->
                								<!-- FORM =======================================================================-->
                								<?php echo form_open(
                									'sales/'.($this->uri->segment(2) === 'purchase_orders' ? 'purchase_orders/' : '').'search_products',
                									array(
                										'method'=>'POST',
                										'id'=>'form-admin_tobbar_search',
                										'class'=>'admin_tobbar_search',
                										'style'=>'padding:8px 10px;'
                									)
                								); ?>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control search_by_style" id="search_by_style" name="style_no" placeholder="Search..." style="text-transform:uppercase;"/>
                                                        <span class="input-group-btn">
                                                            <a href="javascript:;" class="btn grey-mint submit">
                                                                <i class="icon-magnifier"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </form>
                								<!-- End FORM ===================================================================-->
                								<!-- END FORM-->
											</li>
											<!-- END HEADER SEARCH BOX -->

                                            <!-- BEGIN USER SIGNIN -->
                                            <li class="dropdown dropdown-user dropdown-dark hidden-xs" style="margin-left:5px;margin-right:12px;">
												<?php
												if ($this->session->admin_sales_loggedin)
												{ ?>
												<a href="<?php echo site_url('sales'); ?>" class="dropdown-toggle" >
													<span class="username"> Logged in as <?php echo $this->sales_user_details->fname; ?> </span>
												</a>
													<?php
												}
												else
												{ ?>
												<a href="<?php echo site_url('account'); ?>" class="dropdown-toggle" >
													<span class="username"> Sign In / Retailer Login </span>
												</a>
													<?php
												} ?>
											</li>
											<!-- END USER SIGNIN -->

											<!-- BEGIN MOBILE HEADER SEARCH BOX TOGGLER -->
											<li class="search-toggler hiden-sm hidden-md hidden-lg" style="position:relative;top:11px;left:5px;font-size:1.5em;">
												<i class="fa fa-search" style="cursor:pointer;"></i>
											</li>
											<!-- END MOBILE HEADER SEARCH BOX TOGGLER -->

											<!-- BEGIN FAVORITES TOGGLER -->
											<li class="dropdown dropdown-extended dropdown-favorite dropdown-dark hide">
												<a href="javascript:;" class="dropdown-toggle" >
													<i class="fa fa-heart-o"></i>
												</a>
											</li>
											<!-- END FAVORITES TOGGLER -->

											<!-- BEGIN SHOP CART TOGGLER -->
											<li class="dropdown dropdown-extended dropdown-inbox dropdown-dark <?php echo $this->webspace_details->options['site_type'] === 'sat_site'
											? 'hide' : ''; ?> hide">
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
                                                            if (@$this->cart->contents())
                                                            {
                                                                $i = 1;
                                                                foreach (@$this->cart->contents() as $items)
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
                            </div>
                        </div>
                        <!-- END HEADER TOP -->
