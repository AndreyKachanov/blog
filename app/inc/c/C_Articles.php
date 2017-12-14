<?php 


class C_Articles extends C_Base 
{
	public function __construct() 
	{
		parent::__construct();
	}

	protected function before() 
	{
		// Если needlogin = true - будет выполняться проверка для всего контроллера(т.е. для всех методов) 
		// авторизован пользователь или нет

		// $this->needlogin = true;

		parent::before();
	}	

	public function action_index() 
	{
		$this->action_page();	
	}

	public function action_page() 
	{
		$this->keywords = 'блог, разработка, ооп';
		$this->description = 'Просмотр статей блога';

		$page_num = isset($this->params[2]) ? (int)$this->params[2] : 1;

		if (!$page_num)
			$this->p404();

		$mPagination = new M_Pagination(TABLE_PREFIX . 'articles', '/page/');

		$res = $mPagination->fields(TABLE_PREFIX  . 'articles.*, ' . TABLE_PREFIX. 'users.login as login')
							->left_join(TABLE_PREFIX. "users using(id_user)")
							->order_by('id_article DESC')							
							->on_page(4)->page_num($page_num)->page();
		if(!$res)
			$this->p404();							

		foreach ($res as $article) {

			$article['intro'] = M_Articles::Instance()->intro($article);
			$articles[] = $article;
		}

		$navbar = $this->template('inc/v/v_navbar.php', ['navparams' => $mPagination->navparams()]);
		
		// генерация сайдбара
		$aside = $this->template('inc/v/v_aside.php');

		$this->content = $this->template('inc/v/articles/v_index.php', 
		[
			'articles' => $articles,
			'aside' => $aside,
			'navbar' => $navbar,
			'navparams' => $mPagination->navparams()
		]);			
	}

	public function action_editor() 
	{
		$this->styles = [
			'../libs/bootstrap/dist/css/bootstrap', 
			'sb-admin', 
			'admin.min'
		];

		$this->scripts = [
			'jquery.min',
			'bootstrap.bundle.min',
			'jquery.easing.min',
			'sb-admin.min',
			'scripts-admin.min'
		];

		$page_num = isset($this->params[2]) ? (int)$this->params[2] : 1;

		if (!$page_num)
			$this->p404();		

		$mPagination = new M_Pagination(TABLE_PREFIX . 'articles', '/articles/editor/');

		// Если у текущего пользователя роль ALL - выводим все статьи, иначе только родные
		if (M_Users::Instance()->Can('ALL')) {
			$articles = $mPagination->fields(TABLE_PREFIX  . 'articles.*, ' . TABLE_PREFIX. 'users.login as login')
								->left_join(TABLE_PREFIX . "users using(id_user)")
								->order_by('id_article DESC')
								->on_page(10)->page_num($page_num)->page();
		}
		else {
			$id_user = (int)$this->user['id_user'];
			$articles = $mPagination->fields(TABLE_PREFIX  . 'articles.*, ' . TABLE_PREFIX. 'users.login as login')
					->left_join(TABLE_PREFIX . "users using(id_user)")
					->order_by('id_article DESC')
					->where("id_user = '$id_user'")
					->on_page(10)->page_num($page_num)->page();
		}

		// if (!$articles)
		// 	$this->p404();							
		
		$navbar = $this->template('inc/v/v_navbar.php', ['navparams' => $mPagination->navparams()]);
		$this->title = " Консоль администратора | Редактор статей";
		$this->template = "../admin/v_admin.php";
		
		// массив выводится в базовый шаблон
		$this->classes = ['items_collapse_art' => 'show', 
			'color_art_edit' => 'color-white', 
			'class_name_art' => 'collapse_bg'
		];

		$this->content = $this->template('inc/v/articles/v_editor.php',[
			'articles' => $articles,
			'navbar' => $navbar,
			'navparams' => $mPagination->navparams(),
		]);		
	}	

	public function action_get() 
	{
		$id_article = (isset($this->params[2])) ? (int)$this->params[2] : null;

		// если id не введен или params>3
		if (!$id_article || count($this->params)>3)
			$this->p404();
		
		$mArticles = M_Articles::Instance();
		$mComments = M_Comments::Instance();

		$fields = [];
		$errors = [];

		$article = $mArticles->get($id_article);

		if (!$article)
			$this->p404();

		$this->title = $article['title'];
		$aside = $this->template('inc/v/v_aside.php');

		$comments = $mComments->all($id_article);

		if ($this->isPost()) {
			$_POST['id_article'] = (int)$id_article;
			$_POST['dt'] = time();

				if ($mComments->add($_POST)) 					
					$_SESSION['comment_succ'] = '<p class="comment_succ">Ваш комментарий будет опубликован после модерации</p>';			
				
				else {
					$_SESSION['errors'] = $mComments->errors();
					$_SESSION['fields'] = $_POST;				
				}
				
				$this->Redirect("/post/$id_article#comments-add");
		}

		$this->content = $this->template('inc/v/articles/v_article.php', [
			'article' => $article, 
			'aside' => $aside,
			'fields' => ($_SESSION['fields'] ?? ''),
			'errors' => ($_SESSION['errors'] ?? ''),
			'comment_succ' => ($_SESSION['comment_succ'] ?? ''),
			'comments' => $comments
		]);

		unset($_SESSION['comment_succ']); 		
		unset($_SESSION['errors']);
		unset($_SESSION['fields']); 		
	}

	public function action_add() 
	{
		$this->styles = [
			'../libs/bootstrap/dist/css/bootstrap', 
			'sb-admin', 
			'admin.min'
		];

		$this->scripts = [
			'jquery.min',
			'bootstrap.bundle.min',
			'jquery.easing.min',			
			'../libs/ckeditor/ckeditor/ckeditor',
			'../libs/ckeditor/ck_init',
			'sb-admin.min', 
			'scripts-admin.min', 
		];			

		$mArticles = M_Articles::Instance();		
		$fields = [];
		$errors = [];
		
		if ($this->IsPost()) {
			$_POST['dt'] = time();
			$_POST['id_user'] = $this->user['id_user'];

			if ($mArticles->add($_POST)) 
				$this->Redirect('/articles/editor');	
			

			$errors = $mArticles->errors();
			$fields = $_POST;	
		}

		// массив выводится в базовый шаблон
		$this->classes = ['items_collapse_art' => 'show', 
			'color_art_add' => 'color-white', 
			'class_name_art' => 'collapse_bg'
		];	

		$this->title = " Консоль администратора | Добавить статью";
		$this->template = "../admin/v_admin.php";
		// метка для раскрывающегося меню
		$this->content = $this->template('inc/v/articles/v_add.php', 
		[	
		    'errors' => $errors, 
		    'fields' => $fields
		]);		
	}

	public function action_edit()
	{
		$id_article = (isset($this->params[2])) ? (int)$this->params[2] : null;

		if ($id_article == null)
			$this->p404();

		$this->styles = [
			'../libs/bootstrap/dist/css/bootstrap', 
			'sb-admin', 
			'admin.min'
		];		

		$this->scripts = [
			'scripts-admin.min', 
			'sb-admin.min', 
			'../libs/ckeditor/ckeditor/ckeditor',
			'../libs/ckeditor/ck_init'
		];	

		$fields = [];
		$errors = [];				

		$mArticles = M_Articles::Instance();

		if (!empty($_POST['delete'])) {
			$mArticles->delete($id_article);
			$this->Redirect('/articles/editor');

		} elseif(!empty($_POST['save'])) {
			if($mArticles->edit($id_article, $_POST))
				$this->Redirect('/articles/editor');

			$errors = $mArticles->errors();
			$fields = $_POST;			
		} else{
			// Если у текущего пользователя роль ALL - get() делает выборку всех статей без проверки
			if (M_Users::Instance()->Can('ALL'))
				$fields = $mArticles->get($id_article);
				// иначе проверяется id_user и выводятся статьи только созданные текущим пользователем
			else
				$fields = $mArticles->get_self($id_article, (int)$this->user['id_user']);	

			if (!$fields)
				$this->p404();
		}

		// массив выводится в базовый шаблон
		$this->classes = ['items_collapse_art' => 'show', 
			'color_art_edit' => 'color-white', 
			'class_name_art' => 'collapse_bg'
		];

		$this->title .= " | Редактировать статью";
		$this->template = "../admin/v_admin.php";						
		$this->content = $this->template('inc/v/articles/v_edit.php', 
		[	
		    'errors' => $errors, 
		    'fields' => $fields
		]);
	}		

	public function action_delete() 
	{
		if($this->isGet()) 
		{			
			M_Articles::Instance()->delete($this->params[2]);
			$this->redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function action_404()
	{
		$this->title = '404 - Not Found';
		$this->content = $this->template('inc/v/v_404.php');
		// выбор другого базового шаблона для ошибки 404 
		$this->template = 'v_main_404.php';
	}
}