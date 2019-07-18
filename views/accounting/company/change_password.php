<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
		            <div class="scroll-element full-height-scroll">
		               <!-- <div class="row">
				        	<div class="col-sm-offset-5">
				        		<a href="" class="btn btn-info"><i class="fa fa-reply">Go Back</i></a>
				        	</div>
				        </div> -->
				        <br>
					    <div class="row">
					        <div class="col-sm-12 ">
						        <div class="row">
						        	<div class="col-sm-6">
						        		<span>
					                       <?php $controller->showFlash(); ?>
					                     </span>
						        		<div class="panel panel-info">
							        	<div class="panel panel-heading">
											Change Password
							        	</div>
						               <form action="<?php echo base_url('accounting/company/changePassword') ?>" method="POST" role="form">
							        	<div class="panel panel-body">
							        		<div class="row">
							        			<div class="col-sm-12">
									        		<div class="">
									        			<div class="row">
									        				<div class="col-sm-12">
									        					<div class="form-group">
									        					    <label>Old Password</label>
									        					    <input required="" type="password" name="old_password" class="form-control" placeholder="Old password">
									        					</div>
									        				</div>
									        			</div>
									        			<div class="row">
									        				<div class="col-sm-12">
									        					<div class="form-group">
									        					    <label>New Password</label>
									        					    <input required="" type="password" name="password" class="form-control" placeholder="New password">
									        					</div>
									        				</div>
									        			</div>
									        			<div class="row">
									        				<div class="col-sm-12">
									        					<div class="form-group">
									        					    <label>Confirm Password</label>
									        					    <input required="" type="password" name="cpassword" class="form-control" placeholder="Confirm password">
									        					</div>
									        				</div>
									        			</div>
									        		</div>
							        		    </div>
							        		   </div>
							        		    <div class="row">
							                   		<div class="col-sm-12">
								                	<input type="submit" value="Save" name="submit" class="form-btn btn btn-shadow btn-primary "/>
								                	&nbsp;&nbsp;
								                	<a href="" class="form-btn btn  btn-primary btn-default1 ">
								                		Cancel
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
	