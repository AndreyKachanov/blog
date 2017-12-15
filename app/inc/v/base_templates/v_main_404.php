<!DOCTYPE html>
<html>
	<head>
		<base href="<?=DOMEN . BASE_URL?>">
		<title><?=$title?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<meta name="keywords" content="<?=$keywords?>">
		<meta name="description" content="<?=$description?>">
		<link rel="shortcut icon" href="img/favicon/favicon_main.ico" type="image/x-icon">		
	</head>
	<body>
<!-- 		<div class="preloader"><div class="pulse"></div></div> -->
		<div class="wrapper">
			<header>
				<div class="top-menu">

					<nav class="navbar navbar-expand-md"> 
						<div class="container">
						  <? if ($adminlink) : ?>
						  	  <div class="mmenu-container">
								  <a href="#my-menu" class="mm hamburger hamburger--spring">
				        				<span class="hamburger-box">
				    						<span class="hamburger-inner"></span>
				  						</span>					  	
								  </a>
							  </div>
							  <nav id="my-menu">
							  	<ul>
							  		<li><span>Редактор статей</span>
							  		        <ul class="Vertical">
									            <li><a href="/articles/editor">Редактировать</a></li>
									            <li><a href="/articles/add">Добавить</a></li>
        									</ul>
        							</li>
							  		<li><span>Пользователи</span>
							  		        <ul class="Vertical">
									            <li><a href="/users">Редактировать</a></li>
									            <li><a href="/users/add">Добавить</a></li>
        									</ul>
        							</li>
							  		<li><span>Комментарии</span>
							  		        <ul class="Vertical">
									            <li><a href="/comments">Редактировать</a></li>
        									</ul>
        							</li>          							        							
							  	</ul>
							  </nav>
						  <? endif ?>
							
						  <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						    <span class="navbar-toggler-icon"></span>
						  </button>

			  			  <div class="collapse navbar-collapse" id="navbarSupportedContent">

			  			   	<div class="navbar-nav mr-auto">
			  			   		<a class="nav-item nav-link active" href="/">Главная</a>
			  			   		<a class="nav-item nav-link" href="/about">О себе</a>
			  			   		<a class="nav-item nav-link" href="/feedback">Контакты</a>
			  			   	</div>

			  			   	<div class="auth navbar-nav">

								<? if (!$adminlink) : ?> 
			  			   			<a class="nav-item nav-link" href="/register">Регистрация</a>
			  			   			<a class="nav-item nav-link" href="/login">Войти</a>
			  			   		<? else: ?>
			  			   			<a class="nav-item nav-link" href="/admin">Админка</a>
			  			   			<a class="nav-item nav-link" href="/login">Выход (<b><?=$user?></b>)</a>
			  			   		<? endif ?>

			  			   	</div>		  			   		
			  			  </div>					  

						</div>
					</nav>
				</div>

				<div class="img-block">
					<div class="container">
											
						<div class="row_smart">
							<div class="col_smart col_smart_img">
								<img class="img-responsive" src="img/header.png" alt="">
							</div>
							<div class="col_smart col_smart_about">
									<h1>Мой блог</h1>
									<p>Блог обо всём ....</p>
							</div>
						</div>

					
					</div>
				
				</div>

			</header>

			<div class="content" id="content">		
				<?=$content?>	
					</div>
			

			<footer>
				<div class="container">
					<p>&copy; 2014 - <?=date('Y');?> <a href="https://andreiikachanov.com">andreiikachanov.com.</a> Все права защищены.</p>
					<p>Development - <a href="https://vk.com/id10398369">Andrey Kachanov</a></p>
				</div>
			</footer>
		</div>

		<div class="top" title="Наверх"><i class="fa fa-angle-double-up"></i></div>
		<? foreach($styles as $style): ?> <link rel="stylesheet" href="/<?=CSS_DIR . $style?>.css" /> <? endforeach; ?>
		<? foreach($scripts as $script): ?> <script src="/<?=JS_DIR . $script?>.js"></script> <? endforeach; ?>				
	</body>
</html>