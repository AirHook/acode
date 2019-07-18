									<div class="form-body">

										<div class="form-group">
											<label class="control-label">Package Name
												<span class="required"> * </span>
											</label>
											<input type="text" name="sales_package_name" data-required="1" class="form-control" value="<?php echo $this->session->sa_name; ?>" />
											<cite class="help-block small"> A a user friendly name to identify this package as reference. </cite>
										</div>
										<hr />
										<div class="form-group">
											<label class="control-label">Email Subject
												<span class="required"> * </span>
											</label>
											<input type="text" name="email_subject" data-required="1" class="form-control" value="<?php echo @$this->session->sa_email_subject; ?>" />
											<cite class="help-block small"> Used as the subject for the email. </cite>
										</div>
										<div class="form-group">
											<label class="control-label">Message
											</label>
											<textarea name="email_message" class="form-control summernote" id="summernote_1" data-error-container="email_message_error"><?php echo $this->session->sa_email_message; ?></textarea>
											<cite class="help-block small"> A short message to the users. HTML tags are accepted. </cite>
											<div id="email_message_error"> </div>
										</div>

									</div>

									<hr />
