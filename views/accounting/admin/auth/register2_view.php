
<div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"><?php lang('heading_RP') ?></h1>

            </div>
            <h3>Setup Store Information</h3>
            <form class="m-t" role="form" method="POST" action="<?php echo base_url().'auth/register' ?>">
                <?php
                if(isset($error_message) && !empty($error_message)) {                   
                    echo '<div class="alert alert-danger">'.$error_message.'</div>';
                }
                ?>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Title for App" name="title" required="">
                </div>
                <div class="form-group">
                    <select class="form-control" name="language">
                       <option value="english">English</option>
                       <option value="french">French</option>
                       <option value="spanish">Spanish</option>
                    </select>
                </div>
                <button type="submit" name="save_store" class="btn btn-primary block full-width m-b">Submit</button>
            </form>
            <p class="m-t"> <small><?php lang('lab_lnspinia_welcome') ?> &copy; 2014</small> </p>
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