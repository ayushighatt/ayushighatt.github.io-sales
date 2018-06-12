<!DOCTYPE html>
<html>
	<head>
			<title>Sales Order Management System</title>

		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		
	</head>
	<body>

		<br />
		<div class="container-fluid">
			<h2 align="center">Sales Order Management System</h2>

			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
					<a href="index.php" class="navbar-brand">Home</a>
					</div>
					<ul class="nav navbar-nav">
					
					<?php
					if($_SESSION['type'] == 'master')
					{
					?>
						<li><a href="user.php">User</a></li>
						<li><a href="category.php">Category</a></li>
						<li><a href="brand.php">Brand</a></li>
						<li><a href="product.php">Product</a></li>
						<li><a href="stock.php">Stock</a></li>
						<li><a href="customer.php">Customer</a></li>
						<li><a href="order.php">Order</a></li>

					<?php
					}
					?>

					<?php
					if($_SESSION['type'] == 'stock')
					{
					?>
						<li><a href="stock.php">Update Stock</a></li>
					<?php
					}
					?>
					
					<?php
					if($_SESSION['type'] == 'order')
					{
					?>
						<li><a href="order.php">Order</a></li>
					<?php
					}
					?>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="label label-pill label-danger count"></span> <?php echo $_SESSION["user_name"]; ?></a>
							<ul class="dropdown-menu">
								<li><a href="profile.php">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>

				</div>
			</nav>
			