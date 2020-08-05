	<div class="work-detail-container">
		<div class="work-detail-caption">
			<h2 class="work-language-title">使用言語</h2>
			<p class="work-language">
				<?php the_field('language'); ?>
			</p>
			<h2 class="work-language-title">習得した技術・知識</h2>
			<?php the_content();?>
			<?php if(post_custom('site-url')): ?>
			<a href="<?php the_field('site-url'); ?>" target="_bland">
				WEB SITE
			</a>
			<?php endif; ?>
		</div>
		<div class="work-detail-image">
			<img src="<?php the_field('main_image'); ?>">
		</div>
	</div>
