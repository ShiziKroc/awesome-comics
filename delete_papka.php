<?php
	
	include 'AUTORISE.php';
	
	//вывод списка комиксов
	function GETSOME2($pu)
	{
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");
		
		$r = $db->query("SELECT ID_Comix, Name, Cover, Directo FROM MyComicsTable WHERE Directo LIKE '%$pu%' ORDER BY Name");
		
		$myM = "";
		
		while ($row = $r->fetch_assoc())
			echo "<option value='".$row['Name']."'>".$row['Name']."</option><br>";		
		
	}
	
	//функция удаления папки
	function removeDirectory($dir) {
		if ($objs = glob($dir."/*")) {
		   foreach($objs as $obj) {
			 is_dir($obj) ? removeDirectory($obj) : unlink($obj);
		   }
		}
		rmdir($dir);
	}
	
	//кнопка удаление папки
	if ( isset( $_POST['DeleteMePLZ'] ) )
	{
		if( isset ( $_POST['DIRS_CO'] ) )
		{
			$db = new mysqli("localhost", "root", ""); 
			$db->select_db ("MySomeBD");
			$NA = $_POST['DIRS_CO'];
			$r = $db->query("SELECT ID_Comix, Cover FROM MyComicsTable where Name='$NA'");
			$row = $r->fetch_assoc();
			
			if(!is_null($row['Cover']))
				unlink($row['Cover']);
			
			$path = "Papka/";
			
			if($_POST['MyTu'] == 1){	$path .= "COMIX/";  }
			else{	$path .= "MANGA/";	}
			
			$mySubPath = $_POST['DIRS_CO'];	

			$mySubPath = rus2translit($mySubPath);
			$mySubPath = simvol2translit($mySubPath);
			
			
			$path .= $mySubPath;	
			
			removeDirectory($path);
			
			$db->query("DELETE FROM MyComicsTable where Name='$NA'");		
			echo "<script>window.alert('Комикс удален');window.location.href='delete_papka.php';</script>";
		}
		else
		{
			echo "<script>window.alert('Сделайте выбор!');</script>";
		}
	}
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Админка</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/nav2.css" rel="stylesheet">
		<link href="custom.css" rel="stylesheet">
		<link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
    </head>
	
	<body>
	<div id="wrap">
			
			<?php include 'header_admin.php'; ?>		
		
			<div class="content-block">
				<?php 
				if ($auth->isAuth() != 1) { // Если пользователь не админ
					echo "<script>window.location.href='index.php';</script>"; // перенаправляем его на главную страницу
				}				
				else { //Если админ, показываем форму
				?>
					
					<?php include 'menu_admin.php' ?>
				
					<br />
				
					<form method="POST" enctype="multipart/form-data">
					<table border=3 align=center>
						<tr align="center">
							<td><b>Удалить комикс</b></td>
						</tr>
						<tr align="center">
							<td>
								<!--Списки комиксов-->
								<select name="MyTu" size="1" id="TY">
									<option value="1">Комиксы</option>
									<option <? if(isset ( $_POST['submitComTUU'] )) if($_POST['MyTu']== 2){ echo "selected='selected'";}?>  value="2">Манга</option>
								</select>
								<input type="submit" name="submitComTUU" value="Выбрать"/>
								<br />
								<?
									if ( isset ( $_POST['submitComTUU'] ) ){								
										$TIP = $_POST['MyTu'];									
										echo "<font size='2px'><b>Выберите какой комикс удалить : </b></font><br /><select size='5' name='DIRS_CO'>";
										$path = "Papka/";
										$mySubPath;
										$I;									
										if($TIP == 1)
										{
											$path .= "COMIX/";
											echo "<option disabled>Комиксы</option>";
											$I = 0;
										}
										else
										{
											$path .= "MANGA/";
											echo "<option disabled>Манга</option>";
											$I = 1;
										}									
										GETSOME2($path);									
										echo "</select><br / ><br / ><input type='submit' name='DeleteMePLZ' value='Удалить'>";
									}
									else{	echo "<br /><p>Выберите тип</p>";	}
								?>
							</td>
						</tr>
					</table>
					</form>
				<?php } ?>	
			</div>
			
	</div>

	<?php include 'footer.php'; ?>		
	
	</body>
</html>
