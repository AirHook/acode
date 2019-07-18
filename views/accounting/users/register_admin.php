<?php $controller =& get_instance(); ?>
<div class="wrapper animated fadeInRight">
     <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					        <div class="col-sm-12 ">
						        <div class="row">
						        	<div class="col-sm-12">
						        		<span>
					                       <?php $controller->showFlash(); ?>
					                     </span>
						        		<div class="panel panel-info">
							        	<div class="panel panel-heading">
						        		<?php if(isset($model['id'])) {?>
											<?php lang('heading_user_create'); ?>
								        <?php } else { ?>
											<?php lang('heading_user_create'); ?>
										<?php } ?>
									<a href="<?php echo base_url('accounting/admin/index') ?>" class="btn btn-back pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;Go Back</a>
							        	</div>
							        	<?php if(isset($model['id'])) { ?>
						               	<form action="<?php echo base_url('accounting/admin/editAdmin') ."/". $this->uri->segment(4) ?>" method="POST" role="form">
						                     <input type="hidden" name="id" value="<?php echo isset($model['id']) ?  $model['id'] :''; ?>">
						               <?php } else { ?>
						               	<form action="<?php echo base_url('accounting/admin/editAdmin') ?>" method="POST" role="form">
						               <?php } ?>
						               <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >
							        	<div class="panel panel-body">
					                            <div class="row">
					                            <div class="form-group col-lg-6">
					                                <label><?php lang('lab_fname'); ?></label>
					                                <input type="text" placeholder="First Name" class="form-control" value="<?php echo isset($model['first_name']) ? $model['first_name'] :''; ?>" name="first_name">
					                            </div>
					                            <div class="form-group col-lg-6">
					                                <label><?php lang('lab_lname'); ?></label>
					                                <input type="text"  class="form-control" name="last_name" value="<?php echo isset($model['last_name']) ? $model['last_name'] :'';?>" placeholder="Last Name">
					                            </div>
					                            <div class="form-group col-lg-6">
					                                <label><?php lang('lab_email_address'); ?></label>
					                                <input type="email"   placeholder="Email" class="form-control" value="<?php echo isset($model['email']) ? $model['email'] :'';?>" name="email">
					                            </div>
					                            <div class="form-group col-lg-6">
					                                <label><?php lang('lab_password'); ?></label>
					                                <input type="password" value="<?php echo isset($model['password']) ? $model['password']:''; ?>" id="" placeholder="Password" class="form-control" name="password">
					                            </div>
					                            <div class="form-group col-lg-6">
					                                <label><?php lang('lab_company_name'); ?></label>
					                                <input type="text" value="<?php echo isset($model['company_name']) ? $model['company_name'] :'';?>" id="" placeholder="Company Name" class="form-control" name="company_name">
					                            </div>
					                            <div class="form-group col-lg-6">
					                                <label><?php lang('lab_company_address'); ?></label>
					                                <textarea  class="form-control" name="company_address"><?php echo isset($model['company_address']) ? $model['company_address']:''; ?>
					                                </textarea>
					                                
					                            </div>
					                           
					                            </div>
					                             <div class="row">
							                   		<div class="col-sm-4">
								                	<input type="submit" value="<?php lang('btn_save'); ?>" name="submit" class="form-btn btn btn-shadow btn-primary "/>
								                	&nbsp;&nbsp;
								                	<a href="<?php echo base_url('accounting/admin/index') ?>" class="form-btn btn  btn-primary btn-default1 ">
								                	<?php lang('btn_cancel'); ?>
								                	</a>
								                	</div>
								                </div>
					                        </form>
								        </div>
						                    
								        </div>
								    </div>
						        </div>
						    </div>
						</div>
					</div>
			</div>
	    </div>
	</div>
</div>
	