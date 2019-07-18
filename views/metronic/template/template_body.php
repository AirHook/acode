                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container">

                                    <!-- BEGIN PAGE BREADCRUMBS -->
									<?php $this->load->view('metronic/template/template_breadcrumb'); ?>
                                    <!-- END PAGE BREADCRUMBS -->

                                    <?php
                                    /***********
                                     *	Notifications
                                     */
                                    ?>
                                    <div class="notifcations">

                                        <?php
                                        /**********
                                         * At the sales package thumbs page
                                         */
                                        ?>
                                        <?php
                                        if (
                                            @$view_pane === 'thumbs_list_sales_pacakge'
                                            && $this->session->userdata('sales_package')
                                            && $this->session->userdata('sales_package_tc')
                                            && $this->session->userdata('sales_package_id')
                                        )
                                        { ?>

                                        <div class="alert alert-info text-center">
                                            Hi <?php echo @$this->wholesale_user_details->fname; ?>,<br />
                                            Welcome to your sales pacakge with several new designs for your review.<br />
                                            Please respond with items of interest for your stores.
                                        </div>

                                            <?php
                                        }
                                        elseif (
                                            $this->session->user_loggedin
                                            && $this->session->userdata('user_cat') == 'wholesale'
                                            && $this->session->userdata('sales_package')
                                            && $this->session->userdata('sales_package_tc')
                                            && $this->session->userdata('sales_package_id')
                                            && $this->uri->segment(1) !== 'account'
                                        )
                                        { ?>

                                        <div class="alert alert-info text-center">
                                            Click <a href="<?php echo site_url('sales_package/link/index/'.$this->session->userdata('sales_package_id').'/'.$this->session->userdata('user_id').'/'.$this->session->userdata('sales_package_tc')); ?>">here</a> to view your sales package.
                                        </div>

                                            <?php
                                        } ?>

                                    </div>

                                    <!-- BEGIN PAGE CONTENT INNER -->
									<?php $this->load->view('metronic/'.(@$file ?: 'blank_page')); ?>
                                    <!-- END PAGE CONTENT INNER -->

                                </div>
                            </div>
                            <!-- END PAGE CONTENT BODY -->
