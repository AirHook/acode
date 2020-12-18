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
                                $url_pre.'/marketing/carousels/edit/index/'.$carousel_details->carousel_id,
                                array(
                                    'class'=>'form-horizontal',
                                    'id'=>'form-carousel_edit'
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
                                    <?php if ($this->session->flashdata('error') == 'invalid_email') { ?>
                                    <div class="alert alert-danger ">
                                        <button class="close" data-close="alert"></button> There was an error with the email address. Please try again.
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('success') == 'test_sent') { ?>
                                    <div class="alert alert-success ">
                                        <button class="close" data-close="alert"></button> The carousel was sent to your nominated email. Please check your inbox.
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('error') == 'test_unsent') { ?>
                                    <div class="alert alert-danger ">
                                        <button class="close" data-close="alert"></button> There was a problem sending the test email. Please try again.
                                    </div>
                                    <?php } ?>
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
                                                <input type="checkbox" name="status" value="1" <?php echo set_checkbox('status', '1'); ?> <?php echo $carousel_details->status == '1' ? 'checked="checked"' : ''; ?> /> Active
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
                                        <input type="text" name="name" data-required="1" class="form-control" value="<?php echo $carousel_details->name; ?>" />
                                        <cite class="small margin-bottom-10" style="margin-top:5px;display:block;color:#737373;"> A friendly name identifying the carousel </cite>
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
												<input type="radio" class="form-control" name="type" value="once" data-error-container="select-type-error" <?php echo set_radio('type', 'once'); ?> <?php echo $carousel_details->type == 'once' ? 'checked="checked"' : ''; ?> /> Once
												<span></span>
											</label>
                                            <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
												<input type="radio" class="form-control" name="type" value="recurring" data-error-container="select-type-error" <?php echo set_radio('type', 'recurring'); ?> <?php echo $carousel_details->type == 'recurring' ? 'checked="checked"' : ''; ?> /> Recurring
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
                                        <div class="select-schedule select-schedule-once <?php echo $carousel_details->type == 'once' ? '' : 'display-none'; ?>">
                                            <div class="input-group input-medium date date-picker date-picker-once" data-date-format="yyyy-mm-dd" data-date-start-date="+1d">
                                                <input type="text" class="form-control" name="date" data-error-container="select-schedule-error" <?php echo $carousel_details->type == 'once' ? '' : 'disabled'; ?> value="<?php echo date('Y-m-d', $carousel_details->schedule); ?>" />
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button" <?php echo $carousel_details->type == 'once' ? '' : 'disabled'; ?>>
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="select-schedule select-schedule-recurring <?php echo $carousel_details->type == 'once' ? 'display-none' : ''; ?>">
                                            <input type="hidden" class="input-schedule-recurring" name="<?php echo empty($carousel_details->cron_data) ? '' : key($carousel_details->cron_data); ?>" value="<?php echo empty($carousel_details->cron_data) ? '' : $carousel_details->cron_data[key($carousel_details->cron_data)]; ?>" data-error-container="select-schedule-error" <?php echo $carousel_details->type == 'once' ? 'disabled' : ''; ?> />
                                            <style>
                                            .date-picker-button {
                                                width: 42px;
                                            }
                                            </style>
                                            <div class="margin-bottom-10"> Weekly </div>
                                            <?php
                                            if (@$carousel_details->cron_data['week']) $weekly_schedule = explode(',', $carousel_details->cron_data['week']);
                                            else $weekly_schedule = array();
                                            ?>
                                            <div class="btn-toolbar margin-bottom-10">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input <?php echo in_array('mon', $weekly_schedule) ? 'active' : ''; ?>" data-value="mon" data-schedule-param="week">Mo
                                                        <input type="hidden" name="week[]" value="mon" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input <?php echo in_array('tue', $weekly_schedule) ? 'active' : ''; ?>" data-value="tue" data-schedule-param="week">Tu
                                                        <input type="hidden" name="week[]" value="tue" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input <?php echo in_array('wed', $weekly_schedule) ? 'active' : ''; ?>" data-value="wed" data-schedule-param="week">We
                                                        <input type="hidden" name="week[]" value="wed" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input <?php echo in_array('thu', $weekly_schedule) ? 'active' : ''; ?>" data-value="thu" data-schedule-param="week">Th
                                                        <input type="hidden" name="week[]" value="thu" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input <?php echo in_array('fri', $weekly_schedule) ? 'active' : ''; ?>" data-value="fri" data-schedule-param="week">Fr
                                                        <input type="hidden" name="week[]" value="fri" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input <?php echo in_array('sat', $weekly_schedule) ? 'active' : ''; ?>" data-value="sat" data-schedule-param="week">Sa
                                                        <input type="hidden" name="week[]" value="sat" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-weekly step-input <?php echo in_array('sun', $weekly_schedule) ? 'active' : ''; ?>" data-value="sun" data-schedule-param="week">Su
                                                        <input type="hidden" name="week[]" value="sun" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="margin-bottom-10"> Monthly </div>
                                            <?php
                                            if (@$carousel_details->cron_data['month']) $monthly_schedule = explode(',', $carousel_details->cron_data['month']);
                                            else $monthly_schedule = array();
                                            ?>
                                            <div class="btn-toolbar margin-bottom-10">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('1', $monthly_schedule) ? 'active' : ''; ?>" data-value="1" data-schedule-param="month">1
                                                        <input type="hidden" name="month[]" value="1" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('2', $monthly_schedule) ? 'active' : ''; ?>" data-value="2" data-schedule-param="month">2
                                                        <input type="hidden" name="month[]" value="2" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('3', $monthly_schedule) ? 'active' : ''; ?>" data-value="3" data-schedule-param="month">3
                                                        <input type="hidden" name="month[]" value="3" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('4', $monthly_schedule) ? 'active' : ''; ?>" data-value="4" data-schedule-param="month">4
                                                        <input type="hidden" name="month[]" value="4" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('5', $monthly_schedule) ? 'active' : ''; ?>" data-value="5" data-schedule-param="month">5
                                                        <input type="hidden" name="month[]" value="5" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('6', $monthly_schedule) ? 'active' : ''; ?>" data-value="6" data-schedule-param="month">6
                                                        <input type="hidden" name="month[]" value="6" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('7', $monthly_schedule) ? 'active' : ''; ?>" data-value="7" data-schedule-param="month">7
                                                        <input type="hidden" name="month[]" value="7" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('8', $monthly_schedule) ? 'active' : ''; ?>" data-value="8" data-schedule-param="month">8
                                                        <input type="hidden" name="month[]" value="8" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('9', $monthly_schedule) ? 'active' : ''; ?>" data-value="9" data-schedule-param="month">9
                                                        <input type="hidden" name="month[]" value="9" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('10', $monthly_schedule) ? 'active' : ''; ?>" data-value="10" data-schedule-param="month">10
                                                        <input type="hidden" name="month[]" value="10" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('11', $monthly_schedule) ? 'active' : ''; ?>" data-value="11" data-schedule-param="month">11
                                                        <input type="hidden" name="month[]" value="11" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('12', $monthly_schedule) ? 'active' : ''; ?>" data-value="12" data-schedule-param="month">12
                                                        <input type="hidden" name="month[]" value="12" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('13', $monthly_schedule) ? 'active' : ''; ?>" data-value="13" data-schedule-param="month">13
                                                        <input type="hidden" name="month[]" value="13" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('14', $monthly_schedule) ? 'active' : ''; ?>" data-value="14" data-schedule-param="month">14
                                                        <input type="hidden" name="month[]" value="14" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('15', $monthly_schedule) ? 'active' : ''; ?>" data-value="15" data-schedule-param="month">15
                                                        <input type="hidden" name="month[]" value="15" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('16', $monthly_schedule) ? 'active' : ''; ?>" data-value="16" data-schedule-param="month">16
                                                        <input type="hidden" name="month[]" value="16" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('17', $monthly_schedule) ? 'active' : ''; ?>" data-value="17" data-schedule-param="month">17
                                                        <input type="hidden" name="month[]" value="17" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('18', $monthly_schedule) ? 'active' : ''; ?>" data-value="18" data-schedule-param="month">18
                                                        <input type="hidden" name="month[]" value="18" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('19', $monthly_schedule) ? 'active' : ''; ?>" data-value="19" data-schedule-param="month">19
                                                        <input type="hidden" name="month[]" value="19" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('20', $monthly_schedule) ? 'active' : ''; ?>" data-value="20" data-schedule-param="month">20
                                                        <input type="hidden" name="month[]" value="20" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('21', $monthly_schedule) ? 'active' : ''; ?>" data-value="21" data-schedule-param="month">21
                                                        <input type="hidden" name="month[]" value="21" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('22', $monthly_schedule) ? 'active' : ''; ?>" data-value="22" data-schedule-param="month">22
                                                        <input type="hidden" name="month[]" value="22" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('23', $monthly_schedule) ? 'active' : ''; ?>" data-value="23" data-schedule-param="month">23
                                                        <input type="hidden" name="month[]" value="23" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('24', $monthly_schedule) ? 'active' : ''; ?>" data-value="24" data-schedule-param="month">24
                                                        <input type="hidden" name="month[]" value="24" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('25', $monthly_schedule) ? 'active' : ''; ?>" data-value="25" data-schedule-param="month">25
                                                        <input type="hidden" name="month[]" value="25" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('26', $monthly_schedule) ? 'active' : ''; ?>" data-value="26" data-schedule-param="month">26
                                                        <input type="hidden" name="month[]" value="26" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('27', $monthly_schedule) ? 'active' : ''; ?>" data-value="27" data-schedule-param="month">27
                                                        <input type="hidden" name="month[]" value="27" data-error-container="select-schedule-error" disabled />
                                                    </button>
                                                    <button type="button" class="btn btn-default date-picker-button select-monthly step-input <?php echo in_array('28', $monthly_schedule) ? 'active' : ''; ?>" data-value="28" data-schedule-param="month">28
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
												<input type="checkbox" class="form-control chb-radio chb-radio-layout" name="layout" value="default" data-error-container="select-layout-error" <?php echo set_checkbox('layout', 'default'); ?> <?php echo $carousel_details->layout == 'default' ? 'checked="checked"' : ''; ?> /> General (No specific designer)
												<span></span>
                                                <cite class="small " style="font-size:70%;margin-top:5px;display:block;color:#737373;">Holds 30 thumbs in one email</cite>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-layout" name="layout" value="single_designer" data-error-container="select-layout-error" <?php echo set_checkbox('layout', 'single_designer'); ?> <?php echo $carousel_details->layout == 'single_designer' ? 'checked="checked"' : ''; ?> /> Single Designer
												<span></span>
                                                <cite class="small " style="font-size:70%;margin-top:5px;display:block;color:#737373;">Holds 30 thumbs in one email with a heading for the designer</cite>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-layout" name="layout" value="multi_designer" data-error-container="select-layout-error" <?php echo set_checkbox('layout', 'multi_designer'); ?> <?php echo $carousel_details->layout == 'multi_designer' ? 'checked="checked"' : ''; ?> /> Multiple Designer
												<span></span>
                                                <cite class="small " style="font-size:70%;margin-top:5px;display:block;color:#737373;">A set of 6 thumbs per designer heading</cite>
											</label>
										</div>
                                        <div id="select-layout-error"></div>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('layout'); ?> </cite>
                                    </div>
                                </div>

                                    <?php
                                } ?>

                                <hr class="form-group-designer <?php echo empty($carousel_details->designer) ? 'display-none' : ''; ?>" style="margin:10px 0 20px;" />

                                <!-- Select Designer -->
                                <div class="form-group form-group-designer <?php echo empty($carousel_details->designer) ? 'display-none' : ''; ?>">
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
                                                        {
                                                            if ($carousel_details->designer)
                                                            {
                                                                $designer_checked = in_array($designer->url_structure, $carousel_details->designer)
                                                                    ? 'checked="checked"'
                                                                    : ''
                                                                ;
                                                            }
                                                            else $designer_checked = '';
                                                            ?>

                                                <label class="mt-checkbox mt-checkbox-outline">
    												<input type="checkbox" class="form-control" name="designer[]" value="<?php echo $designer->url_structure; ?>" data-error-container="select-designer-error" <?php echo $designer_checked; ?> /> <?php echo ucwords(strtolower($designer->designer)); ?>
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
												<input type="checkbox" class="form-control chb-radio chb-radio-stock" name="stock_condition" value="mixed" data-error-container="select-stock-condition-error" <?php echo set_checkbox('stock_condition', 'mixed'); ?> <?php echo $carousel_details->stock_condition == 'mixed' ? 'checked="checked"' : ''; ?> /> Mixed
												<span></span>
											</label>
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-stock" name="stock_condition" value="instock" data-error-container="select-stock-condition-error" <?php echo set_checkbox('stock_condition', 'instock'); ?> <?php echo $carousel_details->stock_condition == 'instock' ? 'checked="checked"' : ''; ?> /> In Stock
												<span></span>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-stock" name="stock_condition" value="onsale" data-error-container="select-stock-condition-error" <?php echo set_checkbox('stock_condition', 'onsale'); ?> <?php echo $carousel_details->stock_condition == 'onsale' ? 'checked="checked"' : ''; ?> /> On Sale
												<span></span>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-stock" name="stock_condition" value="preorder" data-error-container="select-stock-condition-error" <?php echo set_checkbox('stock_condition', 'preorder'); ?> <?php echo $carousel_details->stock_condition == 'preorder' ? 'checked="checked"' : ''; ?> /> Pre Order
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
												<input type="checkbox" class="form-control chb-radio chb-radio-users" name="users" value="all" data-error-container="select-users-error" <?php echo set_checkbox('users', 'all'); ?> <?php echo $carousel_details->users == 'all' ? 'checked="checked"' : ''; ?> /> All
												<span></span>
											</label>
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-users" name="users" value="consumers" data-error-container="select-users-error" <?php echo set_checkbox('users', 'consumers'); ?> <?php echo $carousel_details->users == 'consumers' ? 'checked="checked"' : ''; ?> /> Consumers
												<span></span>
											</label>
                                            <label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="form-control chb-radio chb-radio-users" name="users" value="wholesale" data-error-container="select-users-error" <?php echo set_checkbox('users', 'wholesale'); ?> <?php echo $carousel_details->users == 'wholesale' ? 'checked="checked"' : ''; ?> /> Wholesale
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
                                    .notice-recurring_,
                                    .subject-recurring_,
                                    .message-recurring_ {
                                        display: none;
                                    }
                                </style>
                                <div class="form-group notice-recurring <?php echo $carousel_details->type == 'once' ? 'display-none' : ''; ?>">
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
                                        <?php
                                        $i = 0;
                                        for ($i = 0; $i < 5; $i++)
                                        {
                                            $subject_recurring = $i > 0 ? 'subject-recurring' : '';
                                            $display_none_on_once = ($carousel_details->type == 'once' && $i > 0) ? 'display-none' : '';
                                            ?>

                                            <input type="text" name="subject[]" class="form-control margin-bottom-5 step-input <?php echo $subject_recurring; ?> <?php echo $display_none_on_once; ?>" value="<?php echo @$carousel_details->subject[$i]; ?>" />

                                            <?php
                                        } ?>
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
                                        <?php
                                        $i = 0;
                                        for ($i = 0; $i < 5; $i++)
                                        {
                                            $display_none_on_once = ($carousel_details->type == 'once' && $i > 0) ? 'display-none' : '';
                                            $message_recurring_wrapper_start = $i > 0 ? '<div class="message-recurring-wrapper '.$display_none_on_once.'">' : '';
                                            $message_recurring_wrapper_end = $i > 0 ? '</div>' : '';
                                            $message_recurring = $i > 0 ? 'message-recurring' : 'show-as-sample';

                                            echo $message_recurring_wrapper_start;
                                            ?>

                                            <textarea name="message[]" class="form-control step-input summernote <?php echo $message_recurring; ?>">
                                                <?php echo @$carousel_details->message[$i]; ?>
                                            </textarea>

                                            <?php
                                            echo $message_recurring_wrapper_end;
                                        } ?>
                                        <cite class="help-block font-red-mint"> <?php echo form_error('message'); ?> </cite>
                                    </div>
                                </div>

                                <hr style="margin:10px 0 20px;" />

                                <div class="form-actions bottom">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn dark">Update</button>
                                            <a href="<?php echo site_url('admin/marketing/carousels'); ?>" type="button" class="btn default ">Cancel</a>
                                            <a href="#test_send-<?php echo $carousel_details->carousel_id; ?>" data-toggle="modal" type="button" class="btn grey-salsa btn-outline btn-test-send">Test Send</a>
                                        </div>
                                        <div class="col-md-offset-3 col-md-9">
        									<br />
        									<a data-toggle="modal" href="#delete-<?php echo $carousel_details->carousel_id; ?>"><em>Delete Permanently</em></a>
        								</div>
                                    </div>
                                </div>

                                <!-- TEST SEND -->
                                <div class="modal fade bs-modal-md" id="test_send-<?php echo $carousel_details->carousel_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title">Test Send Carousel</h4>
                                            </div>
                                            <div class="modal-body">

                                                <!-- Carousel Name -->
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">
                                                        Email
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input type="email" name="email" data-required="1" class="form-control test-send-email" value="" data-carousel_id="<?php echo $carousel_details->carousel_id?>" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn green test-send-carousel">Send</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

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

                                <div class="col-md-12 notice-email-content display-none">
                                    <h3> <cite>View sample email content here...</cite> </h3>
                                </div>

                                <div class="col-md-12 layout-content layout-content-default <?php echo $carousel_details->layout == 'default' ? '' : 'display-none'; ?>">
                                    <div class="alert alert-warning margin-top-10">
                                        <button class="close" data-close="alert"></button> This is just a sample view. No actual data is shown here.
                                        <br /><br />
                                        Mixed designer thumbs based on Stock Condition option checked up to 30 thumbs in one email.
                                    </div>
                                    <?php $this->load->view('templates/carousel_layout01'); ?>
                                </div>

                                <div class="col-md-12 layout-content layout-content-single <?php echo $carousel_details->layout == 'single_designer' ? '' : 'display-none'; ?>">
                                    <div class="alert alert-success margin-top-10">
                                        <button class="close" data-close="alert"></button> This is just a sample view. No actual data is shown here.
                                        <br /><br />
                                        A single designer logo on top of up to 30 thumbs specific to the designer based on Stock Condition option checked.
                                    </div>
                                    <?php $this->load->view('templates/carousel_layout02'); ?>
                                </div>

                                <div class="col-md-12 layout-content layout-content-multi <?php echo $carousel_details->layout == 'multi_designer' ? '' : 'display-none'; ?>">
                                    <div class="alert alert-info margin-top-10">
                                        <button class="close" data-close="alert"></button> This is just a sample view. No actual data is shown here.
                                        <br /><br />
                                        A multi-designer thumb collection of up to 6 thumbs per designer with the designer logo heading the collection. Desinger is as per selected designer.
                                    </div>
                                    <?php $this->load->view('templates/carousel_layout03'); ?>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- END PAGE CONTENT BODY -->

                    <!-- DELETE ITEM -->
					<div class="modal fade bs-modal-sm" id="delete-<?php echo $carousel_details->carousel_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Warning!</h4>
								</div>
								<div class="modal-body">
									Permanently DELETE item? <br /> This cannot be undone!
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url('admin/marketing/delete/index/'.$carousel_details->carousel_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</a>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
