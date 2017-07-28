<?php
	include 'AUTORISE.php';
	
	function AllManga()
	{
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");
		
		$r = $db->query("SELECT ID_Comix, Name, Cover, Directo FROM MyComicsTable WHERE Directo like 'Papka/MANGA/%' ORDER BY Name");
		
		$myM = "";
		
		while ($row = $r->fetch_assoc())
			$myM .= "<a href='some_comic_viewer.php?id=".$row['ID_Comix']."'><div class='comix-manga-block'><img src='".$row['Cover']."' width=87 height=130 /><br />".$row['Name']."</div></a>";
		
		
		echo "$myM";
	}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Манга</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav2.css" rel="stylesheet">
	<link href="custom.css" rel="stylesheet">
	<link href="styles.css" type="text/css" rel="stylesheet">
	<link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
  </head>
  <body class="MANGA-PG">
	<div id="wrap">
	
  		<?php include 'header.php'; ?>				
		
		<div class="content-block">
			<? AllManga(); ?>
		</div>
		
	</div>

	<?php include 'footer.php'; ?>
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>