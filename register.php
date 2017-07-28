<?php
	include 'AUTORISE.php';
	include 'reg.php';
	
	//Загрузка аватарки в папку на сервере
	if ( isset( $_POST['submitMe'] ) )
	{
		$path = 'i/';		
		if ( $_FILES["uploadfile"]['type'] == 'image/jpeg' or $_FILES["uploadfile"]['type'] == 'image/png' or $_FILES["uploadfile"]['type'] == 'image/gif' )
		{			
			$tmp_name = $_FILES["uploadfile"]["tmp_name"];
			// basename() может спасти от атак на файловую систему;
			// может понадобиться дополнительная проверка/очистка имени файла
			$name = basename($_FILES["uploadfile"]["name"]);
			$name = rus2translit($name);
			$name = simvol2translit($name);
			$name = uniqid().$name; //случайное имя
			move_uploaded_file($tmp_name, $path."/$name");
			
			$NA = $_POST['DIRS_C'];
			$CO = $path."/$name";				
		}
		else
		{
			echo "<script>window.alert('Вы выбрали не картинку!');</script>";
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//RU">
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav2.css" rel="stylesheet">
	<link href="custom.css" rel="stylesheet">
	<link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
  </head>
  
  <body>
	<div id="wrap">
  		<div class="navbar navbar-inverse navbar-static-top">
			<div class="container">
				<div class="navbar-header"></div>
					<button class="navbar-toggle" data-toggle="collapse" data-target="#myMenu">
						<span class="sr-only">Навігація</span><!-- Screen only-->
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Відкриває меню, коли розмір екрану такий, що горізонтальне меню зникає -->
				<div class="navbar-brand" href="#"><a href="index.php"><img src="IMG/bubble1-small.png" style="margin-top: -18px;"></a></div>
				<div class="collapse navbar-collapse" id="myMenu">
					<ul class="nav navbar-nav">
						<li><a href="index.php"><b><img src="IMG/home.png" height=20 width=22 style='margin-top: -4px;'/>Главная</b></a></li>
					</ul>
					
				</div>
			</div>
		</div>
		
		
		<div class="content-block">
			
			<?php 
				if ($auth->isAuth() == 1 or $auth->isAuth() == 2) { // Если пользователь авторизован
					echo "<script>window.location.href='index.php';</script>";
				}				
				else { //Если не авторизован, показываем форму
			?>
				<form method="post" enctype="multipart/form-data">
					<table align='center'>
						<tr>
							<td>Логин: </td>
							<td><input type="text" name="login" maxlength=12 placeholder = "Логин" required /></td>
						<tr>
						<tr>
							<td>Пароль: </td>
							<td><input type="password" name="pass" maxlength=12 placeholder = "Пароль" required /></td>
						</tr>
						<tr>
							<td>Имя: </td>
							<td><input type="text" name="name1" maxlength=30 placeholder = "Имя" required ></td>
						</tr>
						<tr>
							<td>Пол: </td>
							<td><select name="gender" size="1" id="gender">
								<option value="Мужской">Мужской</option>
								<option value="Женский">Женский</option>
							</select></td>
						</tr>
						<tr>
							<td>Фото: </td>
							<td><input type="file" name="uploadfile" placeholder = "Фото" required /></td>
						</tr>
						<tr align="center">
							<td colspan=2>
								<input class="button" type="submit" name="submitMe" value="Зарегестрироваться"/>
							</td>
						</tr>
					</table>
				</form>
			<?php } ?>
			
			
			
		</div>
		
	</div>

	<?php include 'footer.php'; ?>
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
