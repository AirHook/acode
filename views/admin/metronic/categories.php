                    <div class="note note-info">
                        <h4 class="block">NOTES:</h4>
                        <p> To be able to show the parent/child tree relationship, sorting is disabled. </p>
                        <p> Sorting priority is by Category Secquence number (see edit category) per parent-child list. Then, by alphabetized order. </p>
                        <p> All inactive/suspended items are at the bottom of the tree list of respective parent. </p>
                    </div>

                    <?php if ($this->webspace_details->options['site_type'] == 'hub_site')
                    { ?>

                    <div class="table-toolbar">
                        <div class="row">

                            <div class="col-md-3 margin-bottom-10">
                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/add'); ?>" class="btn blue btn-block" data-toggle="modal" data-backdrop="static" data-keyboard="false"> Add a New Category
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <select class="bs-select form-control" name="designer" data-live-search="true" data-size="5">
                                    <option value="general_categories" <?php echo $d_url_structure == 'general_categories' ? 'selected' : ''; ?>>
                                        General Categories
                                    </option>
                                    <?php if ($designers) { ?>
                                    <?php foreach ($designers as $designer) { ?>
                                    <?php
                                    if (
                                        $this->webspace_details->options['site_type'] === 'hub_site'
                                        && $designer->url_structure != $this->webspace_details->slug
                                        && $designer->with_products === '1'
                                    )
                                    { ?>
                                    <option value="<?php echo $designer->url_structure; ?>" <?php echo $d_url_structure == $designer->url_structure ? 'selected' : ''; ?>>
                                        <?php echo $designer->designer; ?>
                                    </option>
                                        <?php
                                    } else if (
                                        $this->webspace_details->options['site_type'] !== 'hub_site'
                                        && (
                                            $designer->url_structure === $this->webspace_details->slug
                                            OR $designer->folder === $this->webspace_details->slug  // backwards compatibility for 'basix-black-label'
                                        )
                                        && $designer->with_products === '1'
                                    )
                                    { ?>
                                    <option value="<?php echo $designer->url_structure; ?>" <?php echo $d_url_structure == $designer->url_structure ? 'selected' : ''; ?>>
                                        <?php echo $designer->designer; ?>
                                    </option>
                                        <?php
                                    } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <button class="btn btn-primary hidden-sm hidden-xs" id="filter_categories"> Filter </button>
                            <div class="col-md-12 hidden-lg hidden-md margin-top-10">
                                <button class="btn btn-primary btn-block" id="filter_categories"> Filter </button>
                            </div>

                        </div>
                    </div>

                    <br />

                        <?php
                    } ?>

                    <?php
                    /***********
                     * Notification area
                     */
                    ?>
                    <div class="notifications">
                        <?php if ($this->session->flashdata('success') == 'add') { ?>
                        <div class="alert alert-success auto-remove margin-top-15">
                            <button class="close" data-close="alert"></button> New Category ADDED!
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'edit') { ?>
                        <div class="alert alert-success auto-remove margin-top-15">
                            <button class="close" data-close="alert"></button> Category information updated.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'delete') { ?>
                        <div class="alert alert-success auto-remove margin-top-15">
                            <button class="close" data-close="alert"></button> Category permanently removed from records.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                        <div class="alert alert-danger auto-remove margin-top-15">
                            <button class="close" data-close="alert"></button> An error occured. Please try again.
                        </div>
                        <?php } ?>
                    </div>

                    <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'categories_general'); ?>
