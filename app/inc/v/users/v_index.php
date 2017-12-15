<? extract($navparams); ?>
<div class="articles_editor">
	<h1 class="page_title add">Пользователи</h1>
	<a href="/users/add">Добавить</a>

	<?if(isset($users)):?>
	<table class="table table-bordered">
		<thead>
			<tr class="table-active">
				<th>№</th>
				<th>Логин</th>
				<th>Роль</th>
				<th>Привилегии</th>
				<th>Убрать все права</th>
			</tr>
		</thead>
		<tbody>
			<? $i = ($page_num - 1) * $on_page + 1; ?>
			<? foreach($users as $user): ?>
				<tr>
					<td><?=$i?></td>
					<td>
						<? if($user['id_user'] != 1): ?>
							<a href="/users/edit/<?=$user['id_user']?>"><?=$user['login']?></a>
						<? else: ?>
							<span><?=$user['login']?></span>
						<? endif; ?>		
					</td>
					<td><?=$user['role']?></td>
					<td><?=$user['description_priv']?></td>
					<td>
						<? if($user['id_user'] != 1): ?>
							<a href="/users/delete/<?=$user['id_user']?>" onClick="javascript: return confirm('Вы действительно хотите убрать права?')">Убрать</a>						
						<? endif; ?>
					</td>	

				</tr>
			<? $i++; endforeach;?>				
		</tbody>
	</table>
	<?=$navbar ?>
	<?endif;?>
</div>

