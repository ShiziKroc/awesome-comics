<?php
	include 'AUTORISE.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//RU">
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Мой кабинет</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav2.css" rel="stylesheet">
	<link href="custom.css" rel="stylesheet">
	<link href="styles.css" type="text/css" rel="stylesheet">
	<link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
	
  </head>
  
  <body>
	<div id="wrap">
	
  		<?php include 'header.php'; ?>		
		
		<div class="content-block">
			
			<?
			if ($auth->isAuth() != 0) {
				$auth->getAllInfo();
			}
			else echo "<script>window.location.href='index.php';</script>";
			?>			
			
		</div>
		
	</div>

	<?php include 'footer.php'; ?>
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>