<?php $controller =& get_instance(); 
$controller->load->model('product_model');
?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row  overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content">
                    <h2>Barcodes Labels
						<div class="clearfix"></div>
					</h2>
					<form class="" action="<?php echo base_url('accounting/products/barcode_label') ?>" method="POST">
                    <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name()?>" value="<?php echo $controller->security->get_csrf_hash()?>" />
                    <div class="row">
                      <div class="col-sm-4">
                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="form-control select2" name="category_name" onchange="window.location='<?php echo base_url('accounting/products/all_categories') ?>/'+this.value">
                                  <option value="">-select--</option>
                                <?php if(!empty($all_categories)){
                                          foreach($all_categories as $key => $row) {?>
                                            <option <?php echo (isset($category_id) && $category_id == $row->category_id) ? 'selected':''; ?> value="<?php echo isset($row->category_id) ? $row->category_id :'' ?>">
                                              <?php echo isset($row->category_name) ? $row->category_name :'' ?>
                                            </option>
                                <?php } } ?>
                              </select>
                            </div>
                        </div>
                    </div>
                  <?php if(!empty($all_products)){ ?>
                    <div class="row"> 
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Select Product</label>
                          <select required="" class="form-control select2" name="prod_no" onchange="window.location='<?php echo base_url('accounting/products/barcode_label') ?>/'+this.value">
                            <option value="">-select product--</option>
                            <?php if(!empty($all_products)){
                                      foreach($all_products as $key=>$row) {?>
                                        <option <?php echo (isset($prod_no) && $prod_no == $row->prod_no) ? 'selected':''; ?>  value="<?php echo isset($row->prod_no) ? $row->prod_no :'' ?>">
                                          <?php echo isset($row->prod_name) ? $row->prod_name :'' ?>
                                        </option>
                            <?php } } ?>
                          </select>
                        </div>
                      </div>
                    <?php if(!empty($product_by_prod_no)){ ?>
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Select Vendor Code</label>
                              <select class="form-control select2" required="" name="vendor_code">
                                <option value="">-select--</option>
                              <?php if(!empty($product_by_prod_no)){
                                        foreach($product_by_prod_no as $key=>$row) {
                                          if(isset($row->vendorcodes->vendor_code)){
                                          ?>
                                          <option <?php echo (isset($vendor_code) && $vendor_code == $row->vendorcodes->vendor_code) ? 'selected':''; ?> value="<?php echo isset($row->vendorcodes->vendor_code) ? $row->vendorcodes->vendor_code :'' ?>">
                                            <?php echo isset($row->vendorcodes->vendor_code) ? $row->vendorcodes->vendor_code :'' ?>
                                          </option>
                              <?php } } }?>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label>Select Color Code</label>
                              <select class="form-control select2" required="" name="color_code">
                                <option value="">-select--</option>
                              <?php if(!empty($product_by_prod_no)){
                                        foreach($product_by_prod_no as $key=>$row) {
                                            if(isset($row->colorcodes->color_code)){
                                          ?>
                                          <option <?php echo (isset($color_code) && $color_code == $row->colorcodes->color_code) ? 'selected':''; ?> value="<?php echo isset($row->colorcodes->color_code) ? $row->colorcodes->color_code :'' ?>">
                                            <?php echo isset($row->colorcodes->color_code) ? $row->colorcodes->color_code :'' ?>
                                          </option>
                              <?php } } }?>
                            </select>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  <?php }else if(isset($all_products) && empty($all_products)){ ?>
                      <div class="col-sm-4">
                          <div class="alert alert-danger">
                              No Product for this category
                          </div>
                      </div>
                  <?php } ?>
                    <?php if(!empty($product_by_prod_no)){ ?>
                      <div class="row"> 
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Select Size</label>
                                <select class="form-control select2" name="size">
                                  <option value="">-select--</option>
                                <?php if(!empty($size)){
                                          foreach($size as $key=>$row) {?>
                                            <option <?php echo (isset($size) && $size == $row->size) ? 'selected':''; ?> value="<?php echo isset($row->size) ? $row->size :'' ?>">
                                              <?php echo isset($row->size) ? $row->size :'' ?>
                                            </option>
                                <?php } } ?>
                              </select>
                            </div>
                        </div>
                      </div>
                    <?php } ?>
                   <?php if(!empty($product_by_prod_no)){ ?>
                      <div class="row"> 
                        <div class="col-sm-12">
                            <div class="form-group">
                              <button type="submit" class="btn btn-info">Generate Barcodes</button>
                            </div>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                  <div class="row parameter">
                      <div class="col-sm-12">
                      <?php if(!empty($barcode_code)){ ?>
                        <table class="table table-striped table-sm card-text" border="1">
                            <thead>
                                <tr>
                                    <th>SKU (Prod No.)</th>
                                    <th>Vendor Code</th>
                                    <th>Color Code</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <?php echo isset($prod_no) ? $prod_no :''; ?>
                                </td>
                                <td>
                                  <?php echo isset($vendor_code) ? $vendor_code :''; ?>
                                </td>
                                <td>
                                  <?php echo isset($color_code) ? $color_code :''; ?>
                                </td>
                                <td></td>
                              </tr>
                            </tbody>
                        </table>
                      <?php } ?>
                      </div>
                    </div>
                    <div class="row" style="margin-top:50px">
                      <?php if(isset($barcode_code) && $barcode_code!=''){ ?>
                        <div class="col-sm-12 text-center">
                            <div style="width: 2in;height: .8in;word-wrap: break-word;overflow: hidden;margin:0 auto;text-align:center;font-size: 9pt;line-height: 1em;page-break-after: always;padding: 10px;">
                                <?php echo '<img src="data:image/png;base64,' . base64_encode($barcode_code) . '">'; ?><br>
                                <?php echo isset($code) ? $code :''; ?>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 text-center">
                            <a class="btn btn-info" href="<?php echo base_url('accounting/products/barcodesprint/').$code ?>">Print</a>
                          </div>
                        </div>
                      <?php } ?>
                </div>
            </div>
        </div>
    </div>
   </div>
</div>
