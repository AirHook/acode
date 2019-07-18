<?php

	define('THEME_FOLDER', 'roden2');

	$this->load->view(THEME_FOLDER.'/sales/template_top');

	$this->load->view(THEME_FOLDER.'/sales/template_header');
	
	$this->load->view(THEME_FOLDER.'/sales/'.$file);

	$this->load->view(THEME_FOLDER.'/sales/template_footer');

	$this->load->view(THEME_FOLDER.'/sales/template_bottom');
