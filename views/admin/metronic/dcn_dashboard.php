                    <!-- BEGIN PAGE CONTENT BODY -->
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
                        <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> An error occured. Please try again.
                        </div>
                        <?php } ?>
                    </div>

                    <div class="note note-default" style="padding:0px;border-left:none;">
                        <h3>Documentation</h3>
                        <p> Click on any available topic on the side to view the documentation. </p>
                        <p> To create a know documentation or knowledge base, click <a href="<?php echo site_url('admin/dcn/create'); ?>">here</a>. </p>
                    </div>
                    <!-- END PAGE CONTENT BODY -->

                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
