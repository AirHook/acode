                    <div class="row">

                        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/dcn_sidebar'); ?>

                        <div class="col-md-9">

                            <!-- BEGIN FORM-->
                            <!-- FORM =======================================================================-->
                            <?php echo form_open(
                                'admin/dcn/create',
                                array(
                                    'id' => 'form-dcn_create'
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
                                        <span class="required"> * </span>
                                    </label>
                                    <input type="text" name="title" data-required="1" class="form-control" value="" />
                                    <cite class="help-block small hide"> Permalink: <?php echo base_url(); ?>dcn/this_page.html </cite>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> Contents
                                    </label>
                                    <textarea name="contents" class="form-control summernote" id="summernote_1" data-error-container="email_message_error"></textarea>
                                    <cite class="help-block small"> </cite>
                                    <div id="email_message_error"> </div>
                                </div>

                                <button type="submit" class="btn dark">Submit</button>

                            </div>

                            <?php echo form_close(); ?>
                            <!-- End FORM ===================================================================-->
                            <!-- END FORM-->

                        </div>

                    </div>
