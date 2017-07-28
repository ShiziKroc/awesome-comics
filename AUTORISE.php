<?php

	session_start(); //Запускаем сессии

	include 'SQL_CONNECT.php';
	include 'translit.php';
	
	
	/** 
	 * Класс для авторизации
	 */ 
	class AuthClass {
		private $_login = ""; //Устанавливаем логин
		private $_role = "";

		/**
		 * Проверяет, авторизован пользователь или нет
		 */
		public function isAuth()//проверяем сессию, если она есть, то значит уже авторизовались	
		{
			if (isset($_SESSION['id_user']))
			{
				global $_role;
				
				if($_SESSION['role'] == "admin" || $_SESSION['role'] == "superadmin") //проверяем, админ ли пользователь
					return 1;
				else return 2;
			}
			else
			{
				$_login = '';
				if(isset($_COOKIE['CookieMy']))
				{
					$_login = htmlspecialchars($_COOKIE['CookieMy']);
					return 0;
				}
			}
			
		}
		
		/**
		 * Авторизация пользователя
		 */
		public function auth($login, $passwors)
		{			
			$passwors = md5($passwors);
			$query = "SELECT id_user, login_user, role FROM USERS WHERE login_user = '$login' AND password_user = '$passwors' LIMIT 1";
			$sql = mysql_query($query) or die(mysql_error());
			
			//если такой пользователь есть
			if(mysql_num_rows($sql) == 1)
			{
				$row = mysql_fetch_assoc($sql);
				//ставим метку сессии
				$_SESSION['id_user'] = $row['id_user'];
				$_SESSION['login_user'] = $row['login_user'];
				$_SESSION['role'] = $row['role'];
				$_login = $row['login_user'];
				$_role = $row['role'];
				//ставим куки и время их хранения 10 дней
				setcookie("CookieMy", $row['login_user'], time()+60*60*24*10);
				return true;
			}
			else
			{
				return 0;
			}
		}
		
		/**
		 * Метод возвращает логин авторизованного пользователя 
		 */
		public function getLogin() {
			if ($this->isAuth()) { //Если пользователь авторизован
				return $_SESSION["login_user"]; //Возвращаем логин, который записан в сессию
			}
		}
		
		
		public function getAllInfo()
		{
			if($this->isAuth() == 1 OR $this->isAuth() == 2){	
				$query2 = "SELECT id_user, login_user, user_name, gender, my_image FROM USERS WHERE login_user = '".$this->getLogin()."' LIMIT 1";
				$sql2 = mysql_query($query2) or die(mysql_error());
								
				
				//если такой пользователь есть
				if(mysql_num_rows($sql2) == 1)
				{
					$row2 = mysql_fetch_assoc($sql2);
					
					echo "<p style='text-align:center;'><b>Мой кабинет</b></p><table align='center' border='none'><tr><td rowspan=4><img src='".$row2['my_image']."' height=150 width=150 /></td>
					<td><b>Логин: </b>".$row2['login_user']."</td></tr>
					<tr><td><b>Имя: </b>".$row2['user_name']."</td></tr><tr><td><b>Пол: </b>".$row2['gender']."</td></tr></table><br />
					<div style='text-align: center;'><a href='EditProfile.php' class='btn btn-default'>Редактировать профиль</a></div>";
				}
			}
		}
		
		//меняем логин
		public function setNewLogin($newLogin)
		{
			if($this->isAuth() == 1 OR $this->isAuth() == 2){

				$newLo = $newLogin;
				$newLo = stripslashes($newLo);
				$newLo = htmlspecialchars($newLo);
				$newLo = trim($newLo);
			
				$query2 = "SELECT id_user, login_user, user_name, gender, my_image FROM USERS WHERE login_user = '".$this->getLogin()."' LIMIT 1";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($sql2);
				$ID_U = $row2['id_user'];
				
				//если такой пользователь есть
				if(mysql_num_rows($sql2) == 1)
				{		
					$db = new mysqli("localhost", "root", ""); 
					$db->select_db ("MySomeBD");
					// проверка на существование пользователя с таким же логином
					$result = $db->query("SELECT id_user FROM USERS WHERE login_user='$newLo'"); 
					$myrow = mysqli_fetch_array($result); 
					if (!empty($myrow['id_user'])) 
					{ 
						echo "<script>window.alert('Такой логин уже существует!');</script>";
					}					
					else
					{
						$up = mysql_query("UPDATE USERS SET login_user='$newLo' WHERE id_user='$ID_U'");
						$_SESSION['login_user'] = $newLo;
						setcookie("CookieMy", $newLo, time()+60*60*24*10);
					}
				}
			}
		}
		
		//меняем пароль
		public function setNewPassword($newPass)
		{
			if($this->isAuth() == 1 OR $this->isAuth() == 2){

				$newPas = $newPass;
				$newPas = stripslashes($newPas);
				$newPas = htmlspecialchars($newPas);
				$newPas = trim($newPas);
			
				$query2 = "SELECT id_user, login_user, user_name, gender, my_image FROM USERS WHERE login_user = '".$this->getLogin()."' LIMIT 1";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($sql2);
				$ID_U = $row2['id_user'];
				
				$newPas = md5($newPas);
				
				//если такой пользователь есть
				if(mysql_num_rows($sql2) == 1)
				{				
					$up = mysql_query("UPDATE USERS SET password_user='$newPas' WHERE id_user='$ID_U'");
				}
			}
		}
		
		//меняем имя
		public function setNewName($newName)
		{
			if($this->isAuth() == 1 OR $this->isAuth() == 2){

				$newN = $newName;
				$newN = stripslashes($newN);
				$newN = htmlspecialchars($newN);
				$newN = trim($newN);
			
				$query2 = "SELECT id_user, login_user, user_name, gender, my_image FROM USERS WHERE login_user = '".$this->getLogin()."' LIMIT 1";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($sql2);
				$ID_U = $row2['id_user'];
				
				//если такой пользователь есть
				if(mysql_num_rows($sql2) == 1)
				{				
					$up = mysql_query("UPDATE USERS SET user_name='$newN' WHERE id_user='$ID_U'");
				}
			}
		}
		
		//меняем пол
		public function setNewGender($newGend)
		{
			if($this->isAuth() == 1 OR $this->isAuth() == 2){

				$newG = $newGend;
				$newG = stripslashes($newG);
				$newG = htmlspecialchars($newG);
				$newG = trim($newG);
			
				$query2 = "SELECT id_user, login_user, user_name, gender, my_image FROM USERS WHERE login_user = '".$this->getLogin()."' LIMIT 1";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($sql2);
				$ID_U = $row2['id_user'];
				
				//если такой пользователь есть
				if(mysql_num_rows($sql2) == 1)
				{				
					$up = mysql_query("UPDATE USERS SET gender='$newG' WHERE id_user='$ID_U'");
				}
			}
		}
		
		//меняем фотку
		public function setNewPhoto($newPhot)
		{
			if($this->isAuth() == 1 OR $this->isAuth() == 2){

				$newP = $newPhot;
				$newP = stripslashes($newP);
				$newP = htmlspecialchars($newP);
				$newP = trim($newP);
			
				$query2 = "SELECT id_user, login_user, user_name, gender, my_image FROM USERS WHERE login_user = '".$this->getLogin()."' LIMIT 1";
				$sql2 = mysql_query($query2) or die(mysql_error());
				$row2 = mysql_fetch_assoc($sql2);
				$ID_U = $row2['id_user'];
				
				unlink($row2['my_image']);
				
				//если такой пользователь есть
				if(mysql_num_rows($sql2) == 1)
				{				
					$up = mysql_query("UPDATE USERS SET my_image='$newP' WHERE id_user='$ID_U'");
				}
			}
		}
		
		public function getPhoto()
		{
			$query2 = "SELECT id_user, login_user, user_name, gender, my_image FROM USERS WHERE login_user = '".$this->getLogin()."' LIMIT 1";
			$sql2 = mysql_query($query2) or die(mysql_error());
			$row2 = mysql_fetch_assoc($sql2);
			$pho = $row2['my_image'];
				
			return $pho;
		}
		
		public function out() {
			$_SESSION = array(); //Очищаем сессию
			session_destroy(); //Уничтожаем
		}
	}

	$auth = new AuthClass();

	if (isset($_POST["login"]) && isset($_POST["password"])) { //Если логин и пароль были отправлены
		if (!$auth->auth($_POST["login"], $_POST["password"])) { //Если логин и пароль введен не правильно
			echo "<script>window.alert('Логин или пароль введены неправильно!');</script>";
		}
	}

	if (isset($_GET["is_exit"])) { //Если нажата кнопка выхода
		if ($_GET["is_exit"] == 1) {
			$auth->out(); //Выходим
			header("Location: ?is_exit=0"); //Редирект после выхода
		}
	}
	
	//меняет логин
	if(isset($_POST['submitNewLogin']))
	{
		$auth->setNewLogin($_POST['newLogin']);
	}
	
	//меняет пароль
	if(isset($_POST['submitNewPassword']))
	{
		$auth->setNewPassword($_POST['newPassword']);
	}
	
	//меняем имя
	if(isset($_POST['submitNewName']))
	{
		$auth->setNewName($_POST['newName']);
	}
	
	//меняем пол
	if(isset($_POST['submitNewGender']))
	{
		$auth->setNewGender($_POST['gender']);
	}
	
	//меняем аву
	if(isset($_POST['submitNewPhoto']))
	{
		$uploaddir= ' ';
		
		$name = basename($_FILES['uploadfile']['name']);
		$name = rus2translit($name);
		$name = simvol2translit($name);
		$name = uniqid().$name;
		
		$foto = 'i/'.$name;
		
		$types = array('image/gif', 'image/png', 'image/jpeg');		
		if (!in_array($_FILES['uploadfile']['type'], $types))
			echo "<script>window.alert('Не тот тип файла!');</script>";
		else
		{
			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $foto)) 
			{
				$auth->setNewPhoto($foto);
			}
		}
	}
	
?>