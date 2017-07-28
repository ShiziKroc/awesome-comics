<?php

	include 'AUTORISE.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//RU">
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Редактировать профиль</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav2.css" rel="stylesheet">
	<link href="custom.css" rel="stylesheet">
	<link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
  </head>
  <body>
	<div id="wrap">
	
  		<?php include 'header.php'; ?>		
		
		<div class="content-block">
			
			<?php 
				if ($auth->isAuth() == 0) { // Если пользователь не авторизован
					echo "<script>window.location.href='index.php';</script>";
				}				
				else { //Если авторизован, показываем форму
			?>
			
				<p align="center"><b>Редактирование профиля</b></p>
				<table border=2 align='center'>
					<tr>
						<td width='200'>
							<b>Введите новый логин: </b>
						</td>
						<td colspan=2>
							<form method='post'  enctype='multipart/form-data'>
								<input type="text" name="newLogin" required /> <input type="submit" name="submitNewLogin" value="Изменить"/>
							</form>
						</td>
					</tr>
					<tr>
						<td>
							<b>Введите новый пароль: </b>
						</td>
						<td colspan=2>
							<form method='post'  enctype='multipart/form-data'>
								<input type="password" name="newPassword" required /> <input type="submit" name="submitNewPassword" value="Изменить"/>
							</form>
						</td>
					</tr>
					<tr>
						<td>
							<b>Введите новое имя: </b>
						</td>
						<td colspan=2>
							<form method='post'  enctype='multipart/form-data'>
								<input type="text" name="newName" required /> <input type="submit" name="submitNewName" value="Изменить"/>
							</form>
						</td>
					</tr>
					<tr>
						<td>
							<b>Хотите сменить пол? : </b>
						</td>
						<td colspan=2>
							<form method='post'  enctype='multipart/form-data'>
								<select name="gender" size="1" id="gender">
									<option value="Мужской">Мужской</option>
									<option value="Женский">Женский</option>
								</select>
								<input type="submit" name="submitNewGender" value="Изменить"/>
							</form>
						</td>
					</tr>
					<tr>
						<td>
							<b>Выберите новую фотку: </b>
						</td>
						<form method='post'  enctype='multipart/form-data'>
							<td>
								<input type="file" name="uploadfile" required /><br />
								<input type="submit" name="submitNewPhoto" value="Изменить"/>
							</td>
						</form>
					</tr>
				</table>
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
