        <!-- ITEM SUSPEND -->
        <div class="modal fade bs-modal-lg" id="modal-barcode_scan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Scan Barcodes</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" >
    					<div class="row">

                            <!-- LEFT COLUMN -->
    						<div class="col-sm-6">

    							<div class="form-group">
    								<label>Barcode Text Code Should Show Here</label>
    								<input type="text" autocomplete="off" value="<?php echo isset($code) ? $code :''; ?>" class="form-control" required="" name="code" placeholder="Scan barcode here..">
    							</div>
                                <div class="form-grou">
                                    <button class="btn default btn-sm barcode-code-clear">Click to clear and scan another barcode</button>
                                </div>

    						</div>
                            <!-- End LEFT COLUMN -->

                            <!-- RIGHT COLUMN -->
    						<div class="col-sm-6">

                                <div class="form-group">
                                    <label>Select Action To Take</label>
                                    <a href="javascript:;>" target="_blank" class="btn dark btn-block open-details">
                                        Open Product Detail
                                    </a>
                                    <label></label>
                                    <a href="javascript:;" target="_blank" class="btn dark btn-block create-so">
                                        Create Sales Order
                                    </a>
                                    <a href="javascript:;" target="_blank" class="btn dark btn-block select-so">
                                        Select Sales Order Against Item
                                    </a>
                                    <label></label>
                                    <a href="javascript:;" target="_blank" class="btn dark btn-block create-po">
                                        Create Puchase Order
                                    </a>
                                    <a href="javascript:;" target="_blank" class="btn dark btn-block select-po">
                                        Select Purchase Order Against Item
                                    </a>
                                </div>

    						</div>
                            <!-- End RIGHT COLUMN -->

    					</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
