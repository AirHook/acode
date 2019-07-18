<?php $CI=& get_instance() ?>
<style type="text/css">
   .full-width{
      width:100% !important;
   }
</style>
<?php if(isset($master->id) && $master->id > 0){ ?>
<form method="POST" action="<?php echo base_url('accounting/sales/editSaleInvoice/').$master->id ?>">
<?php } else{ ?>
<form method="POST" action="<?php echo base_url('accounting/sales/addSaleInvoice') ?>">
<?php } ?>
<input type="hidden" name="<?php echo $CI->security->get_csrf_token_name();?>" value="<?php echo $CI->security->get_csrf_hash();?>" >
<div class="wrapper-content">
   <div class="row" style="margin:0;">
      <div class="col-sm-12">
            <a href="javascript:void(0)" class="btn btn-danger category_back_btn" style="display:none">Back To Categories</a>
            <div id="category_item_selection" class="row">
                  <?php if(!empty($categories)){
                        foreach($categories as $key=>$value){ ?>
                              <?php if($value->groupName){ ?>
                                    <div class="category_item get_products_by_category_id  category col-md-2 col-sm-3 col-xs-6" data-url="<?php  echo base_url('accounting/sales/getProducts/').$value->id ?>">
                                          <p><?php  echo isset($value->groupName) ? $value->groupName :''; ?></p>
                                    </div>
                              <?php } ?>
                  <?php } } ?>
            </div>
            <div class="row products" style="display:none">
                  <div class="category_item category col-md-2 col-sm-3 col-xs-6">
                        <p></p>
                  </div>
            </div>
      </div>
   </div>
   <div class="row inner_contents" >
      <div class="col-sm-9 left_container_bar" style="padding-right:11;">
      <div id="register_container" class="sales clearfix">
      <div id="content-header" class="hidden-print sales_header_container">
         <h1 class="headigs"> <i class="icon fa fa-shopping-cart"></i>
            Sales Register 
         </h1>
         <div style="display: block" id="show_hide_grid_wrapper">
            <a  href="javascript:void(0)" class="btn  btn-primary barcode_label"><?php lang('print_Barcode_labels'); ?></a>
            <img src="<?php echo base_url()?>assets/insapinia_theme/img/finger.png" alt="show or hide item grid" style="margin-right: 9px;">
            <button class="btn btn-primary" id="show_grid" style="display: inline-block;"><?php lang('show_item_grid') ?></button>
            <button class="btn btn-primary hide-grid" >hide Item Grid</button>
         </div>
      </div>
      <div class="clear"></div>
      <!--Left small box-->
      <div class="row" style="margin:0;">
         <div class="sale_register_leftbox ">
            <div class="row forms-area">
               <div class="col-md-12 no-padd">
                  <div class="input-append sales-btns">
                  <?php $CI->showFlash(); ?>
                        <div class="row">
                              <div class="col-sm-6">
                                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                    <select name=""  class="select2 form-control selectProductForSale">
                                          <option value="">Search item</option>
                                          <?php if(!empty($products)){
                                                   foreach($products as $key=>$values){ ?>
                                                   	<option value="<?php echo isset($values->id) ? $values->id :''; ?>">
                                                   		<?php echo isset($values->productName) ? $values->productName :''; ?>
                                                   	</option>
                                           <?php } } ?>
                                    </select>
                              </div>
                             <!--  <div class="col-sm-6">
	                              	<select name="" class="form-control select2 pull-right select_sale_invoice_id">
	                                      <option value="">Search Sale Invoice</option>
	                                      <?php if(!empty($salesInvoiceNo)){
                                                   foreach($salesInvoiceNo as $key=>$values){ ?>
                                                   	<option <?php echo (isset($master->id) && $master->id == $values->id) ? 'selected' :''; ?> value="<?php echo isset($values->id) ? $values->id :''; ?>">
                                                   		<?php echo isset($values->salesInvoiceNo) ? $values->salesInvoiceNo :''; ?>
                                                   	</option>
                                           <?php } } ?>
	                                </select>
                              </div> -->
                        </div>
                  </div>
               </div>
               <!-- <div class="col-md-5 no-padd" style="padding-right:0;">
               </div> -->
            </div>
            <div class="row">
               <div class="table-responsive">
                  <table id="register" class="products_list table table-bordered">
                     <thead>
                        <tr>
                           <th></th>
                           <th class="sales_item sales_items_number">Barcode</th>
                           <th class="item_name_heading" style="width: 14%;">Item Name</th>
                           <th class="sales_stock" style="width: 15%;">UOM</th>
                           <th class="sales_price">Price</th>
                           <th class="sales_quality">Qty.</th>
                           <?php if($CI->has_access_of('allow_pos_unit_discount')): ?>
                              <th class="sales_discount">Discount</th>
                           <?php endif; ?>
                           <th class="sales_discount" style="width: 15%;">Select Tax</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody id="cart_contents" class="sa">
                        <?php if(!empty($details)){
                  		   foreach($details as $key=>$value){ ?>
	                  		   	<tr id="reg_item_top" bgcolor="#eeeeee">
	                  		   			<td style="text-align:center;"><a href="#" class="delete_item deleteRowForsale"><i class="fa fa-trash-o fa fa-2x text-error"></i></a>
	                  		   			</td>
	                  		   			<td class="text text-success">
	                  		   				<input type="hidden" name="product[<?php echo $key ?>][barcode]" value="<?php echo isset($value->barcode) ? $value->barcode :''; ?>" class="form-control barcodevalueForSale">
	                  		   				<span class="barcode_html"><?php echo isset($value->barcode) ? $value->barcode :''; ?></span>
	                  		   			</td>
	                  		   			<td class="text text-info sales_item" id="reg_item_number">
	                  		   				<input type="hidden" class="product-id" name="product[<?php echo $key ?>][product_id]" value="<?php echo isset($value->product_id) ? $value->product_id :''; ?>">
	                  		   				<span class="produt_name_html"><?php echo isset($value->productName) ? $value->productName :''; ?></span>
	                  		   				<input type="hidden" class="" name="product[<?php echo $key ?>][productName]" value="<?php echo isset($value->productName) ? $value->productName :''; ?>">
	                  		   			</td>
	                  		   			<td class="text sales_stock" id="reg_item_stock">
	                  		   				<input type="hidden" name="" class="uom-id" value="<?php echo isset($value->UOMId) ? $value->UOMId :''; ?>">
	                  		   				<select name="product[<?php echo $key ?>][UOMId]" class="form-control UOMId getSalePriceByUnit input-small">
	                  		   					<?php if(isset($value->all_units)) { 
	                  		   						    foreach($value->all_units as $key1=>$units){?>
	                  		   						    <option <?php echo (isset($value->UOMId) && $value->UOMId == $units->units->id) ? 'selected' :''; ?> value="<?php echo isset($units->units->id) ? $units->units->id :''; ?>"><?php echo isset($units->units->UOMName) ? $units->units->UOMName :''; ?></option>
	                  		   					<?php } } ?>
	                  		   				</select>
	                  		   			</td>
	                  		   		<td>
                                       <?php
                                          if($CI->has_access_of('edit_price_pos')){
                                             price_input_field(array('name' => 'product['.$key.'][rate]', 'value' => deformat_value($value->rate), 'class' => 'purchaseRate input-small form-control', 'placeholder' => '00.00','id'=>"price_2"));
                                          }else{
                                             price_input_field(array('name' => 'product['.$key.'][rate]','readonly'=>"true", 'value' => deformat_value($value->rate), 'class' => 'purchaseRate input-small form-control', 'placeholder' => '00.00','id'=>"price_2"));
                                          }
                                        ?>
	                  		   		</td>
                                    <td>
                                       <?php
                                        quantity_input_field(array('name' => 'product['.$key.'][qty]','min'=>'1', 'max' => '', 'id' => 'quantity_2', 'value' => deformat_value($value->qty), 'class' => 'saleqty input-small form-control', 'placeholder' => '0'));
                                       ?>
                                    </td>
                                    <?php if($CI->has_access_of('allow_pos_unit_discount')): ?>
                                    <td>
                                       <?php
                                          price_input_field(array('name' => 'product['.$key.'][discount_amount]', 'value' =>deformat_value($value->discount_amount), 'class' => 'discount_amount input-small form-control', 'placeholder' => '00.00'));
                                        ?>
                                    </td>
                                 <?php endif; ?>
	                  		   		<td>
                                       <select name="product[<?php echo $key ?>][tax_id]" class="form-control input-small appliedTaxesForSale">
                                          <option value="">Select</option>
                                          <?php 
                                          $selected_tax_value = 0;
                                          $selected_tax_symbol = '';
                                          if(!empty($taxes)){
                                                   foreach($taxes as $key1=>$tax) { 
                                                   if(isset($value->tax_id) && $value->tax_id == $tax->id) {
                                                      $selected_tax_value = $tax->tax_value;
                                                      $selected_tax_symbol = $tax->tax_symbal;
                                                   }
                                                   ?>
                                                   <option <?php echo (isset($value->tax_id) && $value->tax_id == $tax->id) ? 'selected':''; ?> value="<?php echo isset($tax->id) ? $tax->id :''; ?>">
                                                      <?php echo isset($tax->ledgerName) ? $tax->ledgerName :''; ?>
                                                   </option>
                                          <?php } } ?>
                                       </select>
	                  		   			<input type="hidden" name="" class="totaTaxValue" value="<?php echo $selected_tax_value; ?>">
	                  		   			<input type="hidden" name="" class="taxSymbal" value="<?php echo $selected_tax_symbol; ?>">
	                  		   		</td>
	                  		   		<td class="text text-main">
	                  		   			<input type="hidden" name="product[<?php echo $key ?>][amount]" class="amount" value="<?php echo isset($value->amount) ? $value->amount :''; ?>">
	                  		   			<span class="saleamounthtml"><?php echo price_value($value->amount); ?></span>
	                  		   		</td>
	                  		   	</tr>
	                  <?php } } ?>
                     </tbody>
                  </table>
               </div>
               <ul class="list-inline pull-left bottom_btns">
                  <li>
                     <a href="<?php echo base_url('accounting/sales/pos') ?>" class="btn btn-primary">Close Register</a>       
                  </li>
                 <!--  <li>
                     <a href="<?php echo base_url('accounting/account/giftCards'); ?>" class="btn btn-primary " title="Sell GiftCard">Sell GiftCard</a>                  
                  </li> -->
               </ul>
               
            </div>
         </div>
      </div>
   </div>
   <?php if(!empty($payments)){ ?>
      <div class="row payment_listing">
   <?php }else{ ?>
      <div class="row payment_listing" style="display:none">
   <?php }  ?>
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
           <table class="table table-bordered" style="background:#ffff;margin-top:15px">
                    <thead>
                        <tr>
                              <th>Payment Method</th>
                              <th>Amount</th>
                              <th></th>
                        </tr>
                    </thead>
                <tbody>
                  <?php if(!empty($payments)){ ?>
                  <?php foreach($payments as $key=>$add_payments){ 
                     ?>
                     <tr>
                        <td>
                           <input type="hidden" value="<?php echo isset($add_payments->card_id) ? $add_payments->card_id :''; ?>" name="add_payment[<?php echo $key ?>][card_id]">
                           <input type="hidden" value="<?php echo isset($add_payments->payment_method) ? $add_payments->payment_method :''; ?>" name="add_payment[<?php echo $key ?>][payment_method]">
                           <?php if(isset($add_payments->is_return) && $add_payments->is_return): ?>
                              <input type="hidden" value="<?php echo $add_payments->is_return; ?>" name="add_payment[<?php echo $key ?>][is_return]">
                           <?php endif; ?>
                           <span><?php echo isset($add_payments->payment_method) ? $add_payments->payment_method :''; ?></span>
                        </td>
                        <td>
                           <input type="hidden" value="<?php echo isset($add_payments->method_id) ? $add_payments->method_id :''; ?>" name="add_payment[<?php echo $key ?>][method_id]">
                           <input type="hidden" value="<?php echo isset($add_payments->method) ? $add_payments->method :''; ?>" name="add_payment[<?php echo $key ?>][method]">
                           <input type="hidden" class="amount_listing" value="<?php echo isset($add_payments->payment_value) ? $add_payments->payment_value :''; ?>" name="add_payment[<?php echo $key ?>][payment_value]">
                           <span><?php echo isset($add_payments->payment_value) ? $add_payments->payment_value :''; ?></span>
                        </td>
                        <td><a href="javascript:void(0)"  class="btn btn-danger delete_listing"><i class="fa fa-minus"></i></td>
                     </tr>
                  <?php } } ?>
                </tbody>
           </table>
      </div>
   </div>
</div>
      <div class="col-sm-3 sale_register_rightbox right_sidebar right_container_bar">
      	<?php if(isset($master->salesInvoiceNo) && $master->salesInvoiceNo > 0){ ?>
      		<input required="" type="hidden" name="salesInvoiceNo" value="<?php echo $master->salesInvoiceNo ?>" class="form-control" readonly="">
        <?php }else{ ?>
            <input required="" type="hidden" name="salesInvoiceNo" value="<?php echo isset($totalInvoice) ? sprintf("%04d",$totalInvoice+1) :''; ?>" class="form-control" readonly="">
        <?php } ?>
            <ul class="list-group">
               <li class="list-group-item nopadding">
               </li>
               <li class="list-group-item item_tier">
                  <h5 class="customer-basic-information">Select Customer (Optional)</h5>
                  <div class="row nomargin">
                     <div class="clearfix" id="customer_info_shell">
                        <select name="supplierId" required class="customers_select select2 form-control">
                           <?php if(!empty($customers)){
                                    foreach($customers as $key=>$value){ ?>
                                    <option <?php echo (isset($master->customerId) && $master->customerId == $value->id) ? 'selected' :''; ?> value="<?php echo isset($value->id) ? $value->id :''; ?>">
                                    	<?php echo isset($value->ledgerName) ? $value->ledgerName :''; ?>
                                    </option>
                            <?php } }  ?>
                        </select>
                        <div id="add_customer_info">
                           <div id="common_or" class="common_or">
                              <p>OR </p>                    
                                <a target="_blank" href="<?php echo base_url('accounting/customers/addCustomer') ?>" class="btn btn-primary none" title="New Customer" id="new-customer">
                                 <div class="small_button"> <span>New Customer</span> </div>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </li>
            </ul>
         <div class="col-sm-12 subtotal-items">
         <div class="input-left-box form-group">
         <label><?php lang('lab_current_date'); ?></label>
         </div>
         <div class="input-right-box input-group">
            <?php if(isset($master->deliveryDate)) { ?>
               <input required="" type="text" name="deliveryDate" class="form-control <?php echo ($CI->has_access_of('edit_date_sale_invoices')) ? 'datepicker' : ''; ?> deliveryDate" value="<?php echo isset($master->deliveryDate) ? date("M d,Y",strtotime($master->deliveryDate)) :''; ?>">
               <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <?php }else { ?>
               <input required="" type="text" name="deliveryDate" class="form-control <?php echo ($CI->has_access_of('edit_date_sale_invoices')) ? 'datepicker' : ''; ?> deliveryDate" value="<?php echo date('M d,Y'); ?>">
               <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
               <?php } ?>
         </div>
         <div class="input-left-box form-group">
            <label>SubTotal</label>
         </div>
         <div class="input-right-box form-group">
            <?php 
               price_input_field(array('name' => 'subtotal', 'value' => deformat_value(isset($master->subtotal) ? $master->subtotal : ''), 'class' => 'form-control subtotal', 'placeholder' => '00.00', 'readonly' => 'true'),'full-width');
             ?>
            <!-- <input required="" type="text" readonly="" name="subtotal" class="form-control subtotal" value="<?php echo isset($master->subtotal) ? $master->subtotal :'0'; ?>" placeholder="Sub Total"> -->
         </div>
         <div class="input-left-box form-group">
            <label>Tax</label>
         </div>
         <div class="input-right-box form-group">
            <select class="form-control select2 taxForSale" name="tax">
               <!-- <option value="0"><?php lang('lab_select'); ?></option> -->
               <?php 
               $tax_value = 0;
               $tax_symbal = '';
               if(!empty($taxesOnBill)){
                  foreach ($taxesOnBill as $index => $value) { 
                     ?>
                     <option <?php echo ((isset($master->tax) && $master->tax == $value->id) || $index == 0) ? 'selected' :''; ?>  value="<?php echo isset($value->id) ? $value->id :''; ?>" data-taxvalue="<?php echo isset($value->tax_value) ? $value->tax_value :''; ?>" data-taxtype="<?php echo isset($value->tax_symbal) ? $value->tax_symbal :''; ?>" >
                        <?php echo isset($value->ledgerName) ? $value->ledgerName :''; ?>(<?php echo isset($value->tax_value) ? $value->tax_value :''; ?><?php echo isset($value->tax_symbal) ? $value->tax_symbal :''; ?>)
                     </option>
                  <?php } } ?>
            </select>
         </div>
         
         <div class="input-right-box form-group">
            <input type="hidden" value="" class="form-control total_before_discount" readonly="true">
         </div>
         <div class="input-left-box form-group">
            <label>Discount</label>
         </div>
         <div class="input-right-box form-group">
            <?php 
               price_input_field(array('name' => 'discount', 'value' => deformat_value(isset($master->discount) ? $master->discount : ''), 'class' => 'form-control discount', 'placeholder' => '00.00'),'full-width');
             ?>
         </div>
         <div class="input-left-box form-group">
            <label>Total</label> 
         </div>
         <div class="input-right-box form-group">
            <?php 
               price_input_field(array('name' =>'total','readonly'=>"true",'style'=>'width:100% !important','value' => deformat_value(isset($master->total) ? $master->total : ''), 'class' =>'form-control total', 'placeholder' => '00.00'),'full-width');
             ?>
         </div>
         <div class="input-left-box form-group">
            <label>Amount Due</label> 
         </div>
         <div class="input-right-box form-group">
            <?php 
               price_input_field(array('name' => 'amount_due','readonly'=>"true" , 'value' => '0','class' => 'form-control amount_due', 'placeholder' => '00.00'),'full-width');
             ?>
            <!-- <input required="" type="number" value="0" readonly="" class="form-control amount_due" placeholder="amount due" name="amount_due"> -->
         </div>
         <div class="return_field">
            <div class="input-left-box form-group">
               <label>Return</label> 
            </div>
            <div class="input-right-box form-group">
               <?php 
               price_input_field(array('name' => 'return','readonly'=>"true" , 'value' => '0','class' => 'form-control return', 'placeholder' => '00.00'),'full-width');
             ?>
               <!-- <input type="MyNumber" value="0" readonly="" class="form-control return" name="return"> -->
            </div>
         </div>
         <div class="input-left-box form-group">
            <label>Add Payment </label> 
         </div>
         <div class="input-right-box form-group">
            <select name="payment_method" class="form-control">
            <?php 
            $selected_method = null;
            if(!empty($payment_method)){
               $selected_method = $payment_method[0]->name;
                    foreach($payment_method as $key =>$value){ 
                  ?>
                  <option <?php if(isset($value->name) && $value->name == 'Cash') { echo 'selected'; $selected_method = $value; } ?> value="<?php echo isset($value->id) ? $value->id :''; ?>">
                        <?php echo isset($value->name) ? $value->name :''; ?>
                  </option>
             <?php } } ?>
            </select>
         </div>
         <div class="giftcard_row row" <?php echo (isset($selected_method) && $selected_method == 'Gift Card') ? '' : 'style="display: none;"'; ?>>
            <div class="col-sm-6" style="padding-right: 0px; width: 135px;">
               <div class="form-group">
                  <input type="text" value="" class="form-control card_number" placeholder="Enter Number">
               </div>
            </div>
            <div class="col-sm-5" style="padding-left: 3px; width: 80px;">
               <div class="form-group">
                  <input type="hidden" class="card_id" value="">
                  <input type="MyNumber" readonly="true" value="" class="form-control card_value" >
               </div>
            </div>
            <div class="col-sm-1" style="padding: 0px; text-align: right;">
               <div class="form-group">
                  <a href="#" class="btn btn-primary verify-giftcard">Verify</a>
               </div>
            </div>
         </div>
         <div class="row add-payment_box">
            <div class="col-sm-6 discount_item">
               <input  type="MyNumber" value="" <?php echo (isset($selected_method) && $selected_method == 'Gift Card') ? 'readonly="true"' : ''; ?> class="form-control payment-value"  name="">
            </div>
            <div class="col-sm-6 print_btns">
                  <button type="button"  class="btn btn-primary add_payment_btn">Add Payment</button>
            </div>
         </div>
         <div class="input-left-box form-group">
            <label>Receive Payment</label> 
         </div>
         <div class="input-right-box form-group">
            <?php 
               price_input_field(array('name' => 'payment_receive','readonly'=>"true" , 'value' => deformat_value(isset($master->payment_receive) ? $master->payment_receive : ''),'class' => 'form-control paymentReceive', 'placeholder' => '00.00'),'full-width');
             ?>
         </div>
         <!-- <div class="input-left-box form-group">
            <label>Balance</label> 
         </div>
         <div class="input-right-box form-group">
            <input type="text" value="0" readonly="" class="form-control balance">
         </div> -->
         
        <div class="row" style="margin-bottom:8px;">
           <div class="col-sm-12">
              <h5 class="customer-basic-information">Comments:</h5>
               <textarea type="text" name="narration" class="form-control"></textarea>
           </div>
        </div>
	      <div class="row" >
	      	<div class="col-sm-12">
			      <p><input type="checkbox">  Show comments on receipt</p>
	      	</div>
	      </div>
      </div>
      <div class="col-sm-12 save_btns">
         <div class="form-group">
            <div class="col-sm-12 print_btns">
               <?php if(isset($master->id) && $master->id > 0){ ?>
               <input type="submit" name="complete_sale"  style="" class="btn btn-primary complete_sale_btn" value="Complete Sale">
               <?php }else{ ?>
               <input type="submit" name="complete_sale"  style="width: 100%;display:none" class="btn btn-primary complete_sale_btn" value="Complete Sale">
               <?php }  ?>
            </div>
         </div>
      </div>
   </div>
   </div>
</div>
</form>