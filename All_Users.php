<?php
	include 'AUTORISE.php';
	
	function SomeFunction()
	{		
		// подключаемся к серверу баз данных MySQL
		$db = new mysqli("localhost", "root", "");
		// устанавливаем кодировку общения с MySQL
		$db->query("SET NAMES 'utf8'");				
		// выбираем базу данных
		$db->select_db("MySomeBD");		
		$r = $db->query("SELECT login_user, user_name, gender, role, my_image FROM USERS WHERE role<>'superadmin'");		
		$myUsInfo = "<table align=center><tr><td><b>Логин</b></td><td><b>Имя пользователя</b></td><td><b>Пол</b></td><td><b>Роль</b></td><td><b>Аватарка</b></td></tr>";		
		while ($row = $r->fetch_assoc())
			$myUsInfo .= "<tr><td>".$row['login_user']."</td><td>".$row['user_name']."</td><td>".$row['gender']."</td><td>".$row['role']."</td><td><img src='".$row['my_image']."' height=33 width=33/></td></tr>";
		$myUsInfo .= "</table>";		
		echo "$myUsInfo";
	}
	
	function UsersLoginsHere()
	{		
		// подключаемся к серверу баз данных MySQL
		$db = new mysqli("localhost", "root", "");
		// устанавливаем кодировку общения с MySQL
		$db->query("SET NAMES 'utf8'");				
		// выбираем базу данных
		$db->select_db("MySomeBD");		
		$r = $db->query("SELECT login_user FROM USERS WHERE role<>'superadmin'");		
		$myUsInfo = "<select name='USRS' size='1'>";		
		while ($row = $r->fetch_assoc())
			$myUsInfo .= "<option value='".$row['login_user']."'>".$row['login_user']."</option>";
		$myUsInfo .= "</select>";		
		echo "$myUsInfo";
	}
	
	if(isset($_POST['submitRo']))
	{
		// подключаемся к серверу баз данных MySQL
		$db = new mysqli("localhost", "root", "");
		// устанавливаем кодировку общения с MySQL
		$db->query("SET NAMES 'utf8'");				
		// выбираем базу данных
		$db->select_db("MySomeBD");
		
		$R = $_POST['MyRo'];
		$U = $_POST['USRS'];
		
		$up = mysql_query("UPDATE USERS SET role='$R' WHERE login_user='$U'");
		echo "<script>window.alert('Роль $U  изменена на $R');window.location.href='All_Users.php';</script>";
	}
	
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Все пользователи</title>

    <!-- Bootstrap -->
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
					echo "<script>window.location.href='index.php';</script>"; //перенаправляем на главную страницу
				}				
				else {
				?>
					
					<?php include 'menu_admin.php' ?>
				
					<br />
				
					<form method="POST" enctype="multipart/form-data">
					<table border=3 align=center>
						<tr align="center">
							<td><b>Поменять роль:</b></td>
						</tr>
						<tr align="center">
							<td>
								<!--Списки юзеров-->								
								Пользователи: <? UsersLoginsHere(); ?> 								
								Роль: <select name="MyRo" size="1">
									<option value="user">user</option>
									<option value="admin">admin</option>
								</select>
								<input type="submit" name="submitRo" value="Изменить"/>
							</td>
						</tr>
					</table>
					</form>
					<br /><br />
				<?php SomeFunction();} ?>	
		</div>
		
	</div>
	
	<?php include 'footer.php'; ?>
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
