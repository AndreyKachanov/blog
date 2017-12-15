<?php 
class C_Admin extends C_Admin_Base 
{
	public function __construct() 
	{
		parent::__construct();
	}

	public function before() 
	{
		parent::before();
	}	

	public function action_index() 
	{
		// массив выводится в базовый шаблон
		// массив выводится в базовый шаблон
		$this->classes = ['class_name' => 'collapse_bg'];

		$this->title .= "";
		$this->content = $this->template('inc/v/admin/v_index.php');
	}		
}