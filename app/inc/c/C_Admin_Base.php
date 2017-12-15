<?php 

// Базовый контроллер блога
abstract class C_Admin_Base extends C_Controller 
{
	protected $title;	// заголовок страницы
	protected $bread_title; //заголовок для хлебных крошек
	protected $content; // содержание страницы
	protected $needlogin;
	protected $user;
	protected $styles;
	protected $scripts;
	protected $classes = []; //имена классов для меню в админке.


	protected function __construct() 
	{
		$this->needlogin = true;
		$this->user = M_Users::Instance()->Get();
		$this->template = 'v_admin.php';
		$this->styles = ['../libs/bootstrap/dist/css/bootstrap', 'sb-admin', 'admin.min'];
		$this->scripts = [
			'jquery.min',
			'bootstrap.bundle.min',
			'jquery.easing.min',
			'sb-admin.min',
			'scripts-admin.min'
		];				
	}

	protected function before() 
	{
		if($this->needlogin && $this->user === null)
			$this->p404();
			// $this->Redirect('/login');


		$this->title = "Консоль администратора";
		$this->content = '';
	}

	// Генерация базового шаблона
	public function render() 
	{
		$vars = [
					'title' => $this->title, 
			     	'content' => $this->content,
			     	'user' => $this->user['login'],
					'styles' => $this->styles,
					'scripts' => $this->scripts,
					'classes' => $this->classes
				];

		$page = $this->template("inc/v/admin/{$this->template}", $vars);
		echo $page;
	}
}