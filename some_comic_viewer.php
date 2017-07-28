<?php
	
	function myItems(){
		$nom = $_GET['id'];
		$schet = 0;
		$myIT = "";
		
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");
		$r = $db->query("SELECT ImageNam, Directo, Name FROM ComixPages, MyComicsTable where ID_CMX='$nom' and ID_Comix='$nom'");
		
		while ($row = $r->fetch_assoc())
		{
			if($schet == 0)
			{
				$myIT.= "<div class='active item' style='text-align: center; !important;'><img src='".$row['Directo']."/".$row['ImageNam']."' /></div>";
			}
			if($schet > 0)
			{
				$myIT.= "<div class='item' style='text-align: center; !important;'><img src='".$row['Directo']."/".$row['ImageNam']."'/></div>";
			}
			
			$schet++;
		}	
		
		echo "$myIT";
	}
	
	function MaTitle()
	{
		$nom = $_GET['id'];
		$myT = "";
		
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");
		$r = $db->query("SELECT Name FROM MyComicsTable where ID_Comix='$nom'");
		
		while ($row = $r->fetch_assoc())
		{
			$myT = $row['Name'];
		}	
		
		echo "$myT";
	}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?MaTitle();?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav2.css" rel="stylesheet">
	<link href="custom.css" rel="stylesheet">
	<link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="background: #333;">
  			<div class="navbar navbar-inverse navbar-static-top">
				<div class="container">
					<div class="navbar-header"></div>
						<button class="navbar-toggle" data-toggle="collapse" data-target="#myMenu">
							<span class="sr-only">Навігація</span><!-- Screen only-->
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					<div class="collapse navbar-collapse" id="myMenu">
						<ul class="nav navbar-nav">
							<li><a href="index.php">Главная</a></li>
						</ul>
				</div>
			</div>
		</div>
				
		
		<div id="myCarousel" class="carousel slide" data-interval="false" data-wrap="false" data-ride="carousel" style="margin-top: -20px; background: #333;">
		  <!-- Carousel indicators -->
		  <ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
		  </ol>   
		  <!-- Carousel items -->
			<div class="carousel-inner">
				 
				 <? myItems(); ?>  
			  
			  
				<!-- Carousel nav -->
				<a class="carousel-control left" href="#myCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="carousel-control right" href="#myCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>