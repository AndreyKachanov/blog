<a href="" class="comment-pic">
	<img src="img/1.gif">
</a>
<div class="comment-wrapper">
	<a class="author" href="#">
		<span>
		</span>
	</a>
	<div class="comment">
	</div>	
</div>

<?=$comment_succ?>
<? if(!empty($errors)): ?>
<? foreach($errors as $error): ?>
	<p style="color: red;"><?=$error?></p>
<? endforeach; ?>
<? endif; ?>

<div class="comments-add" id="comments-add">
	<form method="POST">
		<div class="form-group">
			<label for="author">Автор комментария:</label>
			<input name="author" type="text" class="form-control" id="author" value="<?=$fields['author'] ?? ''?>">
		</div>
		<div class="form-group">
			<label for="comment">Комментарий:</label>
			<textarea name="comment" class="form-control" id="comment" rows="10"><?=$fields['comment'] ?? ''?></textarea>
		</div>
	
		<div class="form-group captcha_row">
			<div id="append_comments">
				<!-- <label for="replace">Капча</label><br> -->
				<img class="" src="imgcaptcha.php" id="captcha_comments">
			</div>
			<input type="text" name="captcha" value="" class="form-control" placeholder="Введите код капчи">
		</div>

		<button class="btn btn-secondary" type="submit">Комментировать</button>
	</form>
</div>