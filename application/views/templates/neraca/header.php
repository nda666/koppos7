<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=isset($page_title) ? 'Koppos 7 - '.$page_title : 'Koppos 7';?></title>
		<!-- Bootstrap + sites CSS & fontawesome css -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/fontawesome/css/font-awesome.min.css') ?>">
		<link rel="stylesheet" href="<?php echo base_url('/assets/sites/css/master.css') ?>">


		<script type="text/javascript" src="<?=base_url('assets/require-js/require.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('assets/sites/js/config.js')?>"></script>