                    <div class="row">

                        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/dcn_sidebar'); ?>

                        <div class="col-md-9 note-editable-view" style="padding: 10px 30px;border:1px solid #eee">

                            <h3> <?php echo $title; ?> </h3>

                            <div class="">

                                <?php echo $contents; ?>

                            </div>

                            <a href="<?php echo site_url('admin/dcn/edit/index/'.$dcn_id); ?>" class="btn grey ">Edit</a>

                        </div>

                    </div>
