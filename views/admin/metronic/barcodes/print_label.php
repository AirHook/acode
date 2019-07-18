<!doctype html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta name="viewport" content="initial-scale=1.0"/>
      <title></title>
   <style>
.signature{
  margin-top: 39px;
}
.signature h4{
      vertical-align: top;
    margin-top: -9px;
    margin-bottom: 12px;
}
.barcode {
  margin-top: 20px;
  margin-bottom: 21px;text-align:center;
}
.barcode img{
  width:150px;
}
      html, body {
      height: 100%;
      font-family: SFS, Arial, sans-serif;
      color: #000000;
      font-size: 14px;
      overflow-x:hidden; 
   }
   .input__box h3{
    
   }
   input{
      padding: 0;
    border: none;
    height: auto !important;
    border-bottom: 1px solid #ccc;
    margin-bottom: 16px;
    padding-bottom: 0px;
   }
.middle_box{
    max-width: 950px;
padding-top: 80px !important;
      margin: 83px auto 0;
}
.logo_p img {
    width: 133px;
}
.healthcare {
    text-align: center;
}.healthcare h1 {
    text-align: center;
    font-size: 20px;
    line-height: 1.5;
    margin: 0;
    color: #000;
}.healthcare h2 {
  color: #000;
    font-size: 27px;
    letter-spacing: 0;
    line-height: 1.2;
    margin-bottom: 0 !important;
}.healthcare b {
  color: #000;
    font-size: 14px;
}.healthcare h2 {
  color: #000;
    font-size: 18px;
    letter-spacing: 0;
    line-height: 1.2;
    margin-bottom: 0 !important;
    margin: 0;
}
.logo_p {
    float: left;
    width: 29%;
    text-align: right;
}
.healthcare {
    float: right;
    width: 57%;
}
.col-sm-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
.row {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.label-right {
    padding: 0;
}
.col-sm-4 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 47.333333%;
    max-width: 48.333333%;
}
.donorcard .register-left h3 {
    font-size: 15px;
}
.label-right h3 {
    text-align: right;
    font-size: 19px;
    font-weight: 600;
    margin: 0 13px 0 0;
    color: #000;
}
.col-sm-8 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 49.666667%;
    max-width: 61.666667%;
}
.input__box h3, .input__box select {
    width: 100%;
    margin: 0 0 9px;
    font-size: 18px;
}
/*.middle_form{
  max-width: 800px;
    margin: 23px auto;
}*/
.input__box h3 {
    border-bottom: 1px solid #ccc;
    font-weight: 600;
    margin: 0 0 17px !important;
    text-align: left;
    font-size: 18px;
    color: #000;
}
.registration {
    margin-top: 39px;
    margin-bottom: 11px !important;
}
</style>
</head>
  <body>
    <?php if(isset($barcode_code)){ ?>
      <div class="middle_form" style="padding-top: 50px !important;margin-left:20px !important">
          <div style="width: 2in;height: .8in;word-wrap: break-word;overflow: hidden;margin:0 auto;text-align:center;font-size: 9pt;line-height: 1em;page-break-after: always;padding: 10px;">
              <?php echo '<img src="data:image/png;base64,' . base64_encode($barcode_code) . '">'; ?><br>
              <?php echo isset($code) ? $code :''; ?>
          </div>
      </div>
    <?php } ?>
  </body>
</html>