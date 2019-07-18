<?php
/****************
 * Some controllers load 'template' so we use this file and var to
 * redirect files and pages. This file needs to be removed on code clean up
 */
 $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template');
?>
