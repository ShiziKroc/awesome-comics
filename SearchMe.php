<?php
	include 'AUTORISE.php';
	
	function Result()
	{
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");
		
		$parame = $_POST['mySearchParam'];
		
		$r = $db->query("SELECT ID_Comix, Name, Cover, Directo FROM MyComicsTable WHERE Name LIKE '%$parame%' ORDER BY Name");
		
		$myM = "";
		$row_cnt = $r->num_rows;
		
		if ($row_cnt != 0)
		{
			$myM .= "Результаты поиска по: <b>".$_POST['mySearchParam']."</b><br/><br/>";
			while ($row = $r->fetch_assoc())
				$myM .= "<a href='some_comic_viewer.php?id=".$row['ID_Comix']."'><div class='comix-manga-block'><img src='".$row['Cover']."' width=87 height=130 /><br />".$row['Name']."</div></a>";
		}
		else $myM = "Поиск не дал результатов";
		
		echo "$myM";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//RU">
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Поиск</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav2.css" rel="stylesheet">
	<link href="custom.css" rel="stylesheet">
	<link href="styles.css" type="text/css" rel="stylesheet">
	<link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
  </head>
  
  <body class="SEARCH-PG">
	<div id="wrap">
	
  		<?php include 'header.php'; ?>		
		
		<div class="content-block">
			<form method="POST" enctype="multipart/form-data">
			<input type="text" name="mySearchParam" size="20"  placeholder = "Поиск" required  />
			<input type="submit" name="SeachThis" value="Поиск"/>
			<br /><br />
			<div style="margin: auto; padding-left:5px; padding-right:10px;">
			<? 
				if(isset($_POST['SeachThis']))
				{
					Result(); 
				}
				else echo "Введите парамер для поиска";
			?>
			</form>
			</div>
		</div>
		
	</div>

	<?php include 'footer.php'; ?>	
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>