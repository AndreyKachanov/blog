<?php
	//если в массиве только одно значения запись должна быть в таком виде 'role' => ['field']
	return [

		TABLE_PREFIX . 'articles' => [
			'fields' => ['id_article', 'title', 'content', 'dt', 'id_user'], 
			'not_empty' => ['id_article', 'title', 'content', 'dt', 'id_user'],
			//массив 'html_allowed' нужно объявлять обязательно, даже если он пустой
			'html_allowed' => ['content'],
			'range' => [
						'title' => ['3', '160']
						],
			'labels' => [
				'title' => '"Название статьи"',
				'content' => '"Содержимое статьи"',
				'dt' => '"Дата"',
			],
			'pk' => 'id_article'
		],
		TABLE_PREFIX . 'users' => [
			'fields' => ['login', 'name', 'password', 'id_role'],
			'not_empty' => ['login', 'name', 'password', 'id_role'],
			'unique' => ['login'],
			'only_latin_letters' => ['login'],
			'html_allowed' => [],
			'range' => [
				'login' => ['3', '10'],
				'name' => ['3','10']
			],
			'labels' => [
				'login' => '"Логин"',
				'name' => '"Имя"',
				'password' => '"Пароль"',
				'id_role' => '"Роль на сайте"'
			],
			'pk' => 'id_user'
		],
		TABLE_PREFIX . 'comments' => [
			'fields' => ['id_comment', 'id_article', 'author', 'comment', 'captcha', 'is_show', 'dt'],
			'not_empty' => ['id_comment', 'id_article', 'author', 'comment', 'captcha', 'is_show', 'dt'],
			'html_allowed' => [''],
			'valid_captcha' => ['captcha'], 			
			'range' => [
						'author' => ['3', '100'],
						'comment' => ['30', '500']
						],
			'labels' => [
				'author' => '"Автор комментария"',
				'comment' => '"Комментарий"',
				'captcha' => '"Капча"'
			],
			'pk' => 'id_comment'									
		]
	];
	
