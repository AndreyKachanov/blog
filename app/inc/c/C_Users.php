<?php

class C_Users extends C_Admin_Base
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

		$mPagination = new M_Pagination(TABLE_PREFIX . 'users', '/users/page/');
		
		$users = $mPagination->fields(TABLE_PREFIX . "users.id_user, "  . TABLE_PREFIX . "users.login, 
									  " . TABLE_PREFIX . "roles.description as role, " . TABLE_PREFIX . "privs.description as description_priv")
							 ->left_join(TABLE_PREFIX . "roles using(id_role)")
							 ->left_join(TABLE_PREFIX . "privs2roles using(id_role)")
							 ->left_join(TABLE_PREFIX . "privs using(id_priv)")
							 ->order_by("id_user DESC")
							 ->on_page(10)->page_num($page_num)->page();
		if(!$users)
			$this->p404();							 		

		$navbar = $this->template('inc/v/v_navbar.php', ['navparams' => $mPagination->navparams()]);
		
		// массив выводится в базовый шаблон
		$this->classes = ['items_collapse_usr' => 'show', 
			'color_usr_edit' => 'color-white', 
			'class_name_usr' => 'collapse_bg'
		];

		$this->title .= ' | Пользователи';	
		$this->content = $this->template('inc/v/users/v_index.php', [
			'users' => $users,
			'navbar' => $navbar,
			'navparams' => $mPagination->navparams() 
		]);		
	}

	public function action_add()
	{
		
		$mUsers = M_Users::Instance();
		
		$errors = []; 
		$fields = [];

		if($this->isPost())
		{
			if($mUsers->add($_POST))
				$this->redirect('/users');
				
			$errors = $mUsers->errors();
			$fields = $_POST;
		}

		// массив выводится в базовый шаблон
		$this->classes = ['items_collapse_usr' => 'show', 
			'color_usr_add' => 'color-white', 
			'class_name_usr' => 'collapse_bg'
		];	

		$this->title .= ' | Добавление пользователя';
		$this->content = $this->template('inc/v/users/v_add.php', [
			'fields' => $fields, 
			'errors' => $errors, 
			'roles' => $mUsers->getRoles()
		]);	
	}

	public function action_edit()
	{
		$mUsers = M_Users::Instance();
		$errors = [];

		$id_user = (isset($this->params[2])) ? (int)$this->params[2] : null;

		if ($id_user == null || $id_user == 1)
			$this->p404();	
		
		if($this->isPost())
		{
			if($mUsers->edit($id_user, $_POST))
			{
				$this->redirect('/users');
			}
						
			$errors = $mUsers->errors();
			$fields = $_POST;
		}
		else
			$fields = $mUsers->get($id_user);

		// массив выводится в базовый шаблон
		$this->classes = ['items_collapse_usr' => 'show', 
			'color_usr_edit' => 'color-white', 
			'class_name_usr' => 'collapse_bg'
		];

		$this->title .= ' | Редактирование пользователя';		
		$this->content = $this->Template('inc/v/users/v_edit.php',  
		[
			'fields' => $fields, 
			'errors' => $errors, 
			'roles' => $mUsers->getRoles()
		]);	
	}	



	public function action_delete() 
	{
		if (!M_Users::Instance()->Can('ALL'))
			$this->p404();

		$id_user = (isset($this->params[2])) ? (int)$this->params[2] : null;
		
		// если id не введен или params > 3 или id равен админскому		
		if (!$id_user || count($this->params) > 3 || $id_user == 1)
			$this->p404();

		// при удалении пользователя просто меняем ему роль на 0
		$res = M_Users::Instance()->changeRole($id_user);

		// $res = M_Users::Instance()->delete($id_user);
		if (!$res)
			$this->p404();

		$this->redirect($_SERVER['HTTP_REFERER']);
	}		
}