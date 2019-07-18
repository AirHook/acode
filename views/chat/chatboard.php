                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="note note-success">
                        <h3>Chat Boards</h3>
                        <p> 
							Here you can see if there are wholesale users that are currenlty online and if there are chat prompts from both wholesale users and/or guests. 
						</p>
                        <p> 
							Refresh page to refresh list of online users. This refreshes their online status as well. Blue avatar means online and is mostlikely still active. Gray avatar means user has not logged out but has no activity for a while now.
                        </p>
                    </div>
					
                        <div class="row">
                            <div class="col-lg-4 col-xs-12 col-sm-12" data-time="<?php echo date('Y-m-d', time()); ?>">
                                <!-- BEGIN PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title ">
                                        <div class="caption">
                                            <i class="icon-calendar font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Recently Online Users</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="scroller" style="height: 500px;" data-always-visible="1" data-rail-visible="0">
											<h4 class="block">Wholesale Users</h4>
                                            <ul class="feeds online_user_list">
											
												<?php if ($recent_online_users) { ?>
												<?php foreach ($recent_online_users as $user) { ?>
													<?php $logindata = json_decode($user->logindata, TRUE); ?>
													<?php if (@$logindata['active_time'] != 'logout') { ?>
													
                                                <li>
													<a href="javascript:;" class="online_user" id="<?php echo $user->user_id; ?>" data-store_name="<?php echo $user->store_name; ?>" data-chat_id="<?php echo isset($logindata['chat_id']) ? $logindata['chat_id'] : '0'; ?>" data-admin_sales_id="<?php echo $user->admin_sales_id; ?>">
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-<?php echo floor((time() - @$user->lastonline)/60) > 10 ? 'default' : 'info'; ?>">
                                                                    <i class="fa fa-user"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc" style="<?php echo (floor((time() - @$user->lastonline)/60) > 10) ? 'color:#bac3d0;' : ''; ?>"> 
																	<?php echo $user->store_name; ?>
																	<?php if (floor((time() - @$user->lastonline)/60) > 10) { ?>
																	<span class="label label-sm label-default"> Idle </span>&nbsp;
																	<?php } ?>
																	<span class="badge badge-sm badge-danger hide"> 1 </span><br />
																	<cite class="small"><?php echo $user->email; ?><br />
																	<?php echo $user->firstname.' '.$user->lastname; ?></cite>
																</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> <?php echo (floor((time() - @$user->lastonline)/60) > 10) ? '&gt;10' : floor((time() - @$user->lastonline)/60); ?> mins ago </div>
                                                    </div>
													</a>
                                                </li>
												
													<?php } ?>
												<?php } ?>
												<?php } else { ?>

                                                <li>
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-default">
                                                                    <i class="fa fa-user"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc"> <cite>No online users...</cite> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date">  </div>
                                                    </div>
                                                </li>
												
												<?php } ?>
												
											</ul>
											<!--
											<h4 class="block">Guests Prompts</h4>
											<ul class="feeds">
                                                <li>
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-default">
                                                                    <i class="fa fa-user"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> 24 mins </div>
                                                    </div>
                                                </li>
											</ul>
											-->
										</div>
                                    </div>
                                </div>
                                <!-- END PORTLET-->
                            </div>
                            <div class="col-lg-8 col-xs-12 col-sm-12">
                                <!-- BEGIN PORTLET-->
                                <div class="portlet light bordered chat_board">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-bubble font-hide hide"></i>
                                            <span class="caption-subject font-hide bold uppercase">Click on an online user to start chat...</span>
                                        </div>
                                        <div class="actions">
											<button class="btn btn-sm btn-circle red-mint" id="admin_close_chat" style="display:none;">
                                                <i class="fa fa-close"></i> Close Chat </button>
										</div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="scroller chat-content" id="chat-content" style="height:400px;" data-always-visible="1" data-rail-visible1="1" data-start="bottom">
                                            <ul class="chats chat-wrap" id="chat-wrap">

												<!-- Chat transcripts goes here -->
												
                                            </ul>
                                        </div>
                                        <div class="chat-form">
                                            <div class="input-cont">
												<input type="hidden" id="chat_id" name="chat_id" value="0" autocomplete="off" />
												<input type="hidden" id="admin_sales_id" name="admin_sales_id" value="1" />
												<input type="hidden" id="close_chat" name="close_chat" value="0" />
												<!-- DOC: Use text area instead and set height to be the same as the input element -->
                                                <!--<input class="form-control" id="sendie" type="text" placeholder="Type a message here..." /> -->
												<textarea class="form-control" id="sendie" placeholder="Type a message here..." maxlength="500" style="height:35px;"></textarea>
											</div>
											<!-- DOC: Adjust left position of element to accomodate the above text area -->
                                            <div class="btn-cont" style="left:3px;">
                                                <span class="arrow"> </span>
                                                <a href="javascript:;" class="btn blue icn-only">
                                                    <i class="fa fa-check icon-white"></i>
                                                </a>
                                            </div>
                                        </div>
										
										<audio id="message_alert">
											<source src="<?php echo base_url(); ?>chat_archive/google_notification.mp3" type="audio/mpeg" />
											<embed hidden="true" src="<?php echo base_url(); ?>chat_archive/google_notification.mp3" />
										</audio>
										
                                    </div>
                                </div>
                                <!-- END PORTLET-->
                            </div>
                        </div>
						
                    <!-- END PAGE CONTENT BODY -->
					
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
			
			<?php
			/*********
			 * The chatboard script somehow stopped working because of some script 
			 * preventing it from working properly. Placing the script at the 
			 * bottom of the page (template_bottom) makes it work properly again
			 */
			?>
			<?php //$this->load->view('chat/chatboard_script', $this->data); ?>
