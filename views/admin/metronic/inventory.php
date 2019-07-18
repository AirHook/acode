                                        <!-- BEGIN PAGE CONTENT BODY -->
                                        <div class="row physical_inventory">

                                            <?php if ($this->uri->segment(3) == 'physical')
                                            { ?>
                                            <div class="col col-md-12">
                                                <div class="note note-info">
            										<h4 class="block">NOTES:</h4>
            										<p>This is the PHYSICAL STOCK inventory list. To EDIT, simply click on a cell, change the appropriate value, and then press ENTER to save new data.</p>
            									</div>
                                            </div>
                                                <?php
                                            } ?>

                                            <!-- BEGIN PRODUCT INVENTORY SIDEBAR -->
                                            <div class="col col-md-3">
                                                <?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'inventory_sidebar', $this->data); ?>
                                            </div>
                                            <!-- END PRODUCT INVENTORY SIDEBAR -->

                                            <!-- BEGIN PRODUCT INVENTORY LIST -->
                                            <div class="col col-md-9">
                                                <?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'inventory_'.$this->uri->segment(3).'_stocks', $this->data); ?>
                                            </div>
                                            <!-- END PRODUCT INVENTORY LIST -->

                                        </div>
                                        <!-- END PAGE CONTENT BODY -->
