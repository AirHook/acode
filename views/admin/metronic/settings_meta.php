                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open($this->config->slash_item('admin_folder').'settings/meta', array('class'=>'form-horizontal', 'id'=>'form-settings_meta')); ?>

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
                                <label class="col-md-3 control-label">Site Title</label>
                                <div class="col-md-4">
                                    <input name="site_title" type="text" class="form-control" value="<?php echo $this->webspace_details->site_title; ?>" />
                                    <cite class="help-block small">Short title shown on the browser tab</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Tagline</label>
                                <div class="col-md-4">
                                    <input name="site_tagline" type="text" class="form-control" value="<?php echo $this->webspace_details->site_tagline; ?>" />
                                    <cite class="help-block small">Additional short text shown on the browser tab and sometimes used as a header text</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Description</label>
                                <div class="col-md-6">
                                    <textarea name="site_description" rows="3" class="form-control" placeholder="Site description..."><?php echo $this->webspace_details->site_description; ?></textarea>
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Keywords</label>
                                <div class="col-md-6">
                                    <textarea name="site_keywords" rows="2" class="form-control" placeholder="Site keywords..."><?php echo $this->webspace_details->site_keywords; ?></textarea>
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Alttags</label>
                                <div class="col-md-4">
                                    <input name="site_alttags" type="text" class="form-control" value="<?php echo $this->webspace_details->site_alttags; ?>" />
                                    <cite class="help-block small">Meta informtion for SEO purposes</cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site Footer Text</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="site_footer" rows="2" placeholder="Site footer text..."><?php echo $this->webspace_details->site_footer; ?></textarea>
                                    <cite class="help-block small">Text that can be shown at the bottom before the copyright section of the footer and on all pages</cite>
                                </div>
                            </div>
                            <!--------------------------------->
                            <div class="row">
                                <div class="col-md-offset-3 col-md-2">
                                    <button type="submit" class="btn red-flamingo btn-block">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
