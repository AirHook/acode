                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'webspaces/edit/'.(@$admin ?: 'index').'/'.$this->edit_webspace_details->id,
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-webspace_edit'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <label class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces/add'); ?>" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false"> Add a New Webspace
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <!-- DOC: Remove "hide" class to enable the reset button -->
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                    <div class="btn-group">
                                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        <ul class="dropdown-menu">

                                            <?php if ($webspaces) { ?>

                                            <li>
                                                <a href="javascript:;"> <cite>Switch webspaces...</cite>
                                                </a>
                                            </li>
                                            <li class="divider"> </li>

                                                <?php foreach ($webspaces as $webspace) {
                                                    if (
                                                        $webspace->webspace_id !== $this->edit_webspace_details->id
                                                        && $webspace->webspace_name != ''
                                                    ) { ?>

                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces/edit/index/'.$webspace->webspace_id); ?>" onclick="$('#loading').modal('show');">
                                                <?php echo $webspace->webspace_name; ?></a>
                                            </li>

                                                    <?php }
                                                } ?>

                                            <?php } else { ?>

                                            <li>
                                                <a href="javascript:;"> No other webspaces...
                                                </a>
                                            </li>

                                            <?php } ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-body">

                            <?php
                            /***********
                             * Noification area
                             */
                            ?>
                            <div class="notification">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                <?php if ($this->session->flashdata('success') == 'add') { ?>
                                <?php
                                /***********
                                 * On successful add, we load a modal that asks if the user wants to select a theme
                                 * which is added at the bottom of template after all scripts are loaded with the
                                 * modal situated at the global modal section of the template
                                 */
                                ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> New Webspace ADDED! Continue edit new webspace below now...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> Webspace information updated...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error') == 'webspace_account_add') { ?>
                                <div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button> There were errors on the form submitted. Please try again.
                                </div>
                                <?php } ?>
                                <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="webspace_status">
                                        <option value="1" <?php echo $this->edit_webspace_details->status === '1' ? 'selected="selected"' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $this->edit_webspace_details->status === '0' ? 'selected="selected"' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <hr /> <!--------------------------------->
                            <div class="form-group">
                                <label class="control-label col-md-3">Webspace Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="webspace_name" data-required="1" class="form-control" value="<?php echo $this->edit_webspace_details->name; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Site Domain
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            www.
                                        </span>
                                        <input type="text" id="domain_name" name="domain_name" data-required="1" class="form-control" value="<?php echo $this->edit_webspace_details->site; ?>" onkeyup="autofillSlug();" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Slug
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" id="webspace_slug" name="webspace_slug" data-required="1" class="form-control" value="<?php echo $this->edit_webspace_details->slug; ?>" readonly tabindex="-1" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Info Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="info_email" data-required="1" class="form-control" value="<?php echo $this->edit_webspace_details->info_email; ?>"> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Ordering
                                </label>
                                <div class="col-md-2">
                                    <input name="seque" type="text" class="form-control" value="<?php echo $this->edit_webspace_details->seque; ?>" /> </div>
                            </div>
                            <!--------------------------------->
                            <h3 class="form-section">Account Info</h3>
                            <?php if ( !$this->edit_webspace_details->has_account) { ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">Account Information
                                </label>
                                <div class="col-md-9">
                                    <span class="help-block text-danger">This webspace is currently not assign to any account or owner.<br />Either add a new account and assign to this webspace, or, select from existing accounts.</span>
                                    <div class="row">
                                    <div class="col-md-3">
                                        <div class="btn-group btn-block">
                                            <a href="#modal-add_account" class="btn sbold blue btn-block" data-toggle="modal"> Add a New Account
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#modal-select_account" class="btn default btn-block" data-toggle="modal"> Select Account
                                        </a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">Owner Name
                                </label>
                                <div class="col-md-4">
                                    <input name="owner_name" type="text" class="form-control" value="<?php echo $this->edit_webspace_details->owner; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Owner Email
                                </label>
                                <div class="col-md-4">
                                    <input name="owner_email" type="email" class="form-control" value="<?php echo $this->edit_webspace_details->owner_email; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Account/Company Name
                                </label>
                                <div class="col-md-4">
                                    <input name="company_name" type="text" class="form-control" value="<?php echo $this->edit_webspace_details->company; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts/edit/index/'.$this->edit_webspace_details->account_id); ?>"><em>Edit Account</em></a>
                                </div>
                            </div>
                            <?php } ?>
                            <!--------------------------------->
                            <h3 class="form-section">Webspace Meta</h3>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Title</label>
                                <div class="col-md-4">
                                    <input name="site_title" type="text" class="form-control" value="<?php echo $this->edit_webspace_details->site_title; ?>" />
                                    <cite class="help-block small">Short title shown on the browser tab</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Tagline</label>
                                <div class="col-md-4">
                                    <input name="site_tagline" type="text" class="form-control" value="<?php echo $this->edit_webspace_details->site_tagline; ?>" />
                                    <cite class="help-block small">Additional short text shown on the browser tab and sometimes used as a header text</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Description</label>
                                <div class="col-md-6">
                                    <textarea name="site_description" rows="3" class="form-control"><?php echo $this->edit_webspace_details->site_description; ?></textarea>
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Keywords</label>
                                <div class="col-md-6">
                                    <textarea name="site_keywords" rows="2" class="form-control"><?php echo $this->edit_webspace_details->site_keywords; ?></textarea>
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Alttags</label>
                                <div class="col-md-4">
                                    <input name="site_alttags" type="text" class="form-control" value="<?php echo $this->edit_webspace_details->site_alttags; ?>" />
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Footer Text</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="site_footer" rows="2" placeholder="Site footer text..."><?php echo $this->edit_webspace_details->site_footer; ?></textarea>
                                    <cite class="help-block small">Text that can be shown at the bottom before the copyright section of the footer and on all pages</cite>
                                </div>
                            </div>
                            <!--------------------------------->
                            <h3 class="form-section">Webspace Options</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Type of Site
                                    <?php if ( ! @$admin) { ?>
                                    <a href="#contact_admin" class="tooltips" data-toggle="modal" data-original-title="Please contact admin to edit this." style="position:relative;top:-5px;"><i class="fa fa-question-circle"></i></a>
                                    <?php } ?>
                                </label>
                                <div class="col-md-4">
                                    <?php if ( ! @$admin) { ?>
                                    <input type="hidden" name="options[site_type]" value="<?php echo @$this->edit_webspace_details->options['site_type']; ?>" />
                                    <?php } ?>
                                    <select class="form-control bs-select" name="options[site_type]" id="site_type" <?php echo @$admin ? '' : 'disabled'; ?>>
                                        <option value=""> Select... </option>
                                        <option value="sal_site" <?php echo @$this->edit_webspace_details->options['site_type'] === 'sal_site' ? 'selected="selected"' : ''; ?>>Stand Alone Site</option>
                                        <option value="hub_site" <?php echo @$this->edit_webspace_details->options['site_type'] === 'hub_site' ? 'selected="selected"' : ''; ?>>Hub Site</option>
                                        <option value="sat_site" <?php echo @$this->edit_webspace_details->options['site_type'] === 'sat_site' ? 'selected="selected"' : ''; ?>>Satellite Site</option>
                                    </select>
                                    <cite class="help-block small">HUB sites house multiple designers with or without SATELLITE sites.<br />SATELLITE sites is always linked up with a HUB site.<br />STAND ALONE as the name implies does not depend on any HUB site nor SATELLITE sites.</cite>
                                </div>
                            </div>
                            <?php
                            /***********
                             * It is presumed that when a satellite site is being setup, a hub site is already identified
                             * through the assigned database, therefore, making this essentially just a single option
                             */
                            ?>
                            <div class="form-group" id="hub_site_list" style="<?php echo @$this->edit_webspace_details->options['parent_site'] ? '' : 'display:none;'; ?>">
                                <label class="control-label col-md-3">Hub Site
                                    <?php if ( ! @$admin) { ?>
                                    <a href="#contact_admin" class="tooltips" data-toggle="modal" data-original-title="Please contact admin to edit this." style="position:relative;top:-5px;"><i class="fa fa-question-circle"></i></a>
                                    <?php } ?>
                                </label>
                                <div class="col-md-4">

                                    <?php if ( ! @$admin) { ?>
                                    <input type="hidden" name="options[parent_site]" value="<?php echo @$this->edit_webspace_details->options['parent_site']; ?>" />
                                    <?php } ?>

                                    <?php if ($hub_sites) { ?>

                                    <select class="form-control bs-select" name="options[parent_site]" data-show-subtext="true" <?php echo @$admin ? '' : 'disabled'; ?>>
                                        <option value=""> Select... </option>
                                        <?php foreach ($hub_sites as $hub_site) { ?>
                                        <option value="<?php echo $hub_site->webspace_id; ?>" <?php echo $hub_site->webspace_id === @$this->edit_webspace_details->options['parent_site'] ? 'selected="selected"' : ''; ?> data-subtext="<cite> &nbsp; <?php echo $hub_site->domain_name; ?></cite>"><?php echo $hub_site->webspace_name; ?></option>
                                        <?php } ?>
                                    </select>
                                        <?php if (@$this->edit_webspace_details->options['parent_site']) { ?>
                                    <cite class="help-block small">Linked hub site.</cite>
                                        <?php } else { ?>
                                    <cite class="help-block small">Available hub sites found on server.</cite>
                                        <?php } ?>

                                    <?php } else { // this 'else' serves only as a fail safe... ?>

                                    <cite class="help-block small">There are currently no hub sites found on this server. Set webspace to a Stand Alone site temporarily. This can be change later.</cite>

                                    <?php } ?>

                                </div>
                            </div>
                            <?php
                            /***********
                             * When site is a hub site, we will need to identify a primary designer
                             */
                            ?>
                            <div class="form-group" id="primary_designer_list" style="<?php echo @$this->edit_webspace_details->options['site_type'] == 'hub_site' ? '' : 'display:none;'; ?>">
                                <label class="control-label col-md-3">Primary Designer
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="options[primary_designer]">
                                        <option value=""> Select... </option>

                                        <?php if ($designers) { ?>
                                            <?php foreach ($designers as $designer) { ?>
                                                <?php if ($designer->url_structure !== $this->edit_webspace_details->slug) { ?>

                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo $designer->url_structure === @$this->edit_webspace_details->options['primary_designer'] ? 'selected="selected"' : ''; ?>><?php echo $designer->designer; ?></option>

                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else echo '<option value="">Boom</option>'; ?>

                                    </select>
                                    <cite class="help-block small">Set primary designer for hub sites</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Theme
                                </label>
                                <div class="col-md-9">
                                    <div class="m-grid m-grid-responsive-md">
                                        <div class="thumbnail m-grid-row mt-element-overlay" style="display:inline-block;margin-bottom:10px;">
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center" style="position:relative;width:300px;height:300px;background-color:#eee;">
                                                <?php
                                                /******
                                                 * When there is an image, the span is hidden automatically
                                                 * Else, it will show
                                                 */
                                                ?>
                                                <a id="click_to_select_theme" class="select_theme" href="#modal-themes" data-toggle="modal" style="display:none;cursor:pointer;opacity:0.4;">Select theme</a>
                                                <?php if (@$this->edit_webspace_details->options['theme']) { ?>
                                                <div class="mt-overlay-4">
                                                <?php } ?>
                                                    <img src="<?php echo base_url().'assets/themes/'.@$this->edit_webspace_details->options['theme'].'/screenshot.jpg'; ?>" width="300" class="select_theme" href="#modal-select_theme" data-toggle="modal" onerror="this.onerror=null;this.style.display='none';document.getElementById('click_to_select_theme').style.display='block';" />
                                                    <div class="mt-overlay">
                                                        <h2><?php echo ucfirst(@$this->edit_webspace_details->options['theme']); ?></h2>
                                                    </div>
                                                <?php if (@$this->edit_webspace_details->options['theme']) { ?>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <input name="options[theme]" type="hidden" class="form-control input-small" value="<?php echo @$this->edit_webspace_details->options['theme']; ?>" />
                                    <a href="#modal-themes" data-toggle="modal" ><em><?php echo @$this->edit_webspace_details->options['theme'] ? 'Change theme' : 'Select theme'; ?></em></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Home Page
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="options[set_as_home_page]">
                                        <option value="index" <?php echo @$this->webspace_details->options['set_as_home_page'] === 'index' ? 'selected="selected"' : ''; ?>>Index</option>
                                        <option value="product_categories" <?php echo @$this->webspace_details->options['set_as_home_page'] === 'product_categories' ? 'selected="selected"' : ''; ?>>Product Categories</option>
                                    </select>
                                    <cite class="help-block small">Set your home page view here</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Product Items Per Page
                                </label>
                                <div class="col-md-4">
                                    <input name="options[items_per_page]" type="text" class="form-control input-small" value="<?php echo @$this->edit_webspace_details->options['items_per_page']; ?>" />
                                    <cite class="help-block small">Number of thumbs on product listing pages</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Wholesale Only Site
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control selectpicker" name="options[wholesale_only_site]">
                                        <option value="0" <?php echo @$this->edit_webspace_details->options['wholesale_only_site'] == '0' ? 'selected="selected"' : ''; ?>>
                                            No, products can be accessed by anyone</option>
                                        <option value="1" <?php echo @$this->edit_webspace_details->options['wholesale_only_site'] == '1' ? 'selected="selected"' : ''; ?>>
                                            Yes, product access only by wholesale</option>
                                    </select>
                                    <cite class="help-block small">Set webspace as wholesale site access only</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Product Size Mode
                                </label>
                                <div class="col-md-4">

                                    <div class="mt-radio-list">
                                        <label class="mt-radio mt-radio-outline">
                                            <input type="radio" name="options[size_mode]" value="1" <?php echo @$this->edit_webspace_details->options['size_mode'] == '1' ? 'checked="checked"' : ''; ?> />
                                            Mode A: 0,2,4,6,8,10,...,22
                                            <span></span>
                                        </label>
                                        <label class="mt-radio mt-radio-outline">
                                            <input type="radio" name="options[size_mode]" value="0" <?php echo @$this->edit_webspace_details->options['size_mode'] == '0' ? 'checked="checked"' : ''; ?> />
                                            Mode B: S,M,L,XL,XXL
                                            <span></span>
                                        </label>
                                        <label class="mt-radio mt-radio-outline">
                                            <input type="radio" name="options[size_mode]" value="2" <?php echo @$this->edit_webspace_details->options['size_mode'] == '2' ? 'checked="checked"' : ''; ?> />
                                            Mode C: Pre-packed (1S-2M-2L-1XL)
                                            <span></span>
                                        </label>
                                        <label class="mt-radio mt-radio-outline">
                                            <input type="radio" name="options[size_mode]" value="3" <?php echo @$this->edit_webspace_details->options['size_mode'] == '3' ? 'checked="checked"' : ''; ?> />
                                            Mode D: S-M, M-L
                                            <span></span>
                                        </label>
                                        <label class="mt-radio mt-radio-outline">
                                            <input type="radio" name="options[size_mode]" value="4" <?php echo @$this->edit_webspace_details->options['size_mode'] == '4' ? 'checked="checked"' : ''; ?> />
                                            Mode E: One Size Fits All
                                            <span></span>
                                        </label>
                                        <!--
                                        <label class="mt-radio mt-radio-outline mt-radio-disabled">
                                            <input type="radio" disabled> Disabled
                                            <span></span>
                                        </label>
                                    -->
                                    </div>

                                    <cite class="help-block small">Product type of sizing</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Show Product Price
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control selectpicker" id="show_product_price" name="options[show_product_price]">
                                        <option value=""> Select... </option>
                                        <option value="1" <?php echo @$this->edit_webspace_details->options['show_product_price'] == '1' ? 'selected="selected"' : ''; ?>>
                                            Yes, show product price.</option>
                                        <option value="0" <?php echo @$this->edit_webspace_details->options['show_product_price'] == '0' ? 'selected="selected"' : ''; ?>>
                                            No, show "CLICK HERE FOR PRICING" link.</option>
                                    </select>
                                    <cite class="help-block small">Either show the product price, or, show a link notice on how to order inquiry</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NY State Sales Tax
                                </label>
                                <div class="col-md-4">
                                    <input name="options[ny_sales_tax]" type="text" class="form-control input-small" value="<?php echo @$this->edit_webspace_details->options['ny_sales_tax']; ?>" />
                                    <cite class="help-block small">... where applicable</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Google Tracking Code</label>
                                <div class="col-md-6">
                                    <textarea name="options[google_analtyics]" rows="7" class="form-control" style="font-size:0.8em;"><?php echo @$this->edit_webspace_details->options['google_analtyics']; ?></textarea>
                                    <cite class="help-block small">Paste Google Analytics tracking code without the script tags</cite>
                                </div>
                            </div>
                            <!--------------------------------->
                        </div>

                        <hr />
                        <div class="form-actions botom">
                            <div class="row">
                                <label class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces/add'); ?>" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-98"> Add a New Webspace
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <!-- DOC: Remove "hide" class to enable the reset button -->
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                    <div class="btn-group dropup">
                                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        <ul class="dropdown-menu">

                                            <?php if ($webspaces) { ?>

                                                <?php foreach ($webspaces as $webspace) {
                                                    if (
                                                        $webspace->webspace_id !== $this->edit_webspace_details->id
                                                        && $webspace->webspace_name != ''
                                                    ) { ?>

                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces/edit/index/'.$webspace->webspace_id); ?>" onclick="$('#loading').modal('show');">
                                                <?php echo $webspace->webspace_name; ?></a>
                                            </li>

                                                    <?php }
                                                } ?>

                                            <li class="divider"> </li>
                                            <li>
                                                <a href="javascript:;"> <cite>Switch webspaces...</cite>
                                                </a>
                                            </li>

                                            <?php } else { ?>

                                            <li>
                                                <a href="javascript:;"> No other webspaces...
                                                </a>
                                            </li>

                                            <?php } ?>

                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-offset-3 col-md-9">
                                    <br />
                                    <a data-toggle="modal" href="#delete-<?php echo $this->edit_webspace_details->id; ?>"><em>Delete Permanently</em></a>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- END FORM ===================================================================-->
                    <!-- END FORM-->

                    <!-- DELETE ITEM -->
                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $this->edit_webspace_details->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Warning!</h4>
                                </div>
                                <div class="modal-body"> Permanently DELETE item? <br /> This cannot be undone! </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces/delete/index/'.$this->edit_webspace_details->id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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

                    <!-- SELECT/ACTIVATE THEMES -->
                    <div class="modal fade" id="modal-themes" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Select and Activate Themes</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <div class="portlet light portlet-fit bordered mt-element-ribbon">
                                                <?php if (@$this->edit_webspace_details->options['theme'] === 'roden2') { ?>
                                                <div class="ribbon ribbon-right ribbon-clip ribbon-shadow ribbon-round ribbon-border-dash-hor ribbon-color-danger uppercase">
                                                    <div class="ribbon-sub ribbon-clip ribbon-right"></div>
                                                    Active </div>
                                                <?php } ?>
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class="fa fa-paint-brush font-blue"></i>
                                                        <span class="caption-subject font-blue bold uppercase">Roden 2</span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="mt-element-overlay">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mt-overlay-4">
                                                                    <img src="<?php echo base_url(); ?>assets/themes/roden2/screenshot.jpg">
                                                                    <div class="mt-overlay">
                                                                        <h2>Roden 2</h2>
                                                                        <?php if (@$this->edit_webspace_details->options['theme'] !== 'roden2') { ?>
                                                                        <a class="mt-info btn default btn-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces/edit/theme_activate/'.$this->edit_webspace_details->id.'/roden2'); ?>" onclick="$('#modal-themes').modal('hide');$('#loading').modal('show');">Activate Theme</a>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <h2>More themes to come...</h2>
                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <!-- ADD ACCOUNT -->
                    <div class="modal fade bs-modal-lg" id="modal-add_account" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open($this->config->slash_item('admin_folder').'webspaces/account/add/'.$this->edit_webspace_details->id, array('class'=>'form-horizontal', 'id'=>'form-webspace_account_add')); ?>

                                    <input type="hidden" name="account_add_from" value="webspace_edit" />

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add New Account and Assign to <?php echo $this->edit_webspace_details->name; ?>!</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-body">

                                            <?php
                                            /***********
                                             * Noification area
                                             */
                                            ?>
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                            <div class="alert alert-success display-hide">
                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                            <?php if (validation_errors()) { ?>
                                            <div class="alert alert-danger">
                                                <button class="close" data-close="alert"></button> There were errors in the form. Please try again...
                                            </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Status
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control bs-select" name="account_status">
                                                        <option value="1" <?php echo set_select('account_status', '1', TRUE); ?>>Active</option>
                                                        <option value="0" <?php echo set_select('account_status', '0'); ?>>Inactive</option>
                                                    </select>
                                                    <span class="help-block"> By default, new account is always active. </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Industry
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control bs-select" name="industry">
                                                        <option value="fashion" <?php echo set_select('industry', 'fashion', TRUE); ?>>Fashion</option>
                                                        <option value="home" <?php echo set_select('industry', 'home'); ?>>Home</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Account/Company Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="company_name" data-required="1" class="form-control" value="<?php echo set_value('company_name'); ?>" />
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('company_name'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Owner Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input name="owner_name" type="text" data-require="1" class="form-control" value="<?php echo set_value('owner_name'); ?>" />
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('owner_name'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Owner Email
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input name="owner_email" type="email" data-required="1" class="form-control" value="<?php echo set_value('owner_email'); ?>" />
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('owner_email'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Address 1
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input name="address1" type="text" class="form-control" value="<?php echo set_value('address1'); ?>" />
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('address1'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Address 2
                                                </label>
                                                <div class="col-md-4">
                                                    <input name="address2" type="text" class="form-control" value="<?php echo set_value('address2'); ?>" /> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">City
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input name="city" type="text" class="form-control" value="<?php echo set_value('city'); ?>" />
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('city'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">State
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="bs-select form-control" data-live-search="true" data-size="8" tabindex="-98" name="state">
                                                        <option value="">Select...</option>
                                                        <?php foreach (list_states() as $state) { ?>
                                                        <option value="<?php echo $state->abb; ?>" <?php echo set_select('state', $state->abb); ?>><?php echo $state->state_name.' ('.$state->abb.')'; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('state'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Country
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="bootstrap-select bs-select form-control" data-live-search="true" data-size="8" tabindex="-98" name="country">
                                                        <option value="">Select...</option>
                                                        <?php foreach (list_countries() as $country) { ?>
                                                        <option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('country'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Zip Code
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input name="zip" type="text" class="form-control" value="<?php echo set_value('zip'); ?>" />
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('zip'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Phone
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input name="phone" type="text" class="form-control" value="<?php echo set_value('phone'); ?>" />
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('phone'); ?> </cite></span>
                                            </div>
                                            <hr />
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Password
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="password" id="password" name="password" class="form-control" />
                                                </div>
                                                <span class="help-block font-red-mint"><cite> <?php echo form_error('password'); ?> </cite></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Confirm Password
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="password" name="passconf" class="form-control" /> </div>
                                                    <span class="help-block"> Re-type your password here </span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
                                            <span class="ladda-label">Add and Assign?</span>
                                            <span class="ladda-spinner"></span>
                                        </a>
                                    </div>

                                </form>
                                <!-- END FORM ===================================================================-->
                                <!-- END FORM-->

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <!-- DELETE ITEM -->
                    <div class="modal fade bs-modal-md" id="modal-select_account" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open($this->config->slash_item('admin_folder').'webspaces/account/linkme/'.$this->edit_webspace_details->id, array('class'=>'form-horizontal', 'id'=>'form-webspace_account_link')); ?>

                                <input type="hidden" name="account_link_from" value="webspace_edit" />

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Select an Account and assign to <?php echo $this->edit_webspace_details->name; ?>!</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Select Account
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-9">
                                                <select class="form-control bs-select" name="account_id" data-live-search="true" data-size="8" tabindex="-98">
                                                    <option value="">Select...</option>
                                                    <?php foreach ($accounts_list as $account) { ?>
                                                    <option value="<?php echo $account->account_id; ?>" <?php echo set_select('account_id', $account->account_id); ?>><?php echo $account->company_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <cite class="help-block small">This Account will server as the owner of the webspace</cite>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
                                        <span class="ladda-label">Link Account?</span>
                                        <span class="ladda-spinner"></span>
                                    </a>
                                </div>

                                </form>
                                <!-- END FORM ===================================================================-->
                                <!-- END FORM-->

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
