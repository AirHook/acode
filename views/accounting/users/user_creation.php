<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					        <div class="col-sm-12">
					        <!-- <div class="row">
					        	<div class="col-sm-12">
					        		<a href="#" class="pull-right btn btn-info"><i class="fa fa-reply">Go Back</i></a>
					        	</div>
					        </div>
					        <br> -->
						        <div class="row">
						        	<div class="col-sm-12">
						        		<span>
					                       <?php $controller->showFlash(); ?>
					                     </span>
						        		<div class="panel panel-info">
							        	<div class="panel panel-heading">
						        			<?php if(isset($model['id'])) {
						        				lang('heading_user_create');
											
       								        	 } else { 
												lang('heading_user_create');
											 } ?>
							        	</div>
							        	<?php if(isset($model['id'])) { ?>
							        	<?php if(isset($profile) && $profile == 'profile'){ ?>
						               	<form action="<?php echo base_url('accounting/admin/userCreation') ."/". $this->uri->segment(4) ."/". $profile ?>" method="POST" role="form">
						                     <input type="hidden" name="id" value="<?php echo isset($model['id']) ?  $model['id'] :''; ?>">
						                     <?php }else{?>
						                     	<form action="<?php echo base_url('accounting/admin/userCreation') ."/". $this->uri->segment(4) ?>" method="POST" role="form">
						                         <input type="hidden" name="id" value="<?php echo isset($model['id']) ?  $model['id'] :''; ?>">
						                     <?php } ?>
						               <?php } else { ?>
						               	<form action="<?php echo base_url('accounting/admin/userCreation') ?>" method="POST" role="form">
						               <?php } ?>
						               <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >
							        	<div class="panel panel-body">
							        		<div class="row">
							        			<div class="col-sm-12">
									        		<div class="">
									        			<div class="row">
									        				<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_fname'); ?></label>
									        						<input required="" type="text" name="first_name" class="form-control" value="<?php echo isset($model['first_name']) ? $model['first_name'] :''; ?>">
									        					</div>
									        				</div>
									        				<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_lname'); ?></label>
									        						<input required="" type="text" name="last_name" class="form-control" value="<?php echo isset($model['last_name']) ? $model['last_name'] :''; ?>">
									        					</div>
									        				</div>
									        			</div>
									        			<div class="row">
									        				<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_username'); ?></label>
									        						<input required="" type="text" name="email" class="form-control" value="<?php echo isset($model['email']) ? $model['email'] :''; ?>">
									        					</div>
									        				</div>
									        				<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_role'); ?></label>
									        						<select required="" name="role" class="form-control">
									        							<?php
									        							if(!empty($roles)) {
									        								foreach ($roles as $key => $value) {
									        									echo '<option value="'.$value->id.'" ';
									        									echo (isset($model['role']) && $model['role'] == $value->id) ? 'selected' : '';
									        									echo '>'.$value->name.'</option>';
									        								}
									        							}
									        							?>
																	</select>
									        					</div>
									        				</div>
									        			</div>
									        			<?php if(!isset($model['password'])){ ?>
									        			<div class="row">
									        				<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_password'); ?></label>
									        						<input required="" type="password" name="password" class="form-control" value="<?php echo isset($model['password']) ? $model['password'] :''; ?>">
									        					</div>
									        				</div>
									        				<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_retype_password'); ?></label>
									        						<input required="" type="password" name="repassword" class="form-control" value="<?php echo isset($model['repassword']) ? $model['repassword'] :''; ?>">
									        					</div>
									        				</div>
									        			</div>
									        			<?php } ?>
									        			<div class="row">
									        				<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_pho_number'); ?></label>
									        						<input type="MyNumber" class="form-control" name="mobile_no" value="<?php echo isset($model['mobile_no']) ? $model['mobile_no'] :''; ?>">
									        					</div>
									        				</div>
									        				<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_narration'); ?></label>
									        					<textarea class="form-control" name="narration"><?php echo isset($model['narration']) ? $model['narration'] :''; ?></textarea>
									        					</div>
									        				</div>
									        			</div>
									        			<div class="row">
									        				<div class="col-sm-6">
									        					<div class="form-group" style="margin-top: 27px;">
									        					<label></label>
									        						<input type="checkbox" <?php echo (isset($model['active']) && $model['active']==1) ? 'checked':''; ?> value="1" name="active" class="i-checks">
									        						<label><?php lang('lab_active'); ?></label>
									        					</div>
									        				</div>
									        			</div>
									        			<br>
									        		    <div class="row">
									                   		<div class="col-sm-4">
										                	<input type="submit" value="<?php lang('btn_save'); ?>" name="submit" class="form-btn btn btn-shadow btn-primary "/>
										                	&nbsp;&nbsp;
										                	<?php if(!isset($profile)){ ?>
										                	<a href="<?php echo base_url('accounting/admin/allUser') ?>" class="form-btn btn  btn-primary btn-default1 ">
										                		<?php lang('btn_cancel'); ?>
										                	</a>
										                	<?php } ?>
										                	</div>
										                </div>
									        		</div>
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
	