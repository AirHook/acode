<?php $controller =& get_instance(); ?>

<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">

    <div class="row overflow-hide">

        <div class="col-sm-12 overflow-hide">

            <div class="ibox overflow-hide">

                <div class="ibox-content"> 

                <span class="pull-right">

                <!-- <a href="#" class="btn btn btn-primary " data-toggle="modal" data-target="#myModal">

                   <i class="fa fa-plus"></i> Import Excel

                </a> -->
                <?php if ($controller->has_access_of('add_customers')) { ?>
                    <a  href="<?php echo base_url('accounting/customers/addCustomer') ?>" data-controller="users" data-action="addUser" data-title="Create New User" class="btn btn btn-primary "> <i class="fa fa-plus"></i>  <?php lang('btn_add_new'); ?> </a>
                <?php } ?>
                </span>

                    <h2>

                       <?php lang('heading_all_customers'); ?> 

                    </h2>

                    <div class="clearfix"></div>

                    <div class="clients-list">

                        <div class="full-height-scroll">

                            <div class="table-responsive">

                                <table class="table table-striped table-hover table-hover dataTables1">

                                    <thead>

                                        <tr>

                                            <th><?php lang('lab_sr_no'); ?></th>

                                            <th><?php lang('lab_code'); ?></th>

                                            <th><?php lang('lab_name'); ?></th>

                                            <!-- <th>Narration</th> -->

                                            <th><?php lang('lab_email'); ?></th>

                                            <th><?php lang('lab_phone'); ?></th>
                                            <th><?php lang('lab_mobile_no'); ?>.</th>
                                            <th><?php lang('lab_address'); ?></th>

                                            <th><?php lang('lab_action'); ?></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php if(!empty($allUsers)) { 

                                        $serial_no=1;

                                        foreach($allUsers as $value) {?>

                                        <tr>

                                            <td>

                                                <?php echo $serial_no++;?> 

                                            </td>

                                            <td>

                                                <?php echo isset($value->customerCode) ? $value->customerCode :''; ?>

                                            </td>

                                            <td>

                                                <?php echo isset($value->customerName) ? $value->customerName :''; ?>

                                            </td>

                                          <!--  <td>

                                               <?php echo isset($value->narration) ? $value->narration :''; ?>

                                           </td> -->

                                            <td>

                                                 <?php echo isset($value->email) ? $value->email :''; ?>

                                            </td>

                                            <td>

                                                <?php echo isset($value->phone) ? $value->phone :''; ?>

                                            </td>
                                            <td>

                                                <?php echo isset($value->mobile) ? $value->mobile :''; ?>

                                            </td>
                                            <td>

                                                <?php echo isset($value->address) ? $value->address :''; ?>

                                            </td>
                                           

                                            <td>
                                            <?php if ($controller->has_access_of('edit_customers')) { ?>
                                               <a  href="<?php echo base_url('accounting/customers/addCustomer') ."/". encode_url($value->id) ?>" data-title="Edit" class="fa-btn"><i class="fa fa-edit"></i></a>
                                            <?php } ?>
                                               &nbsp;

                                               &nbsp;

                                            <?php if ($controller->has_access_of('delete_customers')) { ?>
                                               <a href="<?php echo base_url('accounting/customers/delete') ?>/<?php echo $value->id ; ?>/tbl_mcustomers" class="fa-btn delete-confirm"><i class="fa fa-trash"></i></a>
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

