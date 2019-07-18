<?php $controller = &get_instance(); ?>
<div class="page-holder w-100 d-flex flex-wrap">
    <div class="container-fluid px-xl-5">
      <section class="py-5">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="text-uppercase mb-0">All users</h6>
                </div>
                <div class="card-body">                          
                    <table class="table table-striped table-sm card-text">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($all_users)){
                                    foreach(array_reverse($all_users) as $key => $single_user) { ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo isset($single_user->first_name) ? $single_user->first_name.' '.$single_user->last_name:'';?></td>
                                        <td><?php echo $single_user->email;?></td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-xs">Delete</a>
                                        </td>
                                    </tr>
                            <?php }  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </section>
    </div>
</div>    