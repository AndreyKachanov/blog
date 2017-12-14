<?php 

// Базовый контроллер блога
abstract class C_Base extends C_Controller 
{
	protected $title;	// заголовок страницы
	protected $content; // содержание страницы
	protected $needlogin;
	protected $user;
	protected $keywords;
	protected $description;
	protected $styles;
	protected $scripts;
	protected $template; //базовый шаблон
	protected $adminlink; // метка для скрытых разделов
	protected $classes = []; //имена классов для меню в админке.


	public function __construct() 
	{
		$this->needlogin = false;
		$this->user = M_Users::Instance()->Get();

		$this->keywords = '';
		$this->description = '';
		$this->template = 'v_main.php';
		$this->styles = ['main.min'];
		$this->scripts = ['scripts.min'];
		$this->adminlink = false;		
	}	


	protected function before() 
	{
		if($this->needlogin && $this->user === null)
			$this->Redirect('/login');

		// if(M_Users::Instance()->Can('PAGES')){
		if (isset($this->user))
			$this->adminlink = true;

		$this->title = "Main | Личный блог";
		$this->content = '';
	}

	// Генерация базового шаблона
	public function render() 
	{
		$vars = array('title' => $this->title, 'content' => $this->content,
					  'user' => $this->user['login'],
					  'keywords' => $this->keywords,
					  'description' => $this->description,
					  'styles' => $this->styles,
					  'scripts' => $this->scripts,
					  'adminlink'=> $this->adminlink,
					  'classes' => $this->classes 
		);

		$page = $this->template("inc/v/base_templates/{$this->template}", $vars);
		echo $page;
	}
}