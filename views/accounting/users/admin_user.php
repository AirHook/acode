<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content"> 
                <span class="pull-right">
                    <!-- <a  href="<?php echo base_url('accounting/admin/creatUser') ?>" data-controller="users" data-action="addUser" data-title="Create New User" class="btn btn btn-primary "> <i class="fa fa-plus"></i> Add New</a> -->
                    </span>
                    <h2>
                      <?php lang('heading_companies'); ?> 
                    </h2>
                    <div class="clearfix"></div>
                    <?php $controller=& get_instance();
                          $controller->showFlash();
                     ?>
                    <div class="clients-list">
                        <div class="full-height-scroll">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-hover dataTables1">
                                    <thead>
                                        <tr>
                                            <th><?php lang('lab_sr_no'); ?></th>
                                            <th><?php lang('lab_fname'); ?> </th>
                                            <th><?php lang('lab_lname'); ?> </th>
                                            <th><?php lang('lab_email'); ?> </th>
                                            <th><?php lang('lab_company'); ?> </th>
                                            <th><?php lang('lab_status'); ?> </th>
                                            <th><?php lang('lab_actions'); ?> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    if(!empty($allData)) { 
                                        $serial_no=1;
                                        foreach($allData as $value) {?>
                                        <tr>
                                            <td>
                                                <?php echo $serial_no++;?> 
                                            </td>
                                            <td>
                                                <?php echo isset($value->first_name) ? $value->first_name :''; ?>
                                            </td>
                                            <td>
                                                <?php echo isset($value->last_name) ? $value->last_name :''; ?>
                                            </td>
                                           
                                            <td>
                                                 <?php echo isset($value->email) ? $value->email :''; ?>
                                            </td>
                                            <td>
                                                <?php echo isset($value->companyName) ? $value->companyName :''; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if(isset($value->active) && $value->active == 0 ) { ?>
                                                    <a href="<?php echo base_url('auth/verifiedUser') ."/". $value->id ?>/verify" class="btn btn-danger"><i class="fa fa-lock"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url('auth/verifiedUser') ."/". $value->id ?>/notverified" class="btn btn-primary"><i class="fa fa-check"></i></a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                               <a  href="<?php echo base_url('accounting/admin/editAdmin') ."/". encode_url($value->id) ?>" data-title="Edit" class="fa-btn"><i class="fa fa-edit"></i></a>
                                               &nbsp;
                                               &nbsp;
                                               <a href="<?php echo base_url('accounting/admin/delete') ?>/<?php echo $value->companyId ; ?>/tbl_users" class="fa-btn delete-confirm"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
