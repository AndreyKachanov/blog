<? extract($navparams); ?>
<div class="articles_editor">
	<h1 class="page_title add">Статьи</h1>
	<a href="/articles/add">Добавить</a>

	<?if(isset($articles)):?>
	<table class="table table-bordered">
		<thead>
			<tr class="table-active">
				<th>№</th>
				<th>Заголовок</th>
				<th>Просмотр</th>
				<th>Удаление</th>
				<th>Автор</th>
				<th>Дата</th>
			</tr>
		</thead>
		<tbody>
			<? $i = ($page_num - 1) * $on_page + 1; ?>
			<? foreach($articles as $article): ?>
				<tr>
					<td><?=$i?></td>
					<td><a href="/articles/edit/<?=$article['id_article']?>"><?=$article['title']?></a></td>
					<td><a target="_blank" href="/articles/get/<?=$article['id_article']?>">Просмотреть</a></td>
					<td><a href="/articles/delete/<?=$article['id_article']?>" onClick="javascript: return confirm('Вы действительно хотите удалить?')">Удалить</a></td>
					<td><?=$article['login']?></td>
					<td><?=strftime("%d:%m:%Y %M:%S", $article['dt']) ?></td>
				</tr>
			<? $i++; endforeach;?>				
		</tbody>
	</table>
	<?=$navbar ?>
	<?endif;?>
</div>

