<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>CronWeb - SGC-Univ.Net</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A responsive HTML5/PHP crontab manager.">
		<meta name="author" content="Fisher Innovation">

		<link rel="icon" type="image/png" href="/img/Schedule_File.png" />
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="/css/main.css" rel="stylesheet">

		<script src="/js/jquery-2.1.1.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/main.js"></script>
	</head>
        <body>
			<div class="container">
				<div class="masthead">
					<ul class="nav nav-pills pull-right">
						<li class="nav-home<?php print((!isset($_GET['p']) || $_GET['p'] == 'home.php')?' active':''); ?>"><a href="/home.php">Home</a></li>
						<li class="nav-new<?php print(($_GET['p'] == 'new-cronjob.php')?' active':''); ?>"><a href="/new-cronjob.php">New Cronjob</a></li>
						<li class="nav-active<?php print(($_GET['p'] == 'active-cronjobs.php')?' active':''); ?>"><a href="/active-cronjobs.php">Active Cronjobs</a></li>
						<li class="nav-all<?php print(($_GET['p'] == 'all-cronjobs.php')?' active':''); ?>"><a href="/all-cronjobs.php">All Cronjobs</a></li>
						<li class="nav-admin<?php print(($_GET['p'] == 'admin.php')?' active':''); ?>"><a href="/admin.php">Admin</a></li>
					</ul>
					<h1><a href="/home.php">CronWeb v2 <span class="muted">by SGC-Univ.Net</span></a></h1>
				</div>
				<hr>