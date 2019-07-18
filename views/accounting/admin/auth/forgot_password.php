
    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Forgot password</h2>
                    <?php
                    if(isset($error_message) && !empty($error_message)) {          
                        echo '<div class="alert alert-danger">'.$error_message.'</div>';
                    } else if(isset($success_message) && $success_message != '') {
                        echo '<div class="alert alert-success">'.$success_message.'</div>';
                    }
                    ?>

                    <div class="row">

                        <div class="col-lg-12">
                            <form method="POST" class="m-t" role="form" action="<?php echo base_url(); ?>admin/auth/forgotPassword">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="<?php echo $this->lang->line('email_label') ?> address" required="">
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary block full-width m-b">Send new password</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright Repairpro
            </div>
            <div class="col-md-6 text-right">
               <small>© 2014-2015</small>
            </div>
        </div>
    </div>

</body>

</html>
