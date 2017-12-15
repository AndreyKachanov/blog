<?php

class M_Comments extends M_Model 
{
	private static $instance;
	private $tab_name = TABLE_PREFIX . "comments"; //имя таблицы с учетом префикса
	private $art_tab_name = TABLE_PREFIX . "articles";
	
	public function __construct() 
	{
		parent::__construct($this->tab_name, 'id_comment');
	}

	public static function Instance() 
	{
		if (self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function all($id_article)
	{
		$query = "SELECT $this->tab_name.* FROM $this->tab_name 
				  WHERE id_article='$id_article' AND is_show='1' ORDER by id_comment DESC";
		return $res = $this->db->Select($query);
	}

	public function add($fields)
	{
		$res = parent::add($fields);	
		return $res;
	}

	public function get($id_comment)
	{
		$query = "SELECT {$this->tab_name}.*, {$this->art_tab_name}.title as art_title FROM {$this->tab_name} 
				  LEFT JOIN $this->art_tab_name USING(id_article) WHERE id_comment = '$id_comment'";

		$res = $this->db->Select($query);
		return ($res[0] ?? null);
	}			

	public function edit($id_comment, $fields)
	{
		return parent::edit($id_comment, $fields);
	}

	public function delete($pk)
	{
		return parent::delete($pk);
	}	
	
}