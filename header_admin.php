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
						<div class="navbar-brand" href="#"><img src="IMG/bubble1-small.png" style="margin-top: -18px;"></div>
						<div class="collapse navbar-collapse" id="myMenu">
							<ul class="nav navbar-nav">
								<li><a href="index.php"><b><img src="IMG/home.png" height=20 width=22 style='margin-top: -4px;'/>Главная</b></a></li>
								<li><a href="COMIX.php"><b>Комиксы</b></a></li>
								<li><a href="MANGA.php"><b>Манга</b></a></li>
								<li><a href="SearchMe.php"><b>Поиск</b></a></li>
							</ul>
							<div>
								<ul class="nav navbar-nav" id="WantToChange" style="float: right;	box-sizing: inherit;">
									<?php 
										if ($auth->isAuth() == 1) { // Если пользователь авторизован и админ, приветствуем и даем доступ к админке:  
											echo "<ul class='nav navbar-nav'><li><div style='margin-top: 15px;'><font color='#A4A4A4' style='font-weight: 600'>Привет, <a href='MyKabinet.php'><font color='#CCCCCC' style='font-weight: 900'>" . $auth->getLogin() . " <img src='". $auth->getPhoto() ."' height=33 width=33 style='border: 2px solid #00a8e1; margin-top: -6px;'/></font></a></font></div></li><li style='margin-left: 10px;'><a href=\"?is_exit=1\"><font color='#A4A4A4'><div class='hover05' style='margin-top: -20px;' title='Выйти'><span style='color: #222222;'>_____</span><figure><img src='IMG/exit.png' height=20 width=22/></figure></div></font></a></li></ul>"; //Показываем кнопку выхода
										}
										elseif ($auth->isAuth() == 2){
											echo "<ul class='nav navbar-nav'><li><div style='margin-top: 15px;'><font color='#A4A4A4' style='font-weight: 600'>Привет, <a href='MyKabinet.php'><font color='#CCCCCC' style='font-weight: 900'>" . $auth->getLogin() . " <img src='". $auth->getPhoto() ."' height=33 width=33 style='border: 2px solid #00a8e1; margin-top: -6px;'/></font></a></font></div></li><li style='margin-left: 10px;'><a href=\"?is_exit=1\"><font color='#A4A4A4'><div class='hover05' style='margin-top: -20px;' title='Выйти'><span style='color: #222222;'>_____</span><figure><img src='IMG/exit.png' height=20 width=22/></figure></div></font></a></li></ul>"; //Показываем кнопку выхода
										}
										else { //Если не авторизован, показываем форму ввода логина и пароля
									?>
										<div style='margin-top: 12px;'>
											<form method="post" action="">
												<font color='#A4A4A4'><b>Логин: </b></font><input type="text" size="9" style='height: 22px;' name="login" value="<?php echo (isset($_POST["login"])) ? $_POST["login"] : null; // Заполняем поле по умолчанию ?>" />
												<font color='#A4A4A4'><b> Пароль: </b></font><input type="password" size="9" style='height: 22px;' name="password" value="" /><input type="submit" class="button button1" value="Войти" />
												<a href="register.php"><font color='#A4A4A4'><b><i>Регистрация</i></b></font></a>
											</form>
										</div>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
			</div>