<?php
	
	include 'AUTORISE.php';
	
	//вывод списка комиксов
	function GETSOME($pu)
	{
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");
		
		$r = $db->query("SELECT ID_Comix, Name, Cover, Directo FROM MyComicsTable WHERE Directo like '%$pu%' ORDER BY Name");
		
		$myM = "";
		
		while ($row = $r->fetch_assoc())
			echo "<option value='".$row['ID_Comix']."'>".$row['Name']."</option><br>";		
		
	}

	
	//кнопка создания комикса по типу
	if ( isset ( $_POST['submitComType'] ) )
	{
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");
		
		$path = "Papka/";
		$mySubPath;		
		if($_POST['TY'] == 1){	$path .= "COMIX/";  }
		else{	$path .= "MANGA/";	}
		
		if($_POST["myDirName"] != "")
		{			
			$CMX_NAME = $_POST["myDirName"];
			$CMX_NAME = simvol2translit($CMX_NAME);
			
			// проверка на существование комикса с таким же именем
			$result = $db->query("SELECT ID_Comix FROM MyComicsTable WHERE Name='$CMX_NAME'"); 
			$myrow = mysqli_fetch_array($result); 
			if (!empty($myrow['ID_Comix'])) 
			{ 
				echo "<script>window.alert('Такой комикс уже существует!');window.location.href='make_papka.php';</script>";
			}
			else{
				$CMX_PATH = $path;
				
				$sub = rus2translit($_POST["myDirName"]);
				$sub = simvol2translit($sub);
				
				$path .= $sub;
				mkdir($path, 0777, true);
				
				$result2= $db->query("INSERT INTO MyComicsTable (Name, Directo) VALUES ('$CMX_NAME', '$path')");
				
				echo "<script>window.alert('Директория для комикса создана!');window.location.href='make_papka.php';</script>";	
			}
		}
		else
		{
			echo "<script>window.alert('Введите название!');</script>";	
		}
	}
	
	//кнопка загрузки картинок комикса
	if ( isset( $_POST['uploadMyComix'] ) )
	{
		if( (isset ( $_POST['DIRS_CO'] )) )
		{
			$path = "Papka/";
			$TIP = $_POST['MyTu'];
			if($TIP == 1){ $path .= "COMIX/"; }
			else{ $path .= "MANGA/"; }
			$mySubPath = $_POST['DIRS_CO'];
			
			$CO = $_POST['DIRS_CO'];
			$db = new mysqli("localhost", "root", ""); 
			$db->select_db ("MySomeBD");
			
			$r = $db->query("SELECT ID_Comix, Directo FROM MyComicsTable where ID_Comix='$CO'");
			$row = $r->fetch_assoc();
			$IID = $row['ID_Comix'];
			
			$path = $row['Directo'];
			
			foreach ( $_FILES["pictures"]["error"] as $key => $error ) 
			{		
				if ( $error == UPLOAD_ERR_OK ) {
					if ( $_FILES["pictures"]['type'][$key] == 'image/jpeg' or $_FILES["pictures"]['type'][$key] == 'image/png' or $_FILES["pictures"]['type'][$key] == 'image/gif' )
					{
						$tmp_name = $_FILES["pictures"]["tmp_name"][$key];
						// basename() может спасти от атак на файловую систему;
						// может понадобиться дополнительная проверка/очистка имени файла
						$name = basename($_FILES["pictures"]["name"][$key]);
						$name = rus2translit($name);
						$name = simvol2translit($name);
						move_uploaded_file($tmp_name, $path."/$name");
						
						$result2= $db->query("INSERT INTO ComixPages (ID_CMX, ImageNam) VALUES ('$IID', '$name')");
					}
				}				
			}
			
			echo "<script>window.alert('Страницы комикса загружены!');window.location.href='make_papka.php';</script>";
		}
		else
		{
			echo "<script>window.alert('Сделайте выбор и выберите страницы!');</script>";
		}
	}
	
	
	//Загрузка обложки в папку на сервере
	if ( isset( $_POST['submitComTypeee'] ) )
	{
		if( (isset ( $_POST['DIRS_C'] )) )
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
				$CO = $path."/$name";
					
				$up = mysql_query("UPDATE MyComicsTable SET Cover='$CO' WHERE ID_Comix='$NA'");
				
				echo "<script>window.alert('Обложка комикса загружена!');window.location.href='make_papka.php';</script>";
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
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
					echo "<script>window.location.href='index.php';</script>";
				}				
				else { //Если админ, показываем форму
				?>
					
					<?php include 'menu_admin.php' ?>
					
					<br />
				
									
					<table border=3 align=center>
						<tr align="center"><td><font size="3px"><b>Создание директории комикса : </b></font></td></tr>
						<form method="POST" enctype="multipart/form-data">
						<tr align="center">
							<td>
								<font size="2px"><b>Назовите новую папку комикса : </b></font><br>
								<select name="TY" size="1" id="TY">
									<option value="1">Комиксы</option>
									<option value="2">Манга</option>
								</select>
								<input type="text" name="myDirName" size="20">
								<input type="submit" name="submitComType" value="Создать"/>
								<br><br>
							</td>
						</tr>
						</form>
						<tr align="center"><td><font size="3px"><b>Добавление обложки : </b></font></td></tr>
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
										GETSOME($path);									
										echo "</select><br />							
												<br /><font size='2px'><b>Выберите обложку : </b></font><input type='file' name='uploadfile'><br />							
												<input type='submit' name='submitComTypeee' value='Загрузить'/>";
									}
									else{ echo "<br /><p>Выберите тип</p>"; }
								?>
								
							</td>
						</tr>
						</form>
						<tr align="center"><td><font size="3px"><b>Загрузка страниц комикса : </b></font></td></tr>
						<form method="POST" enctype="multipart/form-data">
						<tr align="center">
							<td>
								<select name="MyTu" size="1" id="TY">
									<option value="1">Комиксы</option>
									<option <? if(isset ( $_POST['submitComTUU'] )) if($_POST['MyTu']== 2){ echo "selected='selected'";}?>  value="2">Манга</option>
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
										GETSOME($path);									
										echo "</select><br / ><br /><font size='2px'><b>Выберите картинки : </b></font><input type='file'  name='pictures[]' multiple='true'><br />
											<input type='submit' name='uploadMyComix' size='100' value='Загрузить'>";
									}
									else{	echo "<br /><p>Выберите тип</p>";	}
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
