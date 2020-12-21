                    <!-- BEGIN PAGE CONTENT BODY -->
                    <?php
                    $url_pre = @$role == 'sales' ? 'my_account/sales' : 'admin';
                    ?>

                    <div class="row">

                        <?php
                        /***********
                         * Left Section
                         */
                        ?>
                        <div class="col-md-6 form-horizontal" role="form">

                            <!-- BEGIN FORM-->
                            <!-- FORM =======================================================================-->
                            <?php echo form_open(
                                $url_pre.'/marketing/carousels/add',
                                array(
                                    'class'=>'form-horizontal',
                                    'id'=>'form-carousel_add'
                                )
                            ); ?>

							<div class="form-body">

								<?php
								/***********
								 * Noification area
								 */
								?>
								<div class="notifications">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                    <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                                    <div class="alert alert-danger ">
                                        <button class="close" data-close="alert"></button> An error occured. Please try again.
                                    </div>
                                    <?php } ?>
                                    <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> There were errors in the form. Please try again...
                                        <br />
                                        <?php echo validation_errors(); ?>
                                    </div>
                                    <?php } ?>
								</div>

                                <?php
								/***********
								 * Options
								 */
								?>
                                <hr style="margin:10px 0 20px;" />

                                <!-- Status -->
                                <div class="form-group" style="margin-bottom:0px;">
                                    <label class="control-label col-md-3">Status</label>
                                    <div class="col-md-9">
                                        <div class="mt-checkbox-inline">
                                            <label class="mt-checkbox mt-checkbox-outline">
                                                <input type="checkbox" name="status" value="1" <?php echo set_checkbox('status', '1'); ?> checked="checked" /> Active
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <hr style="margin:10px 0 20px;" />

                                <!-- Carousel Name -->
                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        Carousel Name
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" data-required="1" class="form-control" value="<?php echo set_value('name'); ?>" />
                                        <cite class="small margin-bottom-10" style="margin-top:5px;display:block;color:#737373;"> A friendly name to identify the carousel </cite>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('name'); ?> </cite>
                                    </div>
                                </div>

                                <hr style="margin:10px 0 20px;" />

                                <!-- Schedule -->
                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        Schedule Type
                                    </label>
                                    <div class="col-md-9">
                                        <div class="mt-radio-inline">
											<label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
												<input type="radio" class="form-control" name="type" value="once" data-error-container="select-type-error" /> Once
												<span></span>
											</label>
                                            <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
												<input type="radio" class="form-control" name="type" value="recurring" data-error-container="select-type-error" /> Recurring
												<span></span>
											</label>
										</div>
                                        <div id="select-type-error"></div>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('type'); ?> </cite>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        Schedule Dates
                                    </label>
                                    <div class="col-md-9">
                                        <div class="select-schedule select-schedule-once">
                                            <div class="input-group input-medium date date-picker date-picker-once" data-date-format="yyyy-mm-dd" data-date-start-date="+1d">
                                                <input type="text" class="form-control" name="date" data-error-container="select-schedule-error" disabled />
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button" disabled>
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <cite class="small margin-bottom-10" style="margin-top:5px;display:block;color:#737373;"> Select date to send carousel </cite>
                                        </div>
                                        <div class="select-schedule select-schedule-recurring display-none">
                                            <input type="hidden" class="input-schedule-recurring" name="" value="" data-error-container="select-schedule-error" disabled />
                                            <style>
                                            .date-picker-button {
                                                width: 42px;
                                            }
                                            </style>
                                            <div class="margin-bottom-10"> Weekly </div>
                                            <div class="btn-toolbar margin-bottom-10">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input" data-value="mon" data-schedule-param="week">Mo
                                                        <input type="hidden" name="week[]" value="mon" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input" data-value="tue" data-schedule-param="week">Tu
                                                        <input type="hidden" name="week[]" value="tue" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input" data-value="wed" data-schedule-param="week">We
                                                        <input type="hidden" name="week[]" value="wed" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input" data-value="thu" data-schedule-param="week">Th
                                                        <input type="hidden" name="week[]" value="thu" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input" data-value="fri" data-schedule-param="week">Fr
                                                        <input type="hidden" name="week[]" value="fri" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input" data-value="sat" data-schedule-param="week">Sa
                                                        <input type="hidden" name="week][]" value="sat" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input" data-value="sun" data-schedule-param="week">Su
                                                        <input type="hidden" name="week[]" value="sun" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                            </div>
                                            <cite class="small margin-bottom-20" style="margin-top:5px;display:block;color:#737373;">Select a day or multiple days of the week</cite>
                                            <div class="margin-bottom-10"> Monthly </div>
                                            <div class="btn-toolbar margin-bottom-10">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="1" data-schedule-param="month">1
                                                        <input type="hidden" name="month[]" value="1" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="2" data-schedule-param="month">2
                                                        <input type="hidden" name="month[]" value="2" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="3" data-schedule-param="month">3
                                                        <input type="hidden" name="month[]" value="3" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="4" data-schedule-param="month">4
                                                        <input type="hidden" name="month[]" value="4" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="5" data-schedule-param="month">5
                                                        <input type="hidden" name="month[]" value="5" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="6" data-schedule-param="month">6
                                                        <input type="hidden" name="month[]" value="6" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="7" data-schedule-param="month">7
                                                        <input type="hidden" name="month[]" value="7" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="8" data-schedule-param="month">8
                                                        <input type="hidden" name="month[]" value="8" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="9" data-schedule-param="month">9
                                                        <input type="hidden" name="month[]" value="9" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="10" data-schedule-param="month">10
                                                        <input type="hidden" name="month[]" value="10" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="11" data-schedule-param="month">11
                                                        <input type="hidden" name="month[]" value="11" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="12" data-schedule-param="month">12
                                                        <input type="hidden" name="month[]" value="12" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="13" data-schedule-param="month">13
                                                        <input type="hidden" name="month[]" value="13" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="14" data-schedule-param="month">14
                                                        <input type="hidden" name="month[]" value="14" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="15" data-schedule-param="month">15
                                                        <input type="hidden" name="month[]" value="15" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="16" data-schedule-param="month">16
                                                        <input type="hidden" name="month[]" value="16" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="17" data-schedule-param="month">17
                                                        <input type="hidden" name="month[]" value="17" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="18" data-schedule-param="month">18
                                                        <input type="hidden" name="month[]" value="18" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="19" data-schedule-param="month">19
                                                        <input type="hidden" name="month[]" value="19" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="20" data-schedule-param="month">20
                                                        <input type="hidden" name="month[]" value="20" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="21" data-schedule-param="month">21
                                                        <input type="hidden" name="month[]" value="21" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="22" data-schedule-param="month">22
                                                        <input type="hidden" name="month[]" value="22" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="23" data-schedule-param="month">23
                                                        <input type="hidden" name="month[]" value="23" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="24" data-schedule-param="month">24
                                                        <input type="hidden" name="month[]" value="24" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="25" data-schedule-param="month">25
                                                        <input type="hidden" name="month[]" value="25" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="26" data-schedule-param="month">26
                                                        <input type="hidden" name="month[]" value="26" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="27" data-schedule-param="month">27
                                                        <input type="hidden" name="month[]" value="27" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input" data-value="28" data-schedule-param="month">28
                                                        <input type="hidden" name="month[]" value="28" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                            </div>
                                            <cite class="small margin-bottom-10" style="margin-top:5px;display:block;color:#737373;">Select a day or multiple days of the month</cite>
                                        </div>
                                        <div id="select-schedule-error"></div>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('schedule[]'); ?> </cite>
                                    </div>
                                </div>

                                <?php if ($designers)
                                { ?>

                                <hr style="margin:10px 0 20px;" />

                                <!-- Layout -->
                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        Layout
                                    </label>
                                    <div class="col-md-9">
                                        <div class="mt-checkbox-list" data-param="layout">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-layout" name="layout" value="default" data-error-container="select-layout-error" <?php echo set_checkbox('layout', 'default'); ?> /> General (No specific designer)
												<span></span>
                                                <cite class="small " style="font-size:70%;margin-top:5px;display:block;color:#737373;">Holds 30 thumbs in one email</cite>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-layout" name="layout" value="single_designer" data-error-container="select-layout-error" <?php echo set_checkbox('layout', 'single_designer'); ?> /> Single Designer
												<span></span>
                                                <cite class="small " style="font-size:70%;margin-top:5px;display:block;color:#737373;">Holds 30 thumbs in one email with a heading for the designer</cite>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-layout" name="layout" value="multi_designer" data-error-container="select-layout-error" <?php echo set_checkbox('layout', 'multi_designer'); ?> /> Multiple Designer
												<span></span>
                                                <cite class="small " style="font-size:70%;margin-top:5px;display:block;color:#737373;">A set of 6 thumbs per designer heading</cite>
											</label>
										</div>
                                        <cite class="small " style="margin-top:5px;display:block;color:#737373;">On check of layout, a sample layout will show on the right</cite>
                                        <div id="select-layout-error"></div>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('layout'); ?> </cite>
                                    </div>
                                </div>

                                    <?php
                                } ?>

                                <hr class="form-group-designer display-none" style="margin:10px 0 20px;" />

                                <!-- Select Designer -->
                                <div class="form-group form-group-designer display-none">
                                    <label class="control-label col-md-3">
                                        Designer
                                    </label>
                                    <div class="col-md-9">
                                        <div class="select-designer select-designer-multi">
                                            <div class="mt-checkbox-list" data-param="designer">
                                                <?php if (@$designers)
                                                {
                                                    foreach ($designers as $designer)
                                                    {
                                                        if ($designer->with_products)
                                                        { ?>

                                                <label class="mt-checkbox mt-checkbox-outline">
    												<input type="checkbox" class="form-control" name="designer[]" value="<?php echo $designer->url_structure; ?>" data-error-container="select-designer-error" /> <?php echo ucwords(strtolower($designer->designer)); ?>
    												<span></span>
    											</label>

                                                            <?php
                                                        }
                                                    }

                                                } ?>
    										</div>
                                        </div>
                                        <div id="select-designer-error"></div>
                                    </div>
                                </div>

                                <hr style="margin:10px 0 20px;" />

                                <!-- Stock Condition -->
                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        Stock Condition
                                    </label>
                                    <div class="col-md-9">
                                        <div class="mt-checkbox-list" data-param="stock">
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-stock" name="stock_condition" value="mixed" data-error-container="select-stock-condition-error" <?php echo set_checkbox('stock_condition', 'mixed'); ?> /> Mixed
												<span></span>
											</label>
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-stock" name="stock_condition" value="instock" data-error-container="select-stock-condition-error" <?php echo set_checkbox('stock_condition', 'instock'); ?> /> In Stock
												<span></span>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-stock" name="stock_condition" value="onsale" data-error-container="select-stock-condition-error" <?php echo set_checkbox('stock_condition', 'onsale'); ?> /> On Sale
												<span></span>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-stock" name="stock_condition" value="preorder" data-error-container="select-stock-condition-error" <?php echo set_checkbox('stock_condition', 'preorder'); ?> /> Pre Order
												<span></span>
											</label>
										</div>
                                        <div id="select-stock-condition-error"></div>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('stock_condition'); ?> </cite>
                                    </div>
                                </div>

                                <?php if ($this->webspace_details->slug != 'tempoparis')
                                { ?>
                                <hr style="margin:10px 0 20px;" />

                                <!-- Stock Condition -->
                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        Send to
                                    </label>
                                    <div class="col-md-9">
                                        <div class="mt-checkbox-list" data-param="users">
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-users" name="users" value="all" data-error-container="select-users-error" <?php echo set_checkbox('users', 'all'); ?> /> All
												<span></span>
											</label>
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-users" name="users" value="consumers" data-error-container="select-users-error" <?php echo set_checkbox('users', 'consumers'); ?> /> Consumers
												<span></span>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-users" name="users" value="wholesale" data-error-container="select-users-error" <?php echo set_checkbox('users', 'wholesale'); ?> /> Wholesale
												<span></span>
											</label>
										</div>
                                        <div id="select-users-error"></div>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('users'); ?> </cite>
                                    </div>
                                </div>
                                    <?php
                                } ?>

                                <hr style="margin:10px 0 20px;" />

                                <!-- Email Content -->
                                <style>
                                    .notice-recurring,
                                    .subject-recurring,
                                    .message-recurring {
                                        display: none;
                                    }
                                </style>
                                <div class="form-group notice-recurring">
                                    <label class="col-md-3 control-label">
                                    </label>
                                    <div class="col-md-9">
                                        <div class="alert alert-info ">
                                            For recurring carousel, please add five different email subjects and email messages that the system can loop through so as to avoid monopolization in the matter.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Email Subject
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" name="subject[]" class="form-control margin-bottom-5 step-input" value="<?php echo set_value('subject[0]'); ?>" />
                                        <input type="text" name="subject[]" class="form-control margin-bottom-5 step-input subject-recurring" value="<?php echo set_value('subject[1]'); ?>" />
                                        <input type="text" name="subject[]" class="form-control margin-bottom-5 step-input subject-recurring" value="<?php echo set_value('subject[2]'); ?>" />
                                        <input type="text" name="subject[]" class="form-control margin-bottom-5 step-input subject-recurring" value="<?php echo set_value('subject[3]'); ?>" />
                                        <input type="text" name="subject[]" class="form-control margin-bottom-5 step-input subject-recurring" value="<?php echo set_value('subject[4]'); ?>" />
                                        <cite class="help-block font-red-mint"> <?php echo form_error('subject'); ?> </cite>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Message
                                    </label>
                                    <div class="col-md-9">
                                        <div class="alert alert-info ">
                                            Do not include salutations on message below. The email layout will have it's own salutation.
                                        </div>
                                        <textarea name="message[]" class="form-control step-input summernote show-as-sample"><?php echo set_value('message[0]'); ?></textarea>
                                        <div class="message-recurring-wrapper display-none">
                                            <textarea name="message[]" class="form-control step-input summernote message-recurring"><?php echo set_value('message[1]'); ?></textarea>
                                        </div>
                                        <div class="message-recurring-wrapper display-none">
                                            <textarea name="message[]" class="form-control step-input summernote message-recurring"><?php echo set_value('message[2]'); ?></textarea>
                                        </div>
                                        <div class="message-recurring-wrapper display-none">
                                            <textarea name="message[]" class="form-control step-input summernote message-recurring"><?php echo set_value('message[3]'); ?></textarea>
                                        </div>
                                        <div class="message-recurring-wrapper display-none">
                                            <textarea name="message[]" class="form-control step-input summernote message-recurring"><?php echo set_value('message[4]'); ?></textarea>
                                        </div>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('message'); ?> </cite>
                                    </div>
                                </div>

                                <hr style="margin:10px 0 20px;" />

                                <div class="form-actions bottom">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn dark">Save</button>
                                            <a href="<?php echo site_url('admin/marketing/carousels'); ?>" type="button" class="btn default ">Cancel</a>
                                            <!--<button type="button" class="btn grey-salsa btn-outline ">Test Send</button>-->
                                        </div>
                                    </div>
                                </div>
							</div>

                            </form>
                            <!-- END  =======================================================================-->
                            <!-- END FORM-->

                        </div>

                        <?php
                        /***********
                         * Right Section
                         */
                        ?>
                        <div class="col-md-6" style="border:1px solid #ccc;min-height:500px;">
                            <div class="row">

                                <div class="col-md-12 notice-email-content <?php echo $designers ? '' : 'hide'; ?>">
                                    <h3> <cite>View sample email content here...</cite> </h3>
                                </div>

                                <?php if ($designers)
                                { ?>
                                <div class="col-md-12 layout-content layout-content-default display-none">
                                    <div class="alert alert-warning margin-top-10">
                                        <button class="close" data-close="alert"></button> This is just a sample view. No actual data is shown here.
                                        <br /><br />
                                        Mixed designer thumbs based on Stock Condition option checked up to 30 thumbs in one email.
                                    </div>
                                    <?php $this->load->view('templates/carousel_layout01'); ?>
                                </div>
                                    <?php
                                } ?>

                                <div class="col-md-12 layout-content layout-content-single <?php echo $designers ? 'display-none' : ''; ?>">
                                    <div class="alert alert-success margin-top-10">
                                        <button class="close" data-close="alert"></button> This is just a sample view. No actual data is shown here.
                                        <br /><br />
                                        A single designer logo on top of up to 30 thumbs specific to the designer based on Stock Condition option checked.
                                    </div>
                                    <?php $this->load->view('templates/carousel_layout02'); ?>
                                </div>

                                <?php if ($designers)
                                { ?>
                                <div class="col-md-12 layout-content layout-content-multi display-none">
                                    <div class="alert alert-info margin-top-10">
                                        <button class="close" data-close="alert"></button> This is just a sample view. No actual data is shown here.
                                        <br /><br />
                                        A multi-designer thumb collection of up to 6 thumbs per designer with the designer logo heading the collection. Desinger is as per selected designer.
                                    </div>
                                    <?php $this->load->view('templates/carousel_layout03'); ?>
                                </div>
                                    <?php
                                } ?>

                            </div>
                        </div>

                    </div>
                    <!-- END PAGE CONTENT BODY -->
