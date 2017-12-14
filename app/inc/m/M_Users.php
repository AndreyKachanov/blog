<?php

class M_Users extends M_Model
{
	private static $instance;	// экземпляр класса
	private $sid;				// идентификатор текущей сессии
	private $uid;				// идентификатор текущего пользователя
	private $onlineMap;			// карта пользователей online
	private $privs_cahce;		// кэш привиллегий пользователя, чтобы БД не мучать при выхове Can
	private $tab_name = TABLE_PREFIX . "users"; //имя таблицы articles с учетом префикса		

	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new self();
			
		return self::$instance;
	}

	//
	// Конструктор
	//
	public function __construct()
	{
		parent::__construct($this->tab_name, 'id_user');
		$this->sid = null;
		$this->uid = null;
		$this->onlineMap = null;
		$this->privs_cahce = [];		
	}

	public function add($fields)
	{
		if (!empty($fields['password']))			
			$fields['password'] = $this->hash($fields['password']);
		
		return parent::add($fields);	
	}

	public function changeRole($id_user)
	{
		return $this->db->Update($this->tab_name, ['id_role' => 0], "id_user='$id_user'");
	}

	public function edit($id_user, $fields)
	{
		if(trim($fields['password']) == "")
			unset($fields['password']);
		else
			$fields['password'] = $this->hash($fields['password']);
		
		$id_user = (int)$id_user;
		return parent::edit($id_user, $fields);
	}					

	//
	// Очистка неиспользуемых сессий
	// 
	public function ClearSessions()
	{
		$min = date('Y-m-d H:i:s', time() - 60 * 20); 			
		$t = "time_last < '%s'";
		$where = sprintf($t, $min);
		$this->db->Delete(TABLE_PREFIX . 'sessions', $where);
	}

	//
	// Авторизация
	// $login 		- логин
	// $password 	- пароль
	// $remember 	- нужно ли запомнить в куках
	// результат	- true или false
	//
	public function Login($login, $password, $remember = true)
	{
		// вытаскиваем пользователя из БД 
		$user = $this->GetByLogin($login);
		
		// если нет роли
		if($user['id_role'] == '0')
			return false;

		if ($user == null)
			return false;
		
		$id_user = $user['id_user'];
				
		// проверяем пароль и роль пользователя
		if ($user['password'] != $this->hash($password))
			return false;
				
		// запоминаем имя и md5(пароль)
		if ($remember)
		{
			// установить куки на 100 дней
			$expire = time() + 3600 * 24 * 100;
			setcookie('login', $login, $expire, BASE_URL);
			setcookie('password', $this->hash($password), $expire, BASE_URL);
		}		
				
		// открываем сессию и запоминаем SID
		$this->sid = $this->OpenSession($id_user);
		
		return true;
	}

	//
	// Выход
	//
	public function Logout()
	{
		setcookie('login', '', time() - 1, BASE_URL);
		setcookie('password', '', time() - 1, BASE_URL);
		unset($_COOKIE['login']);
		unset($_COOKIE['password']);
		unset($_SESSION['sid']);
		// ----------------		
		$this->sid = null;
		$this->uid = null;
	}	

	// Регистрация
	public function Registration($login, $password) 
	{
		
		$login = trim($login);
		$password = trim($password);

		$res = $this->db->Select("SELECT count(*) as cnt FROM $this->tab_name WHERE login = '$login'");
		
		// если логина нет в бд(т.е. == null) - возвращаем true
		// return ($res[0] == null) ? true : false;
		if ( $res[0]['cnt'] == 0 ) {
			 $user = [];
			 $user['login'] = $login;
			 $user['password'] = $this->hash($password);
			 // id_role = 2 - роль контент менеджера
			 $user['id_role'] = 0;
			 $this->db->Insert($this->tab_name, $user);
			 return true; 
		} else {
			return false;
		}

	}

	public function CheckRegister($post, $session_captcha) 
	{
		// массив с ошибками
		$errors = [];

		if ( empty($post['login']) || 
			!preg_match('/^[a-z0-9]{3,10}$/', $post['login']) ) {
			$errors['login'] = 'Логин должен состоять из латинских символов и цифр, содежрать от 3 до 10 символов.';		
		} else {
			$errors['login'] = '';
		}

		if ( empty($post['name']) || 
			!preg_match('/^[а-яА-Я]+$/iu', $post['name']) ) {
			$errors['name'] = 'Имя должно состоять из русских букв.';		
		} else {
			$errors['name'] = '';
		}			

		if ( empty($post['password']) || 
			 !preg_match('/(?=^.{5,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/', $post['password'])) {
			$errors['password'] = 'Пароль должен состоять из латинских символов c верхним регистром и цифр, минимум 5 символов.';
		} else {
			$errors['password'] = '';
			$psw_valid = $post['password'];
		} 

		// echo (!isset($psw_valid)) ? "истина" : "ложь";

		if ( !isset($psw_valid) || $post['password_confirm'] != $post['password']) {
			$errors['passwords_not_match'] = 'Подтверждение не совпадает с паролем.';	
		} else {
			$errors['passwords_not_match'] = '';
		}

		if ( strtoupper($session_captcha) != strtoupper($post['captcha']) ) {
			$errors['captcha'] = 'Неверный код капчи. PHP';
		} else {
			$errors['captcha'] = '';	
		}

		return $errors;						
	}

	public function Get($id_user = null)
	{	
		// Если id_user не указан, берем его по текущей сессии.
		if ($id_user == null)
			$id_user = $this->GetUid();
			
		if ($id_user == null)
			return null;
			
		// А теперь просто возвращаем пользователя по id_user.
		$t = "SELECT * FROM $this->tab_name WHERE id_user = '%d'";
		$query = sprintf($t, $id_user);
		$result = $this->db->Select($query);

		// file_put_contents("test.txt", "1" . PHP_EOL, FILE_APPEND);
		return $result[0];		
	}	
						
	//
	// Получение id текущего пользователя
	// результат	- UID
	//
	public function GetUid()
	{	
		// Проверка кеша.
		if ($this->uid != null)
			return $this->uid;	

		// Берем по текущей сессии.
		$sid = $this->GetSid();
				
		if ($sid == null)
			return null;
			
		// $t = "SELECT id_user FROM sessions WHERE sid = '%s'";
		// $query = sprintf($t, mysql_real_escape_string($sid));
		// file_put_contents("test.txt", 1 . PHP_EOL);
		$result = $this->db->Select("SELECT id_user FROM " . TABLE_PREFIX . "sessions WHERE sid = '$sid'");
				
		// Если сессию не нашли - значит пользователь не авторизован.
		if (count($result) == 0)
			return null;
			
		// Если нашли - запоминм ее.
		$this->uid = $result[0]['id_user'];
		return $this->uid;
	}

	// public function GetBySid($sid) {}	
	
	//
	// Получает пользователя по логину
	//
	public function GetByLogin($login)
	{	

		$result = $this->db->Select("SELECT * FROM $this->tab_name WHERE login = '$login'");

		if (isset($result[0])) 
			return $result[0];
		
	}
			
	//
	// Проверка наличия привилегии
	// $priv 		- имя привилегии
	// $id_user		- если не указан, значит, для текущего
	// результат	- true или false
	//
	public function Can($priv, $id_user = null)
	{		
		if ($id_user == null)
		    $id_user = $this->GetUid();
		    
		if ($id_user == null)
		    return false;
		
		if (!isset($this->privs_cahce[$priv][$id_user])) {	

			$t = "SELECT count(*) as cnt FROM " . TABLE_PREFIX. "privs2roles p2r
				  LEFT JOIN $this->tab_name u ON u.id_role = p2r.id_role
				  LEFT JOIN " . TABLE_PREFIX . "privs p ON p.id_priv = p2r.id_priv 
				  WHERE u.id_user = '%d' AND (p.name = '%s' OR p.name = 'ALL')";
		
			$query  = sprintf($t, $id_user, $priv);

			// file_put_contents("test.txt", "1" . PHP_EOL, FILE_APPEND);

			$result = $this->db->Select($query);
			$this->privs_cahce[$priv][$id_user] = ($result[0]['cnt'] > 0);
		}

		return $this->privs_cahce[$priv][$id_user];
	}

	public function GetPrivs()
	{	
		$user = $this->Get();
		
		if($user == null)
			return [];

		$query = "SELECT " . TABLE_PREFIX . "privs.name as name FROM " . TABLE_PREFIX . "privs2roles LEFT JOIN " . TABLE_PREFIX . "privs using(id_priv) 
			 WHERE id_role = '{$user['id_role']}'";
		$result = $this->db->Select($query);
		// file_put_contents("test.txt", "1" . PHP_EOL, FILE_APPEND);
		$privs = [];
		
		foreach($result as $one)
			$privs[] = $one['name'];
			
		return $privs;
	}

	public function getRoles()
	{	
		return $this->db->Select("SELECT * FROM " . TABLE_PREFIX . "roles");
	}		

	// Проверка активности пользователя
	// $id_user		- идентификатор
	// результат	- true если online
	//
	public function IsOnline($id_user)
	{		
		if ($this->onlineMap == null)
		{	    
		    $t = "SELECT DISTINCT id_user FROM " . TABLE_PREFIX ."sessions";		
		    $query  = sprintf($t, $id_user);
		    $result = $this->db->Select($query);
		    
		    foreach ($result as $item)
		    	$this->onlineMap[$item['id_user']] = true;		    
		}
		
		return ($this->onlineMap[$id_user] != null);
	}
	

	public function hash($str) {
		return md5(md5($str . HASH_KEY));
	}

	//
	// Функция возвращает идентификатор текущей сессии
	// результат	- SID
	//
	private function GetSid()
	{
		// Проверка кеша.
		if ($this->sid != null)
			return $this->sid;
	
		// Ищем SID в сессии.

		if ( isset($_SESSION['sid']) ) {
			$sid = $_SESSION['sid'];
		} else {
			$sid = null;
		}
								
		// Если нашли, попробуем обновить time_last в базе. 
		// Заодно и проверим, есть ли сессия там.
		if ($sid != null)
		{
			$session = [];
			$session['time_last'] = date('Y-m-d H:i:s'); 			
			// $t = "sid = '%s'";
			// $where = sprintf($t, mysql_real_escape_string($sid));
			$where = "sid = '$sid'";			
			$affected_rows = $this->db->Update(TABLE_PREFIX . 'sessions', $session, $where);

			if ($affected_rows == 0)
			{
				// $t = "SELECT count(*) FROM sessions WHERE sid = '%s'";		
				$query = "SELECT count(*) FROM " . TABLE_PREFIX . "sessions WHERE sid = '$sid'";
				$result = $this->db->Select($query);
				
				if ($result[0]['count(*)'] == 0)
					$sid = null;			
			}			
		}		
		
		// Нет сессии? Ищем логин и md5(пароль) в куках.
		// Т.е. пробуем переподключиться.
		if ($sid == null && isset($_COOKIE['login']))
		{
			$user = $this->GetByLogin($_COOKIE['login']);
			
			if ($user != null && $user['password'] == $_COOKIE['password'])
				$sid = $this->OpenSession($user['id_user']);
		}
		
		// Запоминаем в кеш.
		if ($sid != null)
			$this->sid = $sid;
		
		// Возвращаем, наконец, SID.
		return $sid;		
	}
	
	//
	// Открытие новой сессии
	// результат	- SID
	//
	private function OpenSession($id_user)
	{
		// генерируем SID
		$sid = $this->GenerateStr(10);
				
		// вставляем SID в БД
		$now = date('Y-m-d H:i:s'); 
		$session = [];
		$session['id_user'] = $id_user;
		$session['sid'] = $sid;
		$session['time_start'] = $now; 
		$session['time_last'] = $now;				
		$this->db->Insert(TABLE_PREFIX . 'sessions', $session); 
				
		// регистрируем сессию в PHP сессии
		$_SESSION['sid'] = $sid;				
				
		// возвращаем SID
		return $sid;	
	}

	//
	// Генерация случайной последовательности
	// $length 		- ее длина
	// результат	- случайная строка
	//
	private function GenerateStr($length = 10) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;  

		while (strlen($code) < $length) 
            $code .= $chars[mt_rand(0, $clen)];  

		return $code;
	}						
}	