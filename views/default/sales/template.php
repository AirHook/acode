<!DOCTYPE html>
<html lang="en">

<head>
	
	<title><?php echo @$this->webspace_details->name.(@$this->page_details->title ? ' | '.$this->page_details->title : (@$page_title ? ' | '.$page_title: '')); ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
	<META HTTP-EQUIV="EXPIRES" CONTENT="0">
	<meta name="description" content="<?php echo @$this->webspace_details->description.(@$this->page_details->description ? ', '.$this->page_details->description : '').(@$page_description ? ', '.@$page_description : ''); ?>" />
	<meta name="keywords" content="<?php echo @$this->webspace_details->keywords.(@$this->page_details->keywords ? ', '.$this->page_details->keywords : '').(@$page_keywords ? ', '.@$page_keywords : ''); ?>" />
	<meta name="author" content="Instyle" />
	<meta name="subject" content="<?php echo $this->config->item('site_subject'); ?>" />
	<meta name="coverage" content="worldwide" />
	<meta name="Content-Language" content="english" />
	<meta name="resource-type" content="document" />
	<meta name="robots" content="all,index,follow" />
	<meta name="classification" content="<?php echo $this->config->item('site_name'); ?>" />
	<meta name="rating" content="general" />
	<meta name="revisit-after" content="10 days" />
	<link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon"/>
	<link href="<?php echo base_url('assets/default'); ?>/style/main.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/default'); ?>/style/style_b.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/default'); ?>/style/style.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/default'); ?>/assets/css/style_default.css" rel="stylesheet" type="text/css"/>

	<?php if (ENVIRONMENT === 'development') { ?>
	<script type="text/javascript" src="<?php echo base_url('assets/custom'); ?>/jscript/jquery-3.2.1.min.js"></script>
	<?php } else { ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<?php } ?>
	
	<script type="text/javascript" src="<?php echo base_url('assets/default'); ?>/assets/js/jstools.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/default'); ?>/js/stayontop.js"></script>

	<?php echo @$jscript; ?>

	<style>
		body { vertical-align:top; }
		td { vertical-align:top; }
		.left { line-height:20px; font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; }
		.left a { color:#999999; text-decoration:none; }
		.left a:hover { color:#CC0000; text-decoration:none; }
		
		div.pagination {
			padding: 3px 0px 3px 3px;
			margin: 2px 0px 3px 17px;
			display: inline;
		}

		div.pagination a {
			padding: 2px 5px 2px 5px;
			margin: 2px 2px 2px 2px;
			border: 1px solid #996600;
			text-decoration: none; /* no underline */
			color:#666666;
		}
		div.pagination a:hover, div.pagination a:active {
			border: 1px solid #CC3300;

			color: #000;
		}
		div.pagination span.current {
			padding: 2px 5px 2px 5px;
			margin: 2px;
			border: 1px solid #888888;
			font-weight: bold;
			background-color: #CC3300;
			color: #FFF;
			}
		div.pagination span.disabled {
			padding: 2px 5px 2px 5px;
			margin: 2px;
			border: 1px solid #EEE;

			color: #DDD;
		}
		div.pagination a.viewall {
			font-family:Arial, Helvetica, sans-serif;
			font-size:11px; font-weight:normal;
			text-align:justify;
			text-decoration:none;
			padding: 2px 5px 2px 5px;
			margin: 2px;
			border: 1px solid #EEE;
			color: #DDD;
		}

		.faceted_search { font-size:9px; line-height:10px; font-family:"tahoma"}

		#dvloader {
			position: fixed;
			z-index: 99;
			top: 0px;
			left: 0px;
			background-color: black;
			width: 100%;
			height: 100%;
			filter: Alpha(Opacity=60);
			opacity: 0.6;
			-moz-opacity: 0.6;
			text-align: center;
			padding-top: 350px;
		}
		#div_loader {
			position: fixed;
			z-index: 99;
			top: 0px;
			left: 0px;
			background-color: black;
			width: 100%;
			height: 100%;
			filter: Alpha(Opacity=40);
			opacity: 0.6;
			-moz-opacity: 0.6;
			text-align: center;
		}
		#img_loader {
			position: relative;
			margin: 0 50% 0;
			z-index: 200;
			padding: 20px;
			background-color: black;
			border: 1px solid #9a9a9a;
			width: 220px;
			text-align: center;
			color: white;
			font-family: Verdana; 
		}
		#img_loader p {
			margin: 0;
			padding: 10px 0 0;
			font-size: 12px;
		}
		
		#dvloader2 {
			position: fixed;
			z-index: 99;
			top: 0px;
			left: 0px;
			background-color: transparent;
			width: 100%;
			height: 100%;
			text-align: center;
			padding-top: 350px;
		}
		
		.dialog_runway_video {
			position: fixed;
		}
	</style>

	<?php
	// place google analytics code here
	if (ENVIRONMENT === 'production')
	{
		echo @$this->webspace_details->options['google_analtyics'] ?: $this->config->item('google_analtyics');
	}
	?>

	<?php
		echo isset($function_reset_checkboxes) ? $function_reset_checkboxes : '';
	?>

</head>

<body <?php echo isset($onload_scripts) ? $onload_scripts : ''; ?>>

<?php echo isset($div_loader) ? $div_loader : ''; ?>

	<table border="0" cellspacing="0" cellpadding="0" width="100%">

		<?php
		/*
		| -------------------------------------------------------------------------------
		| Top nav
		*/
		?>
		<tr><td id="headblackbg" style="height: 40px;">
		
			<?php $this->load->view('default/sales/top_nav'); ?>
			
		</td></tr>

		<?php
		/*
		| -------------------------------------------------------------------------------
		| Content Section (this row contains content and footer and footnote
		*/
		?>
		<tr><td>

			<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
			
				<?php
				/*
				| -------------------------------------------------------------------------------
				| Content section
				*/
				?>
				<tr><td>
				
					<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0px;">
					
						<?php
						/***********
						 * Step Process Top Navigation
						 */
						?>
						<tr><td colspan="2">
						
							<?php $this->load->view('default/sales/step_process_navigation'); ?>
							
						</td></tr>
						
						<tr>
							<?php
							/***********
							 * Left sidebar
							 */
							?>
							<td width="200" style="background: #F0F0F0;">
								<?php $this->load->view('default/sales/sidebar'); ?>
							</td>
							
							<?php
							/***********
							 * Right content area - spans two (2) rows
							 */
							?>
							<td rowspan="2" style="padding-left:5px;">
							
								<?php
								/**********
								 * Notification area
								 */
								?>
								<div>
								<?php
									/**********
									 * Let check if sales user has previously selected items on record
									 * This usually happens when they have selected items and were not able to send it
									 */
									?>
									<?php if (
										isset($this->sales_user_details->options['selected']) 
										&& ! empty($this->sales_user_details->options['selected'])
										&& isset($this->sales_user_details->options['last_activity']) 
										&& @strtotime(@date('Y-m-d', $this->sales_user_details->options['last_activity'])) < @strtotime(@date('Y-m-d', time()))
										&& $file != 'summary_view'
									) { ?>
									<div class="temp_notice" style="padding:10px 20px;background:pink;margin-bottom:20px;color:red;">
										Your selections from a previous session is still in record.<br />
										<a href="<?php echo site_url('sales/view_summary'); ?>">Click here to REVIEW</a> them. Or, <a href="<?php echo site_url('sales/clear_items'); ?>">click here to RESET</a> and start a new selection instead.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'no_products') { ?>
									<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
										Please note that there are currently no products available for the respective designer <?php echo $this->sales_user_details->designer_name; ?>. Other sections of this program is not available at this time. Please contact your admin about this.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'error_sending_package') { ?>
									<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
										There was an error sending package or linesheet. Please try again.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
									<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
										There was an error in the category. Please try again.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'error_creating_package') { ?>
									<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
										There was an error creating new sales package. Please try again.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'reset_select_items') { ?>
									<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
										You have no more items in your cart or selection. Please choose a category and start selecting items.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('success') == 'sales_package_sent') { ?>
									<div style="padding:10px 20px;background:#7cc576;margin-bottom:30px;color:red;">
										Sales package successfully sent.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('success') == 'linesheet_sent') { ?>
									<div style="padding:10px 20px;background:#7cc576;margin-bottom:30px;color:red;">
										Linesheet successfully sent.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('flash-message')): ?>
									<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">
										<?php echo $this->session->flashdata('flash-message'); ?>
									</div>
									<?php endif; ?>
								</div>
								
								<?php if ($file == 'dashboard') { ?>
								<div style="color:red;margin:0 0 0 15px;font-size:1.1em;">
									Add items to the package by going to each subcategory and checking items boxes to send a line sheet<br />
									your email address will receive a cc mail automatically for your recordss
								</div>
								<br />
								<?php } ?>
								
								<?php $this->load->view('default/sales/'.$file); ?>
								
							</td>
							
						</tr>
					</table>
					
				</td></tr>
			  
			</table>
		</td></tr>
		
		<tr><td>
		</td></tr>
		
	</table>
	
	<!-- LOADING -->
	<div class="modal fade bs-modal-sm" id="modal-loading" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
					<h1 class="modal-title">Loading...</h1>
				</div>
				<div class="modal-body text-center" style="text-align:center;">
					<p class="modal-body-text"></p>
					<img src="<?php echo base_url('assets/default'); ?>/images/loadingAnimation.gif" />
					<i class="fa fa-spinner fa-spin fa-3x text-danger" aria-hidden="true" style="margin:35px 0;"></i>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal --> 
	
	<?php
	/*
	| -------------------------------------------------
	| ---> Loader GIF image
	| used on as need basis
	| currently used by edit_product_details_view.php javascript of onclick function of submit button
	*/
	?>
	<div style="display:none" id="div_loader"></div>
	<div style="display:none" id="img_loader">
		<span>
			<img src="<?php echo base_url(); ?>images/loadingAnimation.gif" />
			<p>Processing request...</p>
		</span>
	</div>

</body>
</html>
