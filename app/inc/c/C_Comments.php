<?php

class C_Comments extends C_Admin_Base
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

		// если у текущего пользователя нет роли ALL - выкидываем
		if (!M_Users::Instance()->Can('ALL'))
			$this->p404();		
	}	

	public function action_index() 
	{
		$this->action_page();	
	}

	public function action_page()
	{
		$page_num = isset($this->params[2]) ? (int)$this->params[2] : 1;

		if (!$page_num)
			$this->p404();

		$mPagination = new M_Pagination(TABLE_PREFIX . 'comments', '/comments/page/');

		$comments = $mPagination->fields(TABLE_PREFIX  . 'comments.*, bg717s_articles.title as art_title')
							->left_join("bg717s_articles using(id_article)")
							->order_by("id_comment DESC")
							->on_page(11)->page_num($page_num)->page();
		if(!$comments)
			$this->p404();							 		

		$navbar = $this->template('inc/v/v_navbar.php', ['navparams' => $mPagination->navparams()]);
		
		// массив выводится в базовый шаблон
		$this->classes = ['items_collapse_comm' => 'show', 
			'color_comm_edit' => 'color-white', 
			'class_name_comm' => 'collapse_bg'
		];

		$this->title .= ' | Комментарии';	
		$this->content = $this->template('inc/v/comments/v_index.php', 
		[
			'comments' => $comments,
			'navbar' => $navbar,
			'navparams' => $mPagination->navparams() 
		]);		
	}

	public function action_edit()
	{
		$id_comment = (isset($this->params[2])) ? (int)$this->params[2] : null;

		if ($id_comment == null)
			$this->p404();

		$mComments = M_Comments::Instance();
		$errors = []; 				
		
		if ($this->isPost()) {
			if($mComments->edit($id_comment, $_POST)) {
				$this->redirect('/comments');
			}
						
			$errors = $mComments->errors();
			$fields = $_POST;

			$fields['id_comment'] = $_SESSION['id_comment'];
			$fields['art_title'] = $_SESSION['art_title'];
		}
		else{
			$fields = $mComments->get($id_comment);
			
			if(!$fields)
				$this->p404();			

			$_SESSION['id_comment'] = $fields['id_comment'];
			$_SESSION['art_title'] = $fields['art_title'];
		}

		// массив выводится в базовый шаблон
		$this->classes = ['items_collapse_comm' => 'show', 
			'color_comm_edit' => 'color-white', 
			'class_name_comm' => 'collapse_bg'
		];

		$this->title .= ' | Редактирование комментария';		
		$this->content = $this->Template('inc/v/comments/v_edit.php', [
			'fields' => $fields, 
			'errors' => $errors
		]);	
	}	

	public function action_delete() 
	{
		if (!M_Users::Instance()->Can('ALL'))
			$this->p404();

		$id_comment = (isset($this->params[2])) ? (int)$this->params[2] : null;
		
		// если id не введен или params > 3	
		if (!$id_comment || count($this->params) > 3)
			$this->p404();

		$res = M_Comments::Instance()->delete($id_comment);

		if(!$res)
			$this->p404();

		$this->redirect($_SERVER['HTTP_REFERER']);
	}		
}