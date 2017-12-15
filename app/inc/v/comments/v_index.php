<?php extract($navparams); ?>
<div class="articles_editor">
	<h1 class="page_title add">Комментарии</h1>

	<? if(isset($comments)): ?>
	<table class="table table-bordered">
		<thead>
			<tr class="table-active">
				<th>Id</th>
				<th>Автор</th>
				<th>Статья</th>
				<th>Комментарий</th>
				<th>Удалить</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($comments as $comment): ?>
				<tr>
					<td><?=$comment['id_comment']?></td>
					<td><?=$comment['author']?></td>					
					<td><?=$comment['art_title']?></td>
					<td><a href="/comments/edit/<?=$comment['id_comment']?>"><?=$comment['comment']?></a></td>
					<td>
						<a href="/comments/delete/<?=$comment['id_comment']?>" onClick="javascript: return confirm('Вы действительно хотите удалить комментарий?')">Удалить</a>					
					</td>	

				</tr>
			<? 
			endforeach; 
			?>				
		</tbody>
	</table>
	<?=$navbar ?>
	<? endif; ?>
</div>