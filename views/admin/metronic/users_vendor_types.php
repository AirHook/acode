                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div class="notifciations">
                        <?php if ($this->session->flashdata('success') == 'add') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> New Vendor Type ADDED!
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'delete') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Vendor Type permanently removed from records. Vendor associations disassociated accordingly.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'exists') { ?>
                        <div class="alert alert-danger ">
                            <button class="close" data-close="alert"></button> Vendor Type/Slug already exists.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> An error occured. Please try again.
                        </div>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col-md-4">

                            <h1>Vendor Types</h1>
                            <hr />
                            <p>Simlpy type in a new Vendor Type name and click on the button to Add New Vendor Type. The new vendor type should appear in the list afterwards.</p>

                            <!-- BEGIN FORM-->
                            <!-- FORM =======================================================================-->
                            <?php echo form_open(
                                $this->config->slash_item('admin_folder').'users/vendor/types/add',
                                array(
                                    'class' => 'form-horizontal',
                                    'id' => 'form-vendor_types_add'
                                )
                            ); ?>

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Type Name:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control vendor_type" name="type" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Slug:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control vendor_slug" name="slug" value="" tabindex="-1" readonly />
                                        <span class="help-block">
                                            You can manually edit the slug by clicking <a href="javascript:;" id="disable-readonly" tabindex="-2"><cite>here</cite></a>.
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button type="submit" class="btn sbold blue">Add Vendor Type</button>
                                </div>
                            </div>

                            </form>
                            <!-- End FORM =======================================================================-->
                            <!-- END FORM-->

                        </div>
                        <div class="col-md-8">

                        <br />

                        <!-- BEGIN FORM-->
                        <!-- FORM =======================================================================-->
                        <?php echo form_open(
                            $this->config->slash_item('admin_folder').'users/vendor/types/bulk_actions',
                            array(
                                'class' => 'form-horizontal',
                                'id' => 'form-vendor_types_bulk_actions'
                            )
                        ); ?>

                        <input type="hidden" name="table" value="tbltrend" />
                        <input type="hidden" name="facet" value="trends" />

                        <div class="table-toolbar">
                            <div class="row">

                                <div class="col-lg-3 col-md-4">
                                    <select class="bs-select form-control selectpicker" id="bulk_actions_select" name="bulk_action" disabled>
                                        <option value="" selected="selected">Bulk Actions</option>
                                        <option value="del">Permanently Delete</option>
                                    </select>
                                </div>
                                <button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

                            </div>
                            <button class="btn green hidden-lg hidden-md" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

                        </div>

                        <?php
                        /*********
                         * This style a fix to the dropdown menu inside table-responsive table-scrollable
                         * datatables. Setting position to relative allows the main dropdown button to
                         * follow cell during responsive mode. A jquery is also needed on the button to
                         * toggle class to change back position to absolute so that the dropdown menu
                         * shows even on overflow
                         */
                        ?>
                        <style>
                            .dropdown-fix {
                                position: relative;
                            }
                        </style>
                        <table class="table table-striped table-hover table-checkable order-column" id="tbl-vendor_types">
                            <thead>
                                <tr>
                                    <th class="hidden-xs hidden-sm"> <!-- counter --> </th>
                                    <th class="text-center">
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-vendor_types .checkboxes" />
                                            <span></span>
                                        </label>
                                    </th>
                                    <th> Vendor Type </th>
                                    <th> Slug </th>
                                    <th> Delete </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($vendor_types)
                                {
                                    $i = 1;
                                    foreach ($vendor_types as $vendor_type)
                                    { ?>

                                <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                    <td class="hidden-xs hidden-sm">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class="text-center">
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $vendor_type->id; ?>" />
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>
                                        <?php echo $vendor_type->type; ?>
                                    </td>
                                    <td>
                                        <?php echo $vendor_type->slug; ?>
                                    </td>
                                    <td class="dropdown-wrap dropdown-fix">
                                        <a data-toggle="modal" href="#delete-<?php echo $vendor_type->id; ?>">
                                            <i class="icon-trash"></i> <cite> Delete </cite></a>
                                        <!-- ITEM DELETE -->
                                        <div class="modal fade bs-modal-sm" id="delete-<?php echo $vendor_type->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Warning!</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        Premanently DELETE item? <br /> This cannot be undone!
                                                        <br /><br />
                                                        NOTE that any vendor association will be disassociated accordingly.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/types/delete/index/'.$vendor_type->id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
                                                            <span class="ladda-label">Confirm?</span>
                                                            <span class="ladda-spinner"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </td>
                                </tr>

                                        <?php
                                        $i++;
                                    }
                                } ?>

                            </tbody>
                        </table>

                        </form>
                        <!-- End FORM =======================================================================-->
                        <!-- END FORM-->

                    </div>
                    </div>

                    <!-- BULK DELETE -->
                    <div class="modal fade bs-modal-sm" id="confirm_bulk_actions-trends-del" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Delete!</h4>
                                </div>
                                <div class="modal-body"> Delete multiple items? <br /> This cannot be undone! </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <button onclick="$('#form-vendor_types_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
                                        <span class="ladda-label">Confirm?</span>
                                        <span class="ladda-spinner"></span>
                                    </button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
