<?php 

class C_Auth extends C_Base 
{
	public function action_login() {		
		$this->adminlink = false;			
		$mUsers = M_Users::Instance();
		// Очистка старых сессий.
		$mUsers->ClearSessions();
		// Выход.
		$mUsers->Logout();

		// массив с ошибками, для распечатки в шаблоне
		$errors = [];

		$errors['login'] = '';
		$errors['password'] = '';
		$errors['auth'] = '';

		// если идет POST запрос
		if ($this->IsPost()) {
			$login = $_POST['login'];
			$password = $_POST['password'];

			// если 2 поля заполнены
			if ( !empty($login) && !empty($password) ) {
				// если метод Login вернул истину - авторизуем, иначе выводим блок incorrect_password  
				if ( $mUsers->Login($login, $password, isset($_POST['remember']))  ) {
					   // если идет ajax запрос
					   if( $this->IsAjax() ) {
							header('Content-type: application/json');
					   		echo json_encode(array('type' => 'good'));
					   		die();				   	
					   }
					   // если js отключен 
					   else {
							header('location: /');
					   }

				// если метод Login вернул ложь	   	
				} 
				else {
					 // если идет ajax запрос
					if( $this->IsAjax() ) {
						header('Content-type: application/json');						
						echo json_encode(array('type' => 'bad'));
						die();						
					} 
					// если js отключен	
					else {
						// подключем класс error-auth, который выводит ошибку
						$errors['auth'] = 'error-auth';		
					}
				}

			} 
			else {

				// если 2 поля пустые
				if ( empty($login) && empty($password)) {
					$errors['login'] = 'is-invalid';	
					$errors['password'] = 'is-invalid';
				// если логин пустой, пароль не пустой		
				} elseif( empty($login) && !empty($password) ) {
					$errors['login'] = 'is-invalid';
				// если логин не пустой, пароль пустой					
				} elseif ( !empty($login) && empty($password) ) {
					$errors['password'] = 'is-invalid';	
				}
					
			}			
		} 
		// если мы зашли 1 раз
		else {
			$login = '';
			$password = '';	
		}		
		$this->title .= ' | Авторизация пользователя';
		$this->content = $this->Template('inc/v/auth/v_login.php', 
			[
				'errors' => $errors, 
				'login' => $login, 
				'password' => $password
			]
		);	
	}

	public function action_register() 
	{
		$mUsers = M_Users::Instance();
		// Очистка старых сессий.
		$mUsers->ClearSessions();

		// массив под ошибки
		$errors = [];
		// массив классов is-invalid и is-valid
		$inval_class = [];
		// логи занят
		$login_exists = '';
		$display_block = '';		

		if ( $this->IsPost() ) {			
			$errors = $mUsers->CheckRegister($_POST, $_SESSION['keycaptcha']);

			// переменны для сохранения полей input
			$login = $_POST['login'];
			$name = $_POST['name'];
			$password = $_POST['password'];			
			$password_confirm = $_POST['password_confirm'];


			// если в массиве errors 0 ошибок	
			if ( count(array_diff($errors, array(''))) == 0 ) {
				// если метод вернул истину - регистрируем, иначе выводим login_exists (логин занят) 
				if ( $mUsers->Registration($login, $password) ) {

					if ($this->IsAjax()) {
						header('Content-type: application/json');
					   	echo json_encode(array('type' => 'good'));
					   	die();							
					} else{
						$reg_status = true;
					}

				} else {

					if ($this->IsAjax()) {
						header('Content-type: application/json');
						echo json_encode(array('type' => 'bad'));
						die();	
					} else {
						$errors['login'] = "Данный логин уже занят PHP";
					}

				}

			}								

			foreach ($errors as $key => $value) {
				if ($value != '') {
					$inval_class[$key] = 'is-invalid';
				} else {
					$inval_class[$key] = 'is-valid';
				}			
			}

		} else {
			// пустые переменные для полей input
			$login = '';
			$name = '';
			$password = '';
			$password_confirm = '';
			$captcha = '';

			// invalid-feedback texts
			$errors['login'] = '';
			$errors['name'] = '';
			$errors['password'] = '';
			$errors['passwords_not_match'] = '';
			$errors['captcha'] = '';

			$inval_class['login'] = '';
			$inval_class['name'] = '';
			$inval_class['password'] = '';
			$inval_class['passwords_not_match'] = '';
			$inval_class['captcha'] = '';
		}

		$this->title .= " | Регистрация пользователя";
		// если удачно зарегистрировались
		if (isset($reg_status))
			$this->content = $this->Template('inc/v/auth/v_successfull_reg.php');	
		else
			$this->content = $this->Template('inc/v/auth/v_register.php', 
				[
					'errors' => $errors, 
				    'inval_class' => $inval_class, 
				    'login' => $login,
				    'name' => $name, 
				    'password' => $password,
				    'password_confirm' => $password_confirm,
				    'login_exists' => $login_exists,
				    'display_block' => $display_block
				]
			);
																		   	
	}

	// Проверка капчи с помощью ajax
	public function action_captcha() 
	{
		if($this->IsAjax()) {
			if (strtoupper($_POST['captcha']) == strtoupper($_SESSION['keycaptcha'])) {
				header('Content-type: application/json');
				echo json_encode(array('type' => 'good')); 
				die();
			} else {
			    header('Content-type: application/json');           
			    echo json_encode(array('type' => 'bad')); 
			    die();  
			}
		}		
	}
}