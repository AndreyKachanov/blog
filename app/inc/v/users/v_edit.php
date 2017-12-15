<h2>Редактирование данных пользователя: <?=$fields['login']?></h2></br>
<? if(!empty($errors)): ?>
<? foreach($errors as $error): ?>
	<p class="error"><?=$error?></p>
<? endforeach; ?>
<? endif; ?>

<form method="POST">

	<div class="form-group">
		<label for="login">Логин:</label>
		<input name="login" type="text" class="form-control" id="login" value="<?=$fields['login'] ?? ''?>">
	</div>
	<div class="form-group">
		<label for="password">Пароль:</label>
		<input type="password" name="password" class="form-control" id="password">
	</div>
	<div class="form-group">
		<label for="role">Роль:</label>
		<select name="id_role">
			<? foreach($roles as $key => $role): ?>
				<option value="<?=$key?>" <?php if($role['id_role'] == @$fields['id_role']) echo 'selected';?>>
					<?=$role['description']?>
				</option>
			<? endforeach ?>
		</select>
	</div>	

	<button class="btn btn-secondary" type="submit">Сохранить</button>
</form>