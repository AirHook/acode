<?php $controller = &get_instance(); ?>
<div class="page-holder w-100 d-flex flex-wrap">
    <div class="container-fluid px-xl-5">
      <section class="py-5">
        <div class="row">
            <div class="col-lg-8 mb-5">
                <span>
                  <?php 
                  $success=$this->session->flashdata('success');
                  if (isset($success)){
                    echo '<div class="alert alert-success alert-dismissable"> ';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                    print_r($success);
                    echo'</div>';
                  } ?>
                  </span>
                  <span>
                  <?php 
                      $errors=$this->session->flashdata('errors');
                      if(isset($errors)){
                        echo '<div class="alert alert-danger alert-dismissable"> ';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                        print_r($errors);
                        echo'</div>';
                  } ?>
                </span>
                <div class="card">
                  <div class="card-header">
                    <h3 class="h6 text-uppercase mb-0">Change Password</h3>
                  </div>
                  <div class="card-body">
                    <form action="<?php echo base_url('erp/admin/setting/changePassword') ?>" method="POST">
                      <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name()?>" value="<?php echo $controller->security->get_csrf_hash()?>" />
                        <div class="row">
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Old Password</label>
                               <input type="password" name="old_password" required="" class="form-control">
                             </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>New Password</label>
                               <input type="password" name="new_password" required="" class="form-control">
                             </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Repeat Password</label>
                               <input type="password" name="repassword" required="" class="form-control">
                             </div>
                           </div>
                        </div>
                        <div class="form-group">       
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
      </section>
    </div>
</div>    