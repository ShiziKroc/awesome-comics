<?php

	if(isset($_POST['submitMe'])){		
		// подключаемся к базе
		$db = new mysqli("localhost", "root", ""); 
		$db->select_db ("MySomeBD");

		$uploaddir= ' ';
		$login=$_POST['login'];
		$pass=$_POST['pass'];
		$name=$_POST['name1'];
		$gender=$_POST['gender'];
		$foto = 'i/'.$_FILES['uploadfile']['name'];
		
		
		//если логин и пароль введены, то обрабатываем их
		$login = stripslashes($login); 
		$login = htmlspecialchars($login); 
		$pass = stripslashes($pass); 
		$pass = htmlspecialchars($pass); 
			
		$name = stripslashes($name); 
		$name = htmlspecialchars($name); 
			
		$gender = stripslashes($gender); 
		$gender = htmlspecialchars($gender); 

		//удаляем лишние пробелы 
		$login = trim($login); 
		$pass = trim($pass);
		$name = trim($name);
		$gender = trim($gender);
		
		$pass  = md5($pass);

		// проверка на существование пользователя с таким же логином
		$result = $db->query("SELECT id_user FROM USERS WHERE login_user='$login'"); 
		$myrow = mysqli_fetch_array($result); 
		if (!empty($myrow['id_user'])) 
		{ 
			echo "<script>window.alert('Такой логин уже существует!');window.location.href='register.php';</script>";
		} 
		// если такого нет, то сохраняем данные
		else{	
			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $foto)) {;
				$result2= $db->query("INSERT INTO USERS (login_user, password_user, user_name, gender, my_image) 
									VALUES ('$login', '$pass', '$name', '$gender', '$foto')");
				
				if ($result2){ 
					echo "<script>window.alert('Вы зарегистрировались!');window.location.href='index.php';</script>";
				}
			}	
		}		
	}	
	
?>
 
    
    
