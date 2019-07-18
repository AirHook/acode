<?php $controller =& get_instance(); 
$controller->load->model('product_model');
$controller->load->library('barcode');
?>
<style>
    .dropdown-fix {
        position: relative;
    }
    .thumb-tiles {
        position: relative;
        margin-right: 5px;
        margin-bottom: 5px;
        float: left;
    }
    .thumb-tiles .thumb-tile {
        display: block;
        float: left;
            height: 90px; /*135px;*/
            width: 60px !important; /*90px !important;*/
        cursor: pointer;
        text-decoration: none;
        color: #fff;
        position: relative;
        font-weight: 300;
            font-size: 12px;
        letter-spacing: .02em;
        line-height: 20px;
        overflow: hidden;
        border: 4px solid transparent;
        /*margin: 0 10px 10px 0;*/
    }
    .thumb-tiles .thumb-tile.image .tile-body {
        padding: 0 !important;
    }
    .thumb-tiles .thumb-tile .tile-body {
        height: 100%;
        vertical-align: top;
        padding: 10px;
        overflow: hidden;
        position: relative;
        font-weight: 400;
            font-size: 12px;
        color: #fff;
        /*margin-bottom: 10px;*/
    }
    .thumb-tiles .thumb-tile.image .tile-body > img {
        width: 100%;
        height: auto;
        min-height: 100%;
        max-width: 100%;
    }
    .thumb-tiles .thumb-tile .tile-body img {
        margin-right: 10px;
    }
    .thumb-tiles .thumb-tile .tile-object {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
            min-height: 20px;
        background-color: transparent;
    }
    .thumb-tiles .thumb-tile .tile-object > .name {
        position: relative;
        bottom: 0;
        left: 0;
        margin: 0 auto;
        font-weight: 300;
            font-size: 10px;
        color: #fff;
    }
    .img-a {
        position: absolute;
        left: 0;
        top: 0;
    }
    .img-b {
        position: absolute;
        left: 0;
        top: 0;
    }
</style>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row  overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content">
                    <h2><?php lang('heading_all_products'); ?> 
						<span class="pull-right">
							<!-- <a href="#" class="btn btn btn-primary " data-toggle="modal" data-target="#myModal">
                               Import Excel
                            </a>&nbsp; -->
							<a  href="<?php echo base_url('accounting/products/all_categories') ?>" class="btn  btn-primary">Generate Barcodes</a>&nbsp;
               			 <?php if ($controller->has_access_of('add_product_creation')) { ?>
							<!-- <a  href="<?php echo base_url('accounting/products/addProduct') ?>" class="btn  btn-primary "> <i class="fa fa-plus"></i> <?php lang('lab_add_new_product'); ?></a>&nbsp; -->
						<?php } ?>
						</span>
						<div class="clearfix"></div>
					</h2>
					<div class="clients-list listing">
                       <div class="full-height-scroll">
                            <div class="table-responsive">
                                <div hidden class="custom-html">
                                </div>
                                <table class="table table-striped table-hover table-hover dataTables1 order-items data-table">
                                    <thead>
                                        <tr>
                                        	<!-- <th>
                                        		<input type="checkbox" name="select_all" class="select_all i-checks">
                                        	</th> -->
                                        	<th>Sr.No</th>
                                        	<th>Product Image</th>
                                            <th>Barcode</th>
                                            <th style="width:170px !important;">Product Name</th>
                                            <th>SKU (Prod No.)</th>
                                            <th>Designer</th>
                                            <th>Vendor Code</th>
                                            <!-- <th>Size Mode</th> -->
                                            <th>Color Name</th>
                                            <th>Color Code</th>
                                            <th>Default Wholesale Price</th>
                                            <th>Default Vendor Price</th>
                                            <th>Default Retail Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php if(!empty($all_products)){ 
                                            $i = 1;
                                            $unveil = FALSE;
                                       foreach($all_products as $key=>$row){
                                            $pre_url = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$row->d_url_structure.'/'.$row->sc_url_structure;
                                            $img_front_pre = $pre_url.'/product_front/thumbs/';
                                            $img_back_pre = $pre_url.'/product_back/thumbs/';
                                            $img_side_pre = $pre_url.'/product_side/thumbs/';
                                            // the image filename
                                            // the old ways dependent on category and folder structure
                                            $image = $row->prod_no.'_'.$row->primary_img_id.'_1.jpg';
                                            // the new way relating records with media library
                                            $new_pre_url = $this->config->item('PROD_IMG_URL').$row->media_path.$row->media_name;
                                            $img_front_new = $new_pre_url.'_f1.jpg';
                                            $img_back_new = $new_pre_url.'_b1.jpg';
                                            $img_side_new = $new_pre_url.'_s1.jpg';

                                            // after the first batch, hide the images through unveil
                                            if (($i / 800) > 1) $unveil = TRUE;
                                        ?>
		                                    <tr>
		                                        <td><?php echo $key+1; ?></td>
		                                        <td class="text-center"> <!-- Images -->
                                                    <div class="thumb-tiles">
                                                        <div class="thumb-tile image bg-blue-hoki">
                                                            <a href="#">
                                                                <div class="tile-body">
                                                                    <img class="img-unveil" <?php echo $unveil ? 'data-src="'.($row->primary_img ? $img_front_new : $img_front_pre.$image).'"' : 'src="'.($row->primary_img ? $img_front_new : $img_front_pre.$image).'"'; ?> alt="">
                                                                    <noscript>
                                                                      <img class="" src="<?php echo ($row->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
                                                                    </noscript>
                                                                </div>
                                                                <!-- <div class="tile-object">
                                                                    <div class="name"> Front </div>
                                                                </div> -->
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="thumb-tiles">
                                                        <div class="thumb-tile image bg-blue-hoki">
                                                            <a href="#">
                                                                <div class="tile-body">
                                                                    <img class="img-unveil" <?php echo $unveil ? 'data-src="'.($row->primary_img ? $img_side_new : $img_side_pre.$image).'"' : 'src="'.($row->primary_img ? $img_side_new : $img_side_pre.$image).'"'; ?> alt="">
                                                                </div>
                                                                <div class="tile-object">
                                                                    <div class="name"> <?php //echo $row->prod_no; ?>Side </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="thumb-tiles">
                                                        <div class="thumb-tile image bg-blue-hoki">
                                                            <a href="#">
                                                                <div class="tile-body">
                                                                    <img class="img-unveil" <?php echo $unveil ? 'data-src="'.($row->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($row->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
                                                                </div>
                                                                <div class="tile-object">
                                                                    <div class="name"> <?php //echo $row->prod_no; ?>Back </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div> -->
                                                </td>
                                                <td>
                                                    <?php
                                                        $barcode_code='';
                                                        if(isset($row->prod_no))
                                                        {
                                                            $barcode_code.=$row->prod_no;
                                                        }
                                                        if(isset($row->color_code))
                                                        {
                                                            $barcode_code.='_'.$row->color_code;
                                                        }
                                                        if(isset($row->vendor_code))
                                                        {
                                                            $barcode_code.='_'.$row->vendor_code;
                                                        }
                                                        if(isset($barcode_code) && $barcode_code){
                                                            $code=$controller->barcode->generate_barcode($barcode_code);
                                                     ?>
                                                        <div style="width: 2in;height: .8in;word-wrap: break-word;overflow: hidden;margin:0 auto;text-align:center;font-size: 9pt;line-height: 1em;page-break-after: always;padding: 10px;">
                                                            <?php echo '<img src="data:image/png;base64,' . base64_encode($code) . '">'; ?><br>
                                                            <?php echo isset($barcode_code) ? $barcode_code :''; ?>
                                                        </div>
                                                <?php } ?>
                                                </td>
		                                        <td>
		                                            <?php echo isset($row->prod_name) ? $row->prod_name:''; ?>
		                                        </td>
		                                        <td>
		                                            <?php echo isset($row->prod_no) ? $row->prod_no:''; ?>
		                                        </td>
                                                <td>
                                                    <?php echo isset($row->designer) ? $row->designer :''; ?>
                                                </td>
		                                        <td>
		                                            <?php echo isset($row->vendor_code) ? $row->vendor_code:''; ?>
		                                        </td>
		                                        <!-- <td>
		                                            <?php echo isset($row->size_mode) ? $row->size_mode:''; ?>
		                                        </td> -->
		                                        <td>
		                                            <?php echo isset($row->color_name) ? $row->color_name:''; ?>
		                                        </td>
		                                        <td>
		                                            <?php echo isset($row->color_code) ? $row->color_code:''; ?>
		                                        </td>
                                                <td>
                                                    $<?php echo isset($row->wholesale_price) ? $row->wholesale_price:''; ?>
                                                </td>
                                                <td>
                                                    $<?php echo isset($row->wholesale_price) ? (float)($row->wholesale_price/3):''; ?>
                                                </td>
                                                <td>
                                                    $<?php echo isset($row->net_price) ? $row->net_price:''; ?>
                                                </td>
		                                        <td>
                                                    <?php if(isset($barcode_code) && $barcode_code){ ?>
                                                        <a target="_blank" href="<?php echo base_url() ?>/accounting/products/barcodes/<?php echo $barcode_code ?>" class="btn btn-xs btn-info">Print Barcode</a>
                                                    <?php } ?>
                                                    
		                                        </td> 
		                                    </tr>
		                            <?php $i++; } } ?>
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
</div>
