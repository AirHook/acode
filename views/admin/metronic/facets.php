                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div class="notifications">
                        <?php if ($this->session->flashdata('success') == 'add') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> New Facet ADDED!
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'edit') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Facet information updated.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'delete') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Facet permanently removed from records.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> An error occured. Please try again.
                        </div>
                        <?php } ?>
                    </div>

                    <div class="tabbable-bordered">

                        <!-- TABS -->
                        <ul class="nav nav-tabs">
                            <li class="nav-tabs-item <?php echo $active_facet_tab == 'styles' ? 'active' : ''; ?>" data-tab_name="styles">
                                <a href="#tab_styles" id="tab-tab_styles" data-toggle="tab"> Styles
                                </a>
                            </li>
                            <li class="nav-tabs-item <?php echo $active_facet_tab == 'colors' ? 'active' : ''; ?>" data-tab_name="colors">
                                <a href="#tab_colors" id="tab-tab_colors" data-toggle="tab"> Colors
                                </a>
                            </li>
                            <li class="nav-tabs-item <?php echo $active_facet_tab == 'events' ? 'active' : ''; ?>" data-tab_name="events">
                                <a href="#tab_events" id="tab-tab_events" data-toggle="tab"> <?php echo @$this->webspace_details->slug == 'tempoparis' ? 'Seasons' : 'Events / Occassion'; ?>
                                </a>
                            </li>
                            <li class="nav-tabs-item <?php echo $active_facet_tab == 'materials' ? 'active' : ''; ?>" data-tab_name="materials">
                                <a href="#tab_materials" id="tab-tab_materials" data-toggle="tab"> Materials
                                </a>
                            </li>
                            <li class="nav-tabs-item <?php echo $active_facet_tab == 'trends' ? 'active' : ''; ?>" data-tab_name="trends">
                                <a href="#tab_trends" id="tab-tab_trends" data-toggle="tab"> Trends
                                </a>
                            </li>
                            <li class="nav-tabs-item <?php echo $active_facet_tab == 'seasons' ? 'active' : ''; ?>" data-tab_name="seasons">
                                <a href="#tab_seasons" id="tab-tab_seasons" data-toggle="tab"> Seasons
                                </a>
                            </li>
                        </ul>
                        <!-- END TABS -->

                        <!-- BEGIN TAB CONTENTS -->
                        <div class="tab-content clearfix">
                            <div class="tab-pane <?php echo $active_facet_tab == 'styles' ? 'active' : ''; ?>" id="tab_styles">

                                <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'facets_styles'); ?>

                            </div>
                            <div class="tab-pane <?php echo $active_facet_tab == 'colors' ? 'active' : ''; ?>" id="tab_colors">

                                <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'facets_colors'); ?>

                            </div>
                            <div class="tab-pane <?php echo $active_facet_tab == 'events' ? 'active' : ''; ?>" id="tab_events">

                                <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'facets_events'); ?>

                            </div>
                            <div class="tab-pane <?php echo $active_facet_tab == 'materials' ? 'active' : ''; ?>" id="tab_materials">

                                <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'facets_materials'); ?>

                            </div>
                            <div class="tab-pane <?php echo $active_facet_tab == 'trends' ? 'active' : ''; ?>" id="tab_trends">

                                <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'facets_trends'); ?>

                            </div>
                            <div class="tab-pane <?php echo $active_facet_tab == 'seasons' ? 'active' : ''; ?>" id="tab_seasons">

                                <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'facets_seasons'); ?>

                            </div>
                        </div>
                        <!-- END TAB CONTENTS -->

                    </div>
