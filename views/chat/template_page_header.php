                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar hide">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'dashboard'); ?>">Home</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
								
								<?php
								/**********
								 * Create breadcrumbs based on uri
								 */
								$admin_prefix = 'admin';
								$uri_segments = explode('/', $this->uri->uri_string());
								$cnt = count($uri_segments) - 1;
								$segments = $admin_prefix;
								$icnt = 1;
								foreach ($uri_segments as $key => $val)
								{
									// disregard first segment (admin)
									if ($key < $icnt) continue;
									
									// if last segment of uri
									if ($icnt == $cnt)
									{
										echo '<li><span>'.ucwords(str_replace('_', ' ', $val)).'</span></li>';
										continue;
									}
									
									// set the segmented href
									$segments .= '/'.$val;
									
									// 4th segment onwards are parameter passed on to function
									if ($icnt >= 3)
									{
										for ($icnti = $icnt; $icnti < $cnt; $icnti++)
										{
											$segments .= '/'.$uri_segments[$icnti + 1];
										}
										
										// if 3rd segement is 'edit', then 5th segment is always the id param
											echo '
												<li>
													<a href="'.site_url($segments).'" data-test="true">'.ucwords(str_replace('_', ' ', $val)).'</a>
													<i class="fa fa-angle-right"></i>
												</li>
											';
									}
									else
									{
										// otherwise, lets create the linked breadcrumb
										// NOTE: need to type with the line breaks for the correct spacing to occur
										
										// if 3rd segement is 'edit', then 5th segment is always the id param
										if ($val == 'edit')
										{
											echo '
												<li>
													<a href="'.site_url($segments.'/index/'.$uri_segments[$icnt + 2]).'">'.ucwords(str_replace('_', ' ', $val)).'</a>
													<i class="fa fa-angle-right"></i>
												</li>
											';
										}
										else
										{
											echo '
												<li>
													<a href="'.site_url($segments).'">'.ucwords(str_replace('_', ' ', $val)).'</a>
													<i class="fa fa-angle-right"></i>
												</li>
											';
										}
									}
									
									$icnt++;
								}
								?>
							
                            </ul>
							<!-- DOC: Remove "hide" class to enable the page toolbar actions button -->
                            <div class="page-toolbar hide">
                                <div class="btn-group pull-right">
									<button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="#">
                                                <i class="icon-bell"></i> Action</a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-shield"></i> Another action</a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-user"></i> Something else here</a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-bag"></i> Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- END PAGE BAR -->
						
                        <!-- BEGIN PAGE TITLE-->
						<h1 class="page-title"> <?php echo @$page_title ?: 'Page Title'; ?>
							<small><?php echo @$page_description ?: 'Page description'; ?></small>
						</h1>
                        <!-- END PAGE TITLE-->
						