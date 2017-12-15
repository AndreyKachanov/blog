<div class="articles_editor">
	<h1 class="page_title add">Редактирование комментария</h1>
	<div style="clear: both;"></div>
	<? if(!empty($errors)): ?>
	<? foreach($errors as $error): ?>
		<p class="error"><?=$error?></p>
	<? endforeach; ?>
	<? endif; ?>

	<form method="POST">
		<div class="form-group">
			<p>Комментарий id = <strong><?=$fields['id_comment']?></strong></p>
			<p>Статья - <strong><?=$fields['art_title']?></strong></p>
			<label for="author">Автор комментария:</label>
			<input name="author" type="text" class="form-control" id="author" value="<?=$fields['author'] ?? ''?>">
		</div>
		<div class="form-group">
			<label for="comment">Комментарий:</label>
			<textarea name="comment" class="form-control" id="comment" rows="10"><?=$fields['comment'] ?? ''?></textarea>
		</div>

		<div class="form-group">
		    <label class="radio">
		      <input type="radio" name="is_show" value="1" <?if ($fields['is_show'] == '1') echo 'checked';?>>
		      Отображать
		    </label>
		    <label class="radio">
		      <input type="radio" name="is_show" value="0" <?if ($fields['is_show'] == '0') echo 'checked';?>>
		      Не отображать
		    </label>	
		</div>
		<button class="btn btn-secondary" type="submit">Сохранить</button>
	</form>
</div>