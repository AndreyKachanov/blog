<!DOCTYPE html>
<html>
	<head>
		<base href="<?=DOMEN . BASE_URL?>">
		<title><?=$title?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta content="text/html; charset=utf-8" http-equiv="content-type">	
	</head>
	<body>
		<div class="wrapper">
			<header>
				<h1><?=$title?></h1>
				<div class="top-menu">
					<nav class="navbar navbar-expand-md"> 
						<div class="container">
						  <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						    <span class="navbar-toggler-icon"></span>
						  </button>

			  			  <div class="collapse navbar-collapse" id="navbarSupportedContent">

			  			   	<div class="navbar-nav mr-auto">
			  			   		<a class="nav-item nav-link active" href="/pages">Статьи</a>
			  			   		<a class="nav-item nav-link active" href="/users">Пользователи</a>
			  			   		<a class="nav-item nav-link active" href="/users">DP ISS Почта</a>
			  			   		<a class="nav-item nav-link active" href="/users">Курс валют</a>
			  			   		<a class="nav-item nav-link active" href="/users">Тренировки</a>
			  			   		<a class="nav-item nav-link active" href="/users">Питание</a>

			  			   		<a class="nav-item nav-link active" href="/gallery">Галереи</a>
			  			   		<a class="nav-item nav-link" href="/about">О себе</a>
			  			   		<a class="nav-item nav-link" href="/feedback">Контакты</a>
			  			   	</div>

			  			   	<div class="auth navbar-nav">

			  			   			<a class="nav-item nav-link" href="/pages">
			  			   				<?=$user?>
			  			   				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			  			   			</a>
			  			   			<a class="nav-item nav-link" href="/login">Выход</a>

			  			   	</div>		  			   		
			  			  </div>					  

						</div>
					</nav>
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

		<? foreach($styles as $style): ?> <link rel="stylesheet" href="/<?=CSS_DIR . $style?>.css" /> <? endforeach; ?>
		<? foreach($scripts as $script): ?> <script src="/<?=JS_DIR . $script?>.js"></script> <? endforeach; ?>				
	</body>
</html>