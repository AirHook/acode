<div id="content" role="main">
    <div class="page-header dark larger larger-desc">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Login Page</h1>
                    <p class="page-header-desc">Login to your account or contact us to create one.</p>
                </div><!-- End .col-md-6 -->
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="login.html">Multimedia</a></li>
                        <!--                        <li><a href="#">Shop</a></li>
                                                <li class="active">Login</li>-->
                    </ol>
                </div><!-- End .col-md-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="title-border custom mb40">Login</h2>
                <form action="<?php echo site_url(); ?>"  method="post">
                    <div class="form-group">
                        <label for="username" class="input-desc">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required="">
                    </div><!-- End .from-group -->
                    <div class="form-group mb10">
                        <label for="password" class="input-desc">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
                    </div><!-- End .from-group -->
                    <div class="form-group text-right clear-margin helper-group">
                        <a href="recover-password.html">Forget password?</a>
                    </div><!-- End .form-group -->
                    <div class="form-group mt15-r">
                        <div class="checkbox">
                            <label class="custom-checkbox-wrapper">
                                <span class="custom-checkbox-container">
                                    <input type="checkbox" name="remember" id="remember" value="true">
                                    <span class="custom-checkbox-icon"></span>
                                </span>
                                <span>Remember Me!</span>
                            </label>
                        </div><!-- End .checkbox -->
                    </div><!-- End .form-group -->
                    <div class="form-group">
                        <input type="submit" class="btn btn-custom" value="Login Now">
                    </div><!-- End .from-group -->
                </form>

            </div><!-- End .col-sm-6 -->

            <div class="mb20 visible-xs"></div><!-- space -->

            <div class="col-sm-6">
                <h2 class="title-border custom mb40">Create Account</h2>

                <p>We are a private by invitation organization. We exercise a high degree of fiduaciary trust when engaging our teams to service a client.</p>
                <p>To that end, we request the courtesy of your offices in order to service your requirements more responsibly and answer all concerns in person.</p>
                <p>We invite your input in the short form that follows the link below.</p>
                <p>A representative will be in touch to provide the level of service you deserve.</p>

                <div class="mb10"></div><!-- space -->

                <a href="contact.html" class="btn btn-dark">Create Account</a>
            </div><!-- End .col-sm-6 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb20"></div><!-- space -->

</div>