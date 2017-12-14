<?php 

class M_Articles extends M_Model 
{
	// прием синглтон(одиночка)
	// таким методом будет создаваться только 1 объект
	// Позволяет не плодить экземпляры класса, а пользоваться одним
	private static $instance;
	private $tab_name = TABLE_PREFIX . "articles"; //имя таблицы articles с учетом префикса
	// private $db;

	public function __construct() 
	{
		parent::__construct($this->tab_name, 'id_article');
	}

	public static function Instance() 
	{
		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function get($id_article)
	{
		$id_article = (int)$id_article;
		$query = "SELECT {$this->tab_name}.*, " . TABLE_PREFIX . "users.login FROM {$this->tab_name} 
				  INNER JOIN " . TABLE_PREFIX . "users USING(id_user) WHERE id_article = '$id_article'";

		$res = $this->db->Select($query);
		return ($res[0] ?? null);
	}	

	public function get_self($id_article, $id_user)
	{
		return $res = parent::get_self($id_article, $id_user);	
	}

	public function add($fields)
	{
		$res = parent::add($fields);			
		return $res;
	}

	public function edit($pk, $fields)
	{
		$res = parent::edit($pk, $fields);			
		return $res;
	}

	public function delete($pk)
	{
		return parent::delete($pk);
	}
	
	public function intro($article) 
	{
		$res = $article['content'];
		if (strlen($res) > 290) {
			$res = mb_substr($article['content'], 0, 800);
			$temp = explode(" ", $res);
			unset($temp[count($temp)-1]);
			$res = implode(" ", $temp) . " ...";
		} 
		return $res;
	}
	
}