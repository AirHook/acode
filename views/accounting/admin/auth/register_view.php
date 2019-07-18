
<div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"><?php lang('heading_RP'); ?></h1>

            </div>
            <h3><?php lang('heading_register_to_app'); ?></h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" method="POST" action="<?php echo base_url().'auth/register' ?>">
                <?php
                if(isset($error_message) && !empty($error_message)) {                   
                    echo '<div class="alert alert-danger">'.$error_message.'</div>';
                }
                ?>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" name="name" required="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name="username" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password"  name="password" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password"  name="confirm_password" required="">
                </div>
                <div class="form-group">
                        <div class="checkbox i-checks"><label> <input name="agree_terms" type="checkbox"><i></i> <?php lang('lab_agree_terms_policy'); ?> </label></div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary block full-width m-b"><?php lang('lab_register'); ?></button>

                <p class="text-muted text-center"><small><?php lang('lab_already_have_account'); ?></small></p>
                <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url(); ?>auth/login"><?php lang('lab_login'); ?></a>
            </form>
            <p class="m-t"> <small><?php lang('lab_lnspinia_welcome'); ?> &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>resources/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>
</html>