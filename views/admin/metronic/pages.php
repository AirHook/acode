                    <div class="row">

                        <div class="col-md-2">
                            <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/pages_sidebar'); ?>
                        </div>

                        <div class="col-md-10">

                            <?php
                            if (@$page_details)
                            { ?>

                            <!-- BEGIN FORM-->
                            <!-- FORM =======================================================================-->
                            <?php echo form_open(
                                $this->uri->uri_string(),
                                array(
                                    'id' => 'form-pages_edit'
                                )
                            ); ?>

                            <?php
                            /***********
                             * Noification area
                             */
                            ?>
                            <div>
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="form-body" data-token="<?php echo $this->security->get_csrf_token_name(); ?>" data-hash="<?php echo $this->security->get_csrf_hash(); ?>" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                <div class="form-group">
                                    <label class="control-label"> Page Title
                                        <span class="required hide"> * </span>
                                    </label>
                                    <input type="text" name="title" data-required="1" class="form-control" value="<?php echo @$page_details->page_name; ?>" readonly />
                                    <cite class="help-block small hide"> Permalink: <?php echo base_url(); ?>dcn/this_page.html </cite>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> Contents
                                    </label>
                                    <textarea name="content" class="form-control summernote" id="summernote_1" data-error-container="email_message_error">
                                        <?php echo @$page_details->content; ?>
                                    </textarea>
                                    <cite class="help-block small"> </cite>
                                    <div id="email_message_error"> </div>
                                </div>

                                <button type="submit" class="btn dark">Update</button>

                            </div>

                            <?php echo form_close(); ?>
                            <!-- End FORM ===================================================================-->
                            <!-- END FORM-->

                                <?php
                            }
                            else
                            { ?>

                            <h3><cite>Click on a page to edit</cite></h3>

                                <?php
                            } ?>

                        </div>

                    </div>
