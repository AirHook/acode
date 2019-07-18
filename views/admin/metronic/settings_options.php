                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open($this->config->slash_item('admin_folder').'settings/options/'.(@$admin ?: ''), array('class'=>'form-horizontal', 'id'=>'form-settings_options')); ?>

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
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Type of Site
                                    <?php if ( ! @$admin) { ?>
                                    <a href="#contact_admin" class="tooltips" data-toggle="modal" data-original-title="Please contact admin to edit this." style="position:relative;top:-5px;"><i class="fa fa-question-circle"></i></a>
                                    <?php } ?>
                                </label>
                                <div class="col-md-4">
                                    <?php if ( ! @$admin) { ?>
                                    <input type="hidden" name="options[site_type]" value="<?php echo @$this->webspace_details->options['site_type']; ?>" />
                                    <?php } ?>
                                    <select class="form-control bs-select" name="options[site_type]" id="site_type" <?php echo @$admin ? '' : 'disabled'; ?>>
                                        <option value="">Select...</option>
                                        <option value="hub_site" <?php echo @$this->webspace_details->options['site_type'] === 'hub_site' ? 'selected="selected"' : ''; ?>>Hub Site</option>
                                        <option value="sat_site" <?php echo @$this->webspace_details->options['site_type'] === 'sat_site' ? 'selected="selected"' : ''; ?>>Satellite Site</option>
                                        <option value="sal_site" <?php echo @$this->webspace_details->options['site_type'] === 'sal_site' ? 'selected="selected"' : ''; ?>>Stand Alone Site</option>
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
                            <div class="form-group" id="hub_site_list" style="<?php echo @$this->webspace_details->options['parent_site'] ? '' : 'display:none;'; ?>">
                                <label class="control-label col-md-3">Hub Site
                                </label>
                                <div class="col-md-4">

                                    <?php if ( ! @$admin) { ?>
                                    <input type="hidden" name="options[parent_site]" value="<?php echo @$this->webspace_details->options['parent_site']; ?>" />
                                    <?php } ?>

                                    <?php if ($hub_sites) { ?>

                                    <select class="form-control bs-select" name="options[parent_site]" data-show-subtext="true" <?php echo @$admin ? '' : 'disabled'; ?>>
                                        <option value=""> Select... </option>
                                        <?php foreach ($hub_sites as $hub_site) { ?>
                                        <option value="<?php echo $hub_site->webspace_id; ?>" <?php echo @$this->webspace_details->options['parent_site'] == $hub_site->webspace_id ? 'selected="selected"' : ''; ?> data-subtext="<cite> &nbsp; <?php echo $hub_site->domain_name; ?></cite>"><?php echo $hub_site->webspace_name; ?></option>
                                        <?php } ?>
                                    </select>
                                        <?php if (@$this->webspace_details->options['parent_site']) { ?>
                                    <cite class="help-block small">Linked hub site.</cite>
                                        <?php } else { ?>
                                    <cite class="help-block small">Available hub sites found on server.</cite>
                                        <?php } ?>

                                    <?php } else { // this 'else' serves only as a fail safe... ?>

                                    <cite class="help-block small">There are currently no hub sites found on this server. Set webspace to a Stand Alone site temporarily. This can be change later.</cite>

                                    <?php } ?>

                                </div>
                                <?php if ( ! @$admin) { ?>
                                <a href="#contact_admin" class="tooltips" data-toggle="modal" data-original-title="Please contact admin about this."><i class="fa fa-question-circle"></i></a>
                                <?php } ?>
                            </div>
                            <?php
                            /***********
                             * When site is a hub site, we will need to identify a primary designer
                             */
                            ?>
                            <div class="form-group" id="primary_designer_list" style="<?php echo @$this->webspace_details->options['site_type'] == 'hub_site' ? '' : 'display:none;'; ?>">
                                <label class="control-label col-md-3">Primary Designer
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="options[primary_designer]">
                                        <option value=""> Select... </option>

                                        <?php if ($designers) { ?>
                                            <?php foreach ($designers as $designer) { ?>
                                                <?php if ($designer->url_structure !== $this->webspace_details->slug) { ?>

                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo $designer->url_structure === @$this->webspace_details->options['primary_designer'] ? 'selected="selected"' : ''; ?>><?php echo $designer->designer; ?></option>

                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else echo '<option value="">Boom</option>'; ?>

                                    </select>
                                    <cite class="help-block small">Set primary designer for hub sites</cite>
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
                                    <input name="options[items_per_page]" type="text" class="form-control input-small" value="<?php echo @$this->webspace_details->options['items_per_page']; ?>" />
                                    <cite class="help-block small">Number of thumbs on product listing pages</cite>
                                </div>
                            </div>
                            <?php if ($this->webspace_details->options['site_type'] !== 'hub_site') { ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">Wholesale Only Site
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control selectpicker" id="size_mode" name="options[wholesale_only_site]">
                                        <option value="0" <?php echo @$this->webspace_details->options['wholesale_only_site'] == '0' ? 'selected="selected"' : ''; ?>>
                                            No, products can be accessed by anyone</option>
                                        <option value="1" <?php echo @$this->webspace_details->options['wholesale_only_site'] == '1' ? 'selected="selected"' : ''; ?>>
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
                                        <option value="1" <?php echo @$this->webspace_details->options['size_mode'] == '1' ? 'selected="selected"' : ''; ?>>
                                            Mode A: 0,2,4,6,8,10,...,22</option>
                                        <option value="0" <?php echo @$this->webspace_details->options['size_mode'] == '0' ? 'selected="selected"' : ''; ?>>
                                            Mode B: S,M,L,XL,XXL</option>
                                        <option value="2" <?php echo @$this->webspace_details->options['size_mode'] == '2' ? 'selected="selected"' : ''; ?>>
                                            Mode C: Pre-packed (1S-2M-2L-1XL)</option>
                                    </select>
                                    <cite class="help-block small">Product type of sizing</cite>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">Show Product Price
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control selectpicker" id="show_product_price" name="options[show_product_price]">
                                        <option value=""> Select... </option>
                                        <option value="1" <?php echo @$this->webspace_details->options['show_product_price'] == '1' ? 'selected="selected"' : ''; ?>>
                                            Yes, show product price.</option>
                                        <option value="0" <?php echo @$this->webspace_details->options['show_product_price'] == '0' ? 'selected="selected"' : ''; ?>>
                                            No, show "CLICK HERE FOR PRICING" link.</option>
                                    </select>
                                    <cite class="help-block small">Either show the product price, or, show a link notice on how to order inquiry</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NY State Sales Tax
                                </label>
                                <div class="col-md-4">
                                    <input name="options[ny_sales_tax]" type="text" class="form-control input-small" value="<?php echo @$this->webspace_details->options['ny_sales_tax']; ?>" />
                                    <cite class="help-block small">... where applicable</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Google Tracking Code</label>
                                <div class="col-md-6">
                                    <textarea name="options[google_analtyics]" rows="7" class="form-control" style="font-size:0.8em;"><?php echo @$this->webspace_details->options['google_analtyics']; ?></textarea>
                                    <cite class="help-block small">Paste Google Analytics tracking code without the script tags</cite>
                                </div>
                            </div>
                            <!--------------------------------->
                        </div>
                        <div class="form-actions bottom">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-2">
                                    <button type="submit" class="btn red-flamingo btn-block">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
