<?php

$this->load->view('GI3/inc/top');    // Meta data and header
$this->load->view('GI3/' . $file);  // Page Content
$this->load->view('GI3/inc/footer'); // Footer and scripts
if (isset($jscripts))
    $this->load->view('GI3/' . $jscripts);     // Javascript code respective of page
$this->load->view('GI3/inc/bottom'); // Close body and html tags	

