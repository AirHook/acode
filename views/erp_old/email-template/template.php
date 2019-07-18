<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/bootstrap.min.css">
    <style type="text/css">
    html,body,div,span,
h1,h2,h3,h4,h5,h6,
p,blockquote,q,em,img,small,strong,
dl,dt,dd,ol,ul,li,fieldset,form,label,legend{border:0;outline:0;margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent}
body{line-height:1;
font-family: "Open Sans";
}

ol,ul{list-style:none}
:focus{outline:0}
input,textarea{margin:0;outline:0;}
textarea{overflow:auto; resize:none;}
table{border-collapse:collapse;border-spacing:0}
/* End Reset */
/* html5 */
article, aside, details, figcaption, figure, footer, header, hgroup, nav, section { display: block; }
/* Default Font Styles
______________________*/
body, input, select, textarea{
    font-family: "Open Sans";
}
.container{
    max-width: 1275px !important;
    margin: 0 auto;
}
#review-box{
        background: #eeeeee;
        margin-top: 30px;
}
.review-box {
    max-width: 535px;
    margin: 0 auto;
    background: #fff;
    padding: 40px 0 0;
    border: 1px solid #ccc;
    box-shadow: 0 0 7px 0 #ccc;
}

.review-box h3 {
    text-align: center;
    color: #000;
    font-weight: 600;
    margin-bottom: 48px;
    border-bottom: 1px solid #ccc9;
    padding-bottom: 38px;
}
.review-box p{
    margin-bottom: 17px;
    font-size: 16px ;
    padding: 0 20px 0;
    line-height: 1.4;
    text-align: center;
}
.footer_btm{
        background: #88b0ec;
    color: #fff;
    text-align: center;
    padding: 14px !important;
    margin-bottom: 0 !important;
}
.logo-top{
    text-align: center;
}
.logo-top img{
        width: 174px;
    margin-bottom: 26px;
}


</style>
</head>
<body id="review-box">
    <div id="container-fluid">
        <div id="main_warp">
            <div class="container">
                <div class="review-box">
                    <div class="logo-top">
                        <img src="<?php echo base_url('assets/frontend/images/') ?>" alt="">
                    </div>
                    <h3><?php echo isset($tagline) ? $tagline :''; ?></h3>
                    <p><?php echo isset($bodymessage) ? $bodymessage :''; ?></p>
                    <p><?php echo isset($button) ? $button :''; ?></p>
                    <p class="footer_btm">Copyright©<?php echo date('Y') ?> <a style="text-decoration:none;color:#fff" href="<?php echo base_url() ?>"><?php echo isset($sitename) ? $sitename :''; ?></a></p>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="<?php echo base_url() ?>assets/backend/js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>assets/backend/js/jquery-ui.min.js"></script> 
<script src="<?php echo base_url() ?>assets/frontend/js/bootstrap.min.js"></script>
</body>
</html>
