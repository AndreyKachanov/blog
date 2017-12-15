<div class="login">
    <form method="POST" id="form_login" class="container" novalidate>
        
        <div id="error-auth" class="form-group invalid-feedback <?=$errors['auth']?>">Неверный логин или пароль!</div>
        
        <div class="form-group row-smart">
            <div class="col-smart">
                <input type="text" name="login" class="form-control <?=$errors['login']?>" value="<?=$login?>" placeholder="Логин или E-mail" required>
                <div class="invalid-feedback">Введите логин.</div>
            </div>
        </div>

        <div class="form-group row-smart">
            <div class="col-smart">
                <input type="password" name="password" class="form-control <?=$errors['password']?>" value="<?=$password?>" placeholder="Пароль" required>
                <div class="invalid-feedback">Введите пароль.</div>
            </div>
        </div>
        
        <div class="form-group row-smart">
            <div class="col-smart">
                <label class="form-check-label"><input type="checkbox" name="remember" class="form-check-input"> Запомнить</label>
                <button type="submit" class="btn btn-secondary">Войти</button>
                <a href="/auth/register" class="btn btn-secondary">Регистрация</a>
            </div> 
        </div>
    </form>
</div>