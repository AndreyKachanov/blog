<div class="register" id="register">
	<form method="POST" id="form_reg" class="container" novalidate>

		<div class="form-group row-smart">
			<div class="col-smart">
				<p id="error-auth" class="text-center">Регистрация пользователя</p>
			</div>		
		</div>

		<div class="form-group row-smart">
			<div class="col-smart">
				<input type="text" id="login" name="login" value="<?=$login?>" class="form-control <?=$inval_class['login']?>" placeholder="Ваш логин или E-mail" required>
				<div class="invalid-feedback"><?=$errors['login']?></div>
			</div>
		</div>

		<div class="form-group row-smart">
			<div class="col-smart">
				<input type="text" id="name" name="name" value="<?=$name?>" class="form-control <?=$inval_class['name']?>" placeholder="Ваше имя" required>
				<div class="invalid-feedback"><?=$errors['name']?></div>
			</div>	
		</div>

		<div class="form-group row-smart">
			<div class="col-smart">
				<input type="password" id="password" name="password" value="<?=$password?>" class="form-control <?=$inval_class['password']?>" placeholder="Введите пароль" required>
				<div class="invalid-feedback"><?=$errors['password']?></div>
			</div>
		</div>

		<div class="form-group row-smart">
			<div class="col-smart">
				<input type="password" id="password_confirm" name="password_confirm" value="<?=$password_confirm?>" class="form-control <?=$inval_class['passwords_not_match']?>" placeholder="Введите подтверждение" required>
				<div class="invalid-feedback"><?=$errors['passwords_not_match']?></div>
			</div>	
		</div>

		<div class="form-group row-smart row-captcha">
			
			<div class="col-smart" id="append">
				<img class="" src="imgcaptcha.php" id="captcha_reload">
				<!--кнопка обновления капчи-->
<!-- 				<button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('captcha_reload').src = '/imgcaptcha.php?' + Math.random()"><i class="fa fa-refresh" aria-hidden="true" ></i>
				</button> -->
			</div>
		</div>

		<div class="form-group row-smart">
			<div class="col-smart">
				<input type="text" id="captcha" name="captcha" value="" class="form-control <?=$inval_class['captcha']?>" placeholder="Введите код капчи" required>
				<div class="invalid-feedback"><?=$errors['captcha']?></div>
			</div>
		</div>

		<div class="form-group row-smart button-reg">
			<div class="col-smart">
				<button type="submit" class="btn btn-secondary w-100">Регистрация</button>
			</div>
		</div>

		<div class="form-group text-center">
			<a href="/auth/login">Войти</a>
		</div>

	</form>
</div>