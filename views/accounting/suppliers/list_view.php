<?php $controller =& get_instance(); ?>

<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">

    <div class="row overflow-hide">

        <div class="col-sm-12 overflow-hide">

            <div class="ibox overflow-hide">

                <div class="ibox-content"> 

                <span class="pull-right">

                  <!--   <a href="#" class="btn btn btn-primary " data-toggle="modal" data-target="#myModal">

                    Import Excel

                </a> -->
                <?php if ($controller->has_access_of('add_suppliers')) { ?>
                    <a  href="<?php echo base_url('accounting/suppliers/add') ?>" data-controller="users" data-action="addUser" data-title="Create New User" class="btn btn btn-primary "> <i class="fa fa-plus"></i><?php lang('btn_add_new'); ?></a>
                <?php } ?>
                    </span>

                    <h2>

                       <?php lang('heading_all_suppliers'); ?> 

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

                                            <th><?php lang('lab_actions'); ?></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php if(!empty($suppliers)) { 

                                        $serial_no=1;

                                        foreach($suppliers as $value) {?>

                                        <tr>

                                            <td>

                                                <?php echo $serial_no++;?> 

                                            </td>

                                            <td>

                                                <?php echo isset($value->supplierCode) ? $value->supplierCode :''; ?>

                                            </td>

                                            <td>

                                                <?php echo isset($value->supplierName) ? $value->supplierName :''; ?>

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
                                            <?php if ($controller->has_access_of('edit_suppliers')) { ?>
                                               <a  href="<?php echo base_url('accounting/suppliers/add') ."/". encode_url($value->id) ?>" data-title="Edit" class="fa-btn"><i class="fa fa-edit"></i></a>
                                            <?php } ?>
                                               &nbsp;

                                               &nbsp;
                                            <?php if ($controller->has_access_of('delete_suppliers')) { ?>
                                               <a href="<?php echo base_url('accounting/suppliers/delete') ?>/<?php echo $value->id ; ?>/tbl_suppliers" class="fa-btn delete-confirm"><i class="fa fa-trash"></i></a>
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

