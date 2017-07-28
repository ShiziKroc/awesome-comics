<?php
	
	include 'AUTORISE.php';
	
	//вывод списка комиксов
	function GETSOME2($pu)
	{
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");
		
		$r = $db->query("SELECT ID_Comix, Name, Cover, Directo FROM MyComicsTable WHERE Directo like '%$pu%' ORDER BY Name");
		
		$myM = "";
		
		while ($row = $r->fetch_assoc())
			echo "<option value='".$row['ID_Comix']."'>".$row['Name']."</option><br>";	
	}
	
	
	//кнопка переименовывание папки комикса
	if ( isset( $_POST['RenameMePLZ'] ) )
	{
		if( (isset ( $_POST['DIRS_CO'] )) and  ($_POST['myDirNameCo'] != "") )
		{
			$db = new mysqli("localhost", "root", ""); 
			$db->select_db ("MySomeBD");
			$path = "Papka/";
			
			if($_POST['MyTu'] == 1){	$path .= "COMIX/";  }
			else{	$path .= "MANGA/";	}
			
			$CO = $_POST['DIRS_CO']; //айди комикса который нужно переименовать
			
			$r = $db->query("SELECT Directo FROM MyComicsTable where ID_Comix='$CO'");
			$row = $r->fetch_assoc();
			$DD = $row['Directo'];
			
			$newName = $_POST['myDirNameCo'];
			$newName = simvol2translit($newName);
			
			$newDirr = rus2translit($newName);
			$newDirr = simvol2translit($newDirr);
			
			$newPath = $path.$newDirr;
			
			$up = mysql_query("UPDATE MyComicsTable SET Name='$newName', Directo='$newPath' WHERE ID_Comix='$CO'");
			rename($DD, $newPath);
			
			echo "<script>window.alert('Комикс переименован');window.location.href='rename_papka.php';</script>";
		}
		else
		{
			echo "<script>window.alert('Сделайте выбор и введите новое название!');</script>";
		}
	}
	
	
	
	//Загрузка обложки в папку на сервере
	if ( isset( $_POST['submitComTypeee'] ) )
	{
		if( (isset( $_POST['DIRS_C'] )) )
		{
			$path = "Covers";		
			if ( $_FILES["uploadfile"]['type'] == 'image/jpeg' or $_FILES["uploadfile"]['type'] == 'image/png' or $_FILES["uploadfile"]['type'] == 'image/gif' )
			{			
				$db = new mysqli("localhost", "root", ""); 
				$db->select_db ("MySomeBD");
					
				$tmp_name = $_FILES["uploadfile"]["tmp_name"];
				// basename() может спасти от атак на файловую систему;
				// может понадобиться дополнительная проверка/очистка имени файла
				$name = basename($_FILES["uploadfile"]["name"]);
				$name = rus2translit($name);
				$name = simvol2translit($name);
				$name = uniqid().$name; //случайное имя обложке
				move_uploaded_file($tmp_name, $path."/$name");
				
				$NA = $_POST['DIRS_C'];
				
				$query2 = "SELECT ID_Comix, Cover FROM MyComicsTable WHERE ID_Comix = '$NA' LIMIT 1";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($sql2);
				unlink($row2['Cover']);
				
				
				
				$NA = $_POST['DIRS_C'];
				$CO = $path."/$name";
					
				$up = mysql_query("UPDATE MyComicsTable SET Cover='$CO' WHERE ID_Comix='$NA'");
				
				echo "<script>window.alert('Обложка комикса изменена!');window.location.href='rename_papka.php';</script>";
			}
			else
			{
				echo "<script>window.alert('Вы выбрали не картинку!');</script>";
			}
		}
		else
		{
			echo "<script>window.alert('Сделайте выбор и выберите обложку!');</script>";
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
		<link href="styles.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
    </head>

	<body>
	<div id="wrap">
	
			<?php include 'header_admin.php'; ?>		
		
			<div class="content-block">
				<?php 
				if ($auth->isAuth() != 1) { // Если пользователь не админ
					echo "<script>window.location.href='index.php';</script>";
				}				
				else { //Если админ, показываем форму
				?>
					
					<?php include 'menu_admin.php' ?>
					
					<br />
					<table border=3 align=center>
						<tr align="center">
							<td><b>Переименовать комикс</b></td>
						</tr>
						<form method="POST" enctype="multipart/form-data">
						<tr align="center">
							<td>
								<!--Списки комиксов-->
								<select name="MyTu" size="1" id="TY">
									<option value="1">Комиксы</option>
									<option <? if(isset ( $_POST['submitComTUU'] )) if($_POST['MyTu']== 2){ echo "selected='selected'";}?> value="2">Манга</option>
								</select>
								<input type="submit" name="submitComTUU" value="Выбрать"/>
								<br />
								<?
									if ( isset ( $_POST['submitComTUU'] ) ){								
										$TIP = $_POST['MyTu'];									
										echo "<font size='2px'><b>Выберите назначение загрузки : </b></font><br /><select size='5' name='DIRS_CO'>";
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
										echo "</select><br / >
										<tr align='center'><td><font size='2px'><b>Новое имя : </b></font><br>
										<input type='text' name='myDirNameCo' size='20'><br /></td></tr>
										<tr valign='center' align='center'><td>
										<input type='submit' name='RenameMePLZ' value='Переименовать'></td></tr>";
									}
									else{	echo "<br /><p>Выберите тип</p>";	}
								?>
							</td>
						</tr>
						</form>
						<tr align="center"><td><font size="3px"><b>Изменение обложки : </b></font></td></tr>
						<form method="POST" enctype="multipart/form-data">
						<tr align="center">
							<td>
								<br />
								<select name="MyTy" size="1" id="TY">
									<option value="1">Комиксы</option>
									<option <? if(isset ( $_POST['submitComTYY'] )) if($_POST['MyTy']== 2){ echo "selected='selected'";}?>  value="2">Манга</option>
								</select>
								<input type="submit" name="submitComTYY" value="Выбрать"/>
								<br />							
								<?
									if ( isset ( $_POST['submitComTYY'] ) ){								
										$TIP = $_POST['MyTy'];									
										echo "<font size='2px'><b>Выберите комикс : </b></font><br /><select size='5' size=3 name='DIRS_C'>";
										$path = "Papka/";
										$mySubPath;
										$I;									
										if($TIP == 1){
											$path .= "COMIX/";
											echo "<option disabled>Комиксы</option>";
											$I = 0;
										}
										else{
											$path .= "MANGA/";
											echo "<option disabled>Манга</option>";
											$I = 1;
										}									
										GETSOME2($path);									
										echo "</select><br />							
												<br /><font size='2px'><b>Выберите обложку : </b></font><input type='file' name='uploadfile'><br />							
												<input type='submit' name='submitComTypeee' value='Изменить'/>";
									}
									else{ echo "<br /><p>Выберите тип</p>"; }
								?>
								
							</td>
						</tr>
						</form>
					</table>
					
				<?php } ?>	
			</div>
			
	</div>

	<?php include 'footer.php'; ?>		
	
	</body>
</html>