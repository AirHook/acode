<?php
require 'php-barcode-generator-master/vendor/autoload.php';
class Barcode{
  private $generator;
  private $png_generator;
  public function __construct(){
    $this->generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $this->png_generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
  }
  public function generate_barcode($code=null){
  	if($code!=null){
    	// $barcode=$this->generator->getBarcode($code, Picqer\Barcode\BarcodeGeneratorHTML::TYPE_CODE_128);
      $barcode = $this->png_generator->getBarcode($code, \Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_128);
  		return $barcode;
  	}
  }
}
?>