                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'webspaces/add',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-webspace_add'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                            <?php if ($this->session->flashdata('success') == 'add') { ?>
                            <div class="alert alert-success auto-remove">
                                <button class="close" data-close="alert"></button> New Webspace ADDED! Continue edit new webspace below now...
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('success') == 'edit') { ?>
                            <div class="alert alert-success auto-remove">
                                <button class="close" data-close="alert"></button> Webspace information updated...
                            </div>
                            <?php } ?>
                            <?php if (validation_errors()) { ?>
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                            </div>
                            <?php } ?>

                            <div class="form-group">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="webspace_status">
                                        <option value="1" <?php echo set_select('webspace_status', '1', TRUE); ?>>Active</option>
                                        <option value="0" <?php echo set_select('webspace_status', '0'); ?>>Inactive</option>
                                    </select>
                                    <cite class="help-block small"> By default, new account is alwys active. </cite>
                                </div>
                            </div>
                            <hr /> <!--------------------------------->
                            <div class="form-group">
                                <label class="control-label col-md-3">Webspace Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="webspace_name" data-required="1" class="form-control" value="<?php echo set_value('webspace_name'); ?>" />
                                    <cite class="help-block small"> Accepted TLD's are .com &amp; .net </cite>
                                </div>
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
                                        <input type="text" id="domain_name" name="domain_name" data-required="1" class="form-control" value="<?php echo set_value('domain_name'); ?>" onkeyup="autofillSlug();" />
                                    </div>
                                    <cite class="help-block small"> Accepted TLD's are .com &amp; .net </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Slug
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" id="webspace_slug" name="webspace_slug" data-required="1" class="form-control" value="<?php echo set_value('webspace_slug'); ?>" readonly tabindex="-1" />
                                </div>
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
                                        <input type="email" name="info_email" data-required="1" class="form-control" value="<?php echo set_value('info_email'); ?>">
                                    </div>
                                    <cite class="help-block small">Website contant and info email</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Select Account
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="account_id" data-live-search="true" data-size="8" tabindex="-98">
                                        <option value="">Select...</option>
                                        <?php foreach ($accounts_list as $account) { ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo set_select('account_id', $account->account_id); ?>><?php echo $account->company_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <cite class="help-block small">Account owner of the webspace</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Ordering
                                </label>
                                <div class="col-md-2">
                                    <input name="seque" type="text" class="form-control" value="<?php echo $this->webspace_details->seque; ?>" /> </div>
                            </div>
                            <!--------------------------------->
                            <h3 class="form-section">Webspace Meta</h3>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Title</label>
                                <div class="col-md-4">
                                    <input name="site_title" type="text" class="form-control" value="<?php echo set_value('site_title'); ?>" />
                                    <cite class="help-block small">Short title shown on the browser tab</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Tagline</label>
                                <div class="col-md-4">
                                    <input name="site_tagline" type="text" class="form-control" value="<?php echo set_value('site_tagline'); ?>" />
                                    <cite class="help-block small">Additional short text shown on the browser tab and sometimes used as a header text</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Description</label>
                                <div class="col-md-4">
                                    <textarea name="site_description" rows="3" class="form-control"><?php echo set_value('site_description'); ?></textarea>
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Keywords</label>
                                <div class="col-md-4">
                                    <textarea name="site_keywords" rows="2" class="form-control"><?php echo set_value('site_keywords'); ?></textarea>
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Alttags</label>
                                <div class="col-md-4">
                                    <input name="site_alttags" type="text" class="form-control" value="<?php echo set_value('site_alttags'); ?>" />
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Footer Text</label>
                                <div class="col-md-4">
                                    <input name="site_footer" type="text" class="form-control" value="<?php echo set_value('site_footer'); ?>" />
                                    <cite class="help-block small">Text that can be shown at the bottom before the copyright section of the footer and on all pages</cite>
                                </div>
                            </div>
                            <!--------------------------------->
                            <h3 class="form-section">Webspace Options</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Type of Site
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="options[site_type]" id="site_type">
                                        <option value="hub_site" <?php echo set_select('options[site_type]', 'hub_site'); ?>>Hub Site</option>
                                        <option value="sat_site" <?php echo set_select('options[site_type]', 'sat_site'); ?>>Satellite Site</option>
                                        <option value="sal_site" <?php echo set_select('options[site_type]', 'sal_site', TRUE); ?>>Stand Alone Site</option>
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
                            <div class="form-group" id="hub_site_list" style="display:none;">
                                <label class="control-label col-md-3">Hub Site
                                </label>
                                <div class="col-md-4">
                                    <?php if ($webspaces) { ?>
                                    <select class="form-control bs-select" name="options[parent_site]" data-show-subtext="true">
                                        <?php foreach ($webspaces as $webspace) { ?>
                                        <option value="<?php echo $webspace->webspace_id; ?>" <?php echo set_select('options[parent_site]', $webspace->webspace_id); ?> data-subtext="<cite> &nbsp; <?php echo $webspace->domain_name; ?></cite>"><?php echo $webspace->webspace_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <cite class="help-block small">Available hub sites found on server.</cite>
                                    <?php } else { // this 'else' serves only as a fail safe... ?>
                                    <cite class="help-block small">There are currently no hub sites found on this server. Set webspace to a Stand Alone site temporarily. This can be change later.</cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Home Page
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="options[set_as_home_page]">
                                        <option value="index" <?php echo set_select('options[set_as_home_page]', 'index', TRUE); ?>>Index</option>
                                        <option value="product_categories" <?php echo set_select('options[set_as_home_page]', 'product_categories'); ?>>Product Categories</option>
                                    </select>
                                    <cite class="help-block small">Set your home page view here</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Product Items Per Page
                                </label>
                                <div class="col-md-4">
                                    <input name="options[items_per_page]" type="text" class="form-control input-small" value="<?php echo set_value("options['items_per_page']"); ?>" />
                                    <cite class="help-block small">Number of thumbs on product listing pages</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Wholesale Only Site
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control selectpicker" id="size_mode" name="options[wholesale_only_site]">
                                        <option value="0" <?php echo set_select('options[wholesale_only_site]', 0); ?>>
                                            No, products can be accessed by anyone</option>
                                        <option value="1" <?php echo set_select('options[wholesale_only_site]', 1); ?>>
                                            Yes, product access only by wholesale</option>
                                    </select>
                                    <cite class="help-block small">Set webspace as wholesale site access only</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Product Size Mode
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control selectpicker" id="size_mode" name="options[size_mode]">
                                        <option value=""> Select... </option>
                                        <option value="1" <?php echo set_select('options[size_mode]', 1); ?>>
                                            Mode A: 0,2,4,6,8,10,...,22</option>
                                        <option value="0" <?php echo set_select('options[size_mode]', 0); ?>>
                                            Mode B: S,M,L,XL,XXL</option>
                                        <option value="2" <?php echo set_select('options[size_mode]', 2); ?>>
                                            Mode C: Pre-packed (1S-2M-2L-1XL)</option>
                                    </select>
                                    <cite class="help-block small">Product type of sizing</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Show Product Price
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control selectpicker" id="show_product_price" name="options[show_product_price]">
                                        <option value=""> Select... </option>
                                        <option value="1" <?php echo set_select('options[show_product_price]', 1); ?>>
                                            Yes, show product price.</option>
                                        <option value="0" <?php echo set_select('options[show_product_price]', 0); ?>>
                                            No, show "CLICK HERE FOR PRICING" link.</option>
                                    </select>
                                    <cite class="help-block small">Either show the product price, or, show a link notice on how to order inquiry</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NY State Sales Tax
                                </label>
                                <div class="col-md-4">
                                    <input name="options[ny_sales_tax]" type="text" class="form-control input-small" value="<?php echo set_value("options['ny_sales_tax']"); ?>" />
                                    <cite class="help-block small">... where applicable</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Google Tracking Code</label>
                                <div class="col-md-6">
                                    <textarea name="options[google_analtyics]" rows="5" class="form-control text-xsmall"><?php echo set_value("options['google_analtyics']"); ?></textarea>
                                    <cite class="help-block small">Paste Google Analytics tracking code without the script tags</cite>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-actions bottom">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->

        			<script>
        				function autofillSlug(){
        					//autofill webspace slug from domain name
        					$('#domain_name').keyup(function(){
        						text = this.value;
        						text = text.replace('-', '');
        						text = text.replace('_', '');
        						if (text.search(/\./) == -1) {
        							$('#webspace_slug').val(text);
        						} else {
        							text = text.split('.');
        							if (text.length > 0) text.pop();
        							$('#webspace_slug').val(text);
        						}
        					});
        					$('#domain_name').blur(function(){
        						text = this.value;
        						text = text.replace('-', '');
        						text = text.replace('_', '');
        						if (text.search(/\./) == -1) {
        							$('#webspace_slug').val(text);
        						} else {
        							text = text.split('.');
        							if (text.length > 0) text.pop();
        							$('#webspace_slug').val(text);
        						}
        					});
        				}
        			</script>
