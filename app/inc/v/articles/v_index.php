<? extract($navparams); ?>
<main class="main">
	<div class="container">
		<div class="row_smart">
			<section class="articles">
				<? foreach ($articles as $article): ?>
				<article class="article">
					<h3>
					<a href="/post/<?=$article['id_article']?>">
						<?=$article['title']?>
					</a>
					</h3>
					<div class="article-intro">
						<?=$article['intro'] ?? $article['content'];?>						
					</div>
					<div class="author">
						<i class="fa fa-user" aria-hidden="true"></i>
						<span class="name"><?=$article['login']?>:</span>
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
						<a class="continue" href="/post/<?=$article['id_article']?>">Продолжить...</a>
					</div>
				</article>
				<? endforeach ?>
				
				<!-- Постраничный вывод -->
				<?=$navbar ?>

			</section>
			<aside class="about">
				<?=$aside?>
			</aside>
		</div>
	</div>
</main>