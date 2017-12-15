<? if(!empty($errors)): ?>
<? foreach($errors as $error): ?>
	<p class="error"><?=$error?></p>
<? endforeach; ?>
<? endif; ?>

<form method="POST">

	<div class="form-group">
		<label for="title">Название статьи:</label>
		<input name="title" type="text" class="form-control" id="title" value="<?=$fields['title'] ?? '';?>">
	</div>
	<div class="form-group">
		<label for="replace">Содержимое статьи:</label>
		<textarea name="content" class="form-control" id="replace" rows="10"><?=$fields['content'] ?? '';?></textarea>
	</div>
	<input class="btn btn-secondary" type="submit" value="Сохранить" name="save">
	<input class="btn btn-secondary" type="submit" value="Удалить" name="delete" onClick="javascript: return confirm('Вы действительно хотите удалить?')">
</form>