<main class="main">
	<div class="container">
		<div class="row_smart">
			<section class="articles">
				<article class="article">
					<h3>
					<a href="/articles/get/<?=$article['id_article']?>">
						<?=$article['title']?>
					</a>
					</h3>
					<div class="article-intro">
						<?=$article['content']?>
					</div>
					<div class="author">
						<i class="fa fa-user" aria-hidden="true"></i>
						<span class="name"><?=$article['login']?></span>
						<span class="data">
							<span class="orange">
								<?=strftime("%e %b %Y", $article['dt']) ?>
							</span>
							в
							<span class="orange">
								<?=strftime("%k:%M", $article['dt']) ?>
							</span>
						</span>
					</div>

					<div class="labels-block">
						<div class="comments">
							<h3>Комментарии:</h3>

							<? if(!empty($comments)): ?>

							<? foreach($comments as $comment): ?>
								<div class="comment-block">
									<div class="user-name"><?=$comment['author']?></div>
									<div class="date"><?=strftime("%e %b %Y в %k:%M", $comment['dt']) ?></div>
									<div class="content"><?=$comment['comment']?></div>
								</div>
							<? endforeach; ?>

							<? else: ?>
								<p>Комментарии отсутствуют</p>
							<? endif; ?>																											
						</div>						
						<div class="comments-form">
							<h3>Оставить комментарий:</h3>
							<? if(!empty($comment_succ)): ?>
								<?=$comment_succ?>
							<? endif; ?>

							<? if(!empty($errors)): ?>

							<? foreach($errors as $error): ?>
								<p class="error"><?=$error?></p>
							<? endforeach; ?>

							<? endif; ?>

							<div class="comments-form-add" id="comments-add">
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
										<label for="captcha">Введите символы отображенные выше:</label>
										<input type="text" id="captcha" name="captcha" value="" class="form-control">
									</div>

									<button class="btn btn-secondary" type="submit">Комментировать</button>
								</form>
							</div>
						</div>					
					</div>
				</article>
			</section>
			<aside class="about">
				<?=$aside?>
			</aside>
		</div>
	</div>
</main>