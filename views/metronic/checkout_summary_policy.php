													<div class="margin-top-30">
                                                        <div class="form-group">
    														<label class="mt-checkbox mt-checkbox-outline"> By continuing, I agree to the
																<!--<a href="#modal-return_policy" data-toggle="modal">-->
																<a href="javascript:;" data-toggle="modal" class="disabled-link disable-target">
																	Return Policy
																</a> and confirm that my information is correct.
    															<input type="checkbox" value="1" name="agree_to_policy" <?php echo $this->session->agree_to_policy == '1' ? 'checked' : ''; ?> />
    															<span></span>
    														</label>
                                                        </div>
                                                        <?php echo form_error('agree_to_policy', '<cite class="help-block text-danger">', '</cite>'); ?>
													</div>

                                                    <!-- RETURN POLICY -->
                                                    <?php

                                            		if ($this->session->user_role == 'wholesale')
                                            		{
                                            			$page_details = $this->get_pages->page_details('wholesale_return_policy');
                                            		}
                                            		else
                                            		{
                                            			$page_details = $this->get_pages->page_details('return_policy');
                                            		}
                                                    ?>

                                            		<div class="modal fade bs-modal-lg" id="modal-return_policy" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                            			<div class="modal-dialog modal-lg loading-fade">
                                            				<div class="modal-content">
                                            					<div class="modal-header">
                                            						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            						<h4 class="modal-title"><?php echo strtoupper($this->webspace_details->name.' '.$page_details->title); ?></h4>
                                            					</div>
                                            					<div class="modal-body">
                                            						<p class="modal-body-text"><?php echo str_replace('Instylenewyork.com', ucwords($this->webspace_details->site), @$page_details->text); ?></p>
                                            					</div>
                                                                <div class="modal-footer">
                                            						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            					</div>
                                            				</div>
                                            				<!-- /.modal-content -->
                                            			</div>
                                            			<!-- /.modal-dialog -->
                                            		</div>
                                            		<!-- /modal -->
