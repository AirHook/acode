  <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">EloERP</h1>

            </div>
            <h3>Welcome to EloERP</h3> 
            <p>
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" method="POST" action="<?php echo base_url(); ?>auth/login_submit">
                <?php
                if(isset($error_message) && !empty($error_message)) {                   
                    echo '<div class="alert alert-danger">'.$error_message.'</div>';
                }
                ?>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required="" value="<?php echo isset($model['username']) ? $model['username'] : ''; ?>">
                </div>
                <div class="form-group">
                    <input type="password" value="<?php echo isset($model['password']) ? $model['password'] : ''; ?>" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="<?php echo base_url(); ?>admin/auth/forgotPassword"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url(); ?>auth/register">Create an account</a>
            </form>
            <p class="m-t"> <small>EloERP &copy; 2019</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>resources/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>

</body>

</html>
