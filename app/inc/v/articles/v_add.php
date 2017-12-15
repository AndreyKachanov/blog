<div class="articles_editor">
	<h1 class="page_title add">Добавление статьи</h1>
	<div style="clear: both;"></div>
	<? if(!empty($errors)): ?>
	<? foreach($errors as $error): ?>
		<p class="error"><?=$error?></p>
	<? endforeach; ?>
	<? endif; ?>

	<form method="POST">

		<div class="form-group">
			<label for="title">Название статьи:</label>
			<input name="title" type="text" class="form-control" id="title" value="<?=$fields['title'] ?? ''?>">
		</div>
		<div class="form-group">
			<label for="replace">Содержимое статьи:</label>
			<textarea name="content" class="form-control" id="replace" rows="10"><?=$fields['content'] ?? ''?></textarea>
		</div>

		<button class="btn btn-secondary" type="submit">Добавить</button>
	</form>
</div>