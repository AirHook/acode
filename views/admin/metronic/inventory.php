                                        <?php
                                        // let's set the role for sales user my account
                                        $pre_link =
                                            @$role == 'sales'
                                            ? 'my_account/sales'
                                            : 'admin'
                                        ;
                                        ?>
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

                                            <div class="table-toolbar">
                                                <div class="col-md-6">

                                                    <!-- BEGIN FORM-->
                                                    <!-- FORM =======================================================================-->
                                                    <?php echo form_open(
                                                        $pre_link.'/inventory/'.$inv_prefix,
                                                        array(
                                                            'class'=>'form-horizontal',
                                                            'id'=>'form-wholesale_users_search_email'
                                                        )
                                                    ); ?>

                                                    <div class="input-group">
                                                        <input class="form-control" placeholder="Search for STYLE#..." name="search_string" type="text" style="text-transform:uppercase;">
                                                        <span class="input-group-btn">
                                                            <button class="btn blue uppercase bold" type="submit">Search</button>
                                                        </span>
                                                    </div>

                                                    </form>
                                                    <!-- End FORM =======================================================================-->
                                                    <!-- END FORM-->

                                                    <cite class="help-block small <?php echo @$role == 'sales' ? 'hide' : ''; ?>">Search entire record</cite>

                                                </div>

                                                <?php
                                                if ($search)
                                                {
                                                    echo '<div class="col-md-12"><h1><small><em>Search results for:</em></small> "'.$search_string.'"</h1><br /></div>';
                                                }
                                                ?>
                                            </div>

                                            <!-- BEGIN PRODUCT INVENTORY SIDEBAR -->
                                            <div class="col col-md-3">
                                                <?php
                                                if (@$role == 'sales')
                                                {
                                                    $this->load->view('admin/metronic/inventory_sidebar_sales_user', $this->data);
                                                }
                                                else
                                                {
                                                    $this->load->view('admin/metronic/inventory_sidebar', $this->data);
                                                }
                                                ?>
                                            </div>
                                            <!-- END PRODUCT INVENTORY SIDEBAR -->

                                            <!-- BEGIN PRODUCT INVENTORY LIST -->
                                            <div class="col col-md-9">
                                                <?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'inventory_stocks', $this->data); ?>
                                            </div>
                                            <!-- END PRODUCT INVENTORY LIST -->

                                        </div>
                                        <!-- END PAGE CONTENT BODY -->
