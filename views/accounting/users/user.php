<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content"> 
                <span class="pull-right">
                <?php if ($controller->has_access_of('add_users')) { ?>
                    <a  href="<?php echo base_url('accounting/admin/userCreation') ?>" data-controller="users" data-action="addUser" data-title="Create New User" class="btn btn btn-primary "> <i class="fa fa-plus"></i> <?php lang('btn_add_new'); ?></a>
                <?php } ?>    
                    </span>
                    <h2>
                       <?php lang('heading_all_user'); ?>
                    </h2>
                    <div class="clearfix"></div>
                    
                    <div class="clients-list">
                        <div class="full-height-scroll">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-hover dataTables1">
                                    <thead>
                                        <tr>
                       
                                            <th><?php lang('lab_sr_no'); ?></th>
                                            <th><?php lang('lab_fname'); ?></th>
                                            <th><?php lang('lab_lname'); ?></th>
                                            <th><?php lang('lab_email'); ?></th>
                                            <th><?php lang('lab_mob_number'); ?></th>
                                            <th><?php lang('lab_actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($allData)) { 
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
                                                <?php echo isset($value->mobile_no) ? $value->mobile_no :''; ?>
                                            </td>
                    
                                            <td>
                                        	<?php if ($controller->has_access_of('edit_users')) { ?>
                                               <a  href="<?php echo base_url('accounting/admin/userCreation') ."/". encode_url($value->id) ?>" data-title="Edit" class="fa-btn"><i class="fa fa-edit"></i></a>
                                            <?php } ?>  
                                               &nbsp;
                                               &nbsp;
                                        	<?php if ($controller->has_access_of('delete_users')) { ?>
                                               <a href="<?php echo base_url('accounting/admin/delete') ?>/<?php echo $value->id ; ?>/tbl_users" class="fa-btn delete-confirm"><i class="fa fa-trash"></i></a>
                                            <?php } ?>  
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
