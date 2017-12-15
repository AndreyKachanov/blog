<!DOCTYPE html>
<html>
	<head>
		<base href="<?=DOMEN . BASE_URL?>">
		<title><?=$title?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="img/favicon/favicon_adm.ico" type="image/x-icon">
	</head>
	<body class="fixed-nav sticky-footer bg-dark" id="page-top">
		<!-- Navigation-->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
			<a target="_blank" class="navbar-brand" href="/">Перейти на сайт</a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

					<li class="nav-item" title="Консоль">
						<a class="nav-link <?=($classes['class_name'] ?? '')?>" href="/admin">
							<i class="fa fa-fw fa-home"></i>
							<span class="nav-link-text">Консоль</span>
						</a>
					</li>					

					<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Статьи">
						<a class="nav-link nav-link-collapse collapsed <?=($classes['class_name_art'] ?? '')?>" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
							<i class="fa fa-fw fa-file"></i>
							<span class="nav-link-text">Статьи</span>
						</a>
						<ul class="sidenav-second-level collapse <?=($classes['items_collapse_art'] ?? '')?>" id="collapseExamplePages">
							<li>
								<a class="<?=($classes['color_art_edit'] ?? '')?>" href="/articles/editor">Редактировать</a>
							</li>
							<li>
								<a class="<?=($classes['color_art_add'] ?? '')?>" href="/articles/add">Добавить</a>
							</li>
						</ul>
					</li>


					<? 
					// if (M_Helpers::can_look('ALL')): 
					?>
					<? 
					if (M_Users::Instance()->Can('ALL')): 
					?>					
					<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Пользователи">
						<a class="nav-link nav-link-collapse collapsed <?=($classes['class_name_usr'] ?? '')?>" data-toggle="collapse" href="#collapseUsers" data-parent="#exampleAccordion">
							<i class="fa fa-fw fa-user"></i>
							<span class="nav-link-text">Пользователи</span>
						</a>
						
						<ul class="sidenav-second-level collapse <?=($classes['items_collapse_usr'] ?? '')?>" id="collapseUsers">
							<li>
								<a class="<?=($classes['color_usr_edit'] ?? '')?>" href="/users">Редактировать</a>
							</li>
							<li>
								<a class="<?=($classes['color_usr_add'] ?? '')?>" href="/users/add">Добавить</a>
							</li>
						</ul>					
					</li>					
					<? endif; ?>
					
					<? 
					// if (M_Helpers::can_look('ALL')): 
					?>
					<? 
					if (M_Users::Instance()->Can('ALL')): 
					?>					
					<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Комментарии">
						<a class="nav-link nav-link-collapse collapsed <?=($classes['class_name_comm'] ?? '')?>" data-toggle="collapse" href="#collapseComments" data-parent="#exampleAccordion">
							<i class="fa fa-fw fa-commenting-o"></i>
							<span class="nav-link-text">Комментарии</span>
						</a>
						
						<ul class="sidenav-second-level collapse <?=($classes['items_collapse_comm'] ?? '')?>" id="collapseComments">
							<li>
								<a class="<?=($classes['color_comm_edit'] ?? '')?>" href="/comments">Редактировать</a>
							</li>
						</ul>					
					</li>					
					<? endif; ?>					

					<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
						<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
							<i class="fa fa-fw fa-sitemap"></i>
							<span class="nav-link-text">Menu Levels</span>
						</a>
						<ul class="sidenav-second-level collapse" id="collapseMulti">
							<li>
								<a href="#">Second Level Item</a>
							</li>
							<li>
								<a href="#">Second Level Item</a>
							</li>
							<li>
								<a href="#">Second Level Item</a>
							</li>
							<li>
								<a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2">Third Level</a>
								<ul class="sidenav-third-level collapse" id="collapseMulti2">
									<li>
										<a href="#">Third Level Item</a>
									</li>
									<li>
										<a href="#">Third Level Item</a>
									</li>
									<li>
										<a href="#">Third Level Item</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
						<a class="nav-link" href="#">
							<i class="fa fa-fw fa-link"></i>
							<span class="nav-link-text">Link</span>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav sidenav-toggler">
					<li class="nav-item">
						<a class="nav-link text-center" id="sidenavToggler">
							<i class="fa fa-fw fa-angle-left"></i>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">

					<li class="nav-item user_name">
						<a class="nav-link"><?=$user?><i class="fa fa-sort-desc" aria-hidden="true"></i></a>						
					</li>
					<li class="nav-item">						
						<a class="nav-link" data-toggle="modal" data-target="#exampleModal">
						<i class="fa fa-fw fa-sign-out"></i>Выход</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="content">
					<?=$content?>
				</div>
			</div>
		    <!-- Scroll to Top Button-->
		    <a class="scroll-to-top rounded" href="#page-top">
		      <i class="fa fa-angle-up"></i>
		    </a>		
			<!-- Logout Modal-->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Вы действительно хочете выйти?</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">Нажмите «Выход», если вы готовы завершить текущий сеанс.</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Закрыть</button>
							<a class="btn btn-primary" href="/login">Выход</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<? foreach($styles as $style): ?> <link rel="stylesheet" href="/<?=CSS_DIR . $style?>.css" /> <? endforeach; ?>
		<? foreach($scripts as $script): ?> <script src="/<?=JS_DIR . $script?>.js"></script> <? endforeach; ?>
	</body>
</html>