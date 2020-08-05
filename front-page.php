<?php get_header(); ?>

<div class="home-block" id="home-block">
	<div class="title-wrapper">
    	<div class="title-wrapper__ityped-block">
    		<h1 class="title-wrapper__ityped-block--title"><?php bloginfo('title'); ?></h1>
    		<h3 class="title-wrapper__ityped-block--caption">
    			<?php bloginfo('description'); ?>
    		</h3>
    		<span id="ityped" class="ityped-block__ityped-content"></span>
        </div>
    </div>
</div>

<?php
$about_obj = get_page_by_path('about');
$post = $about_obj;
setup_postdata($post);
?>
<div class="about-block" id="about-block">
	<div class="about-wrapper outer-container">
		<h1 class="common-title">
			<?php the_title(); ?>
		</h1>
		<div class="about-container">
			<div class="about-container__image fadeIn">
				<img src="<?php the_field('main_image'); ?>">
			</div>
			<div class="about-container__caption fadeIn">
				<h2>関川 権祐</h2>
				<p><?php the_content(); ?></p>
<!-- 				<a href="https://twitter.com/mugiwara0622"> -->
<!-- 				<i class="fab fa-twitter fa-2x"></i> -->
<!-- 				</a> -->
			</div>
		</div>
	</div>
</div>
<?php wp_reset_postdata(); ?>

<?php
$skill_obj = get_page_by_path('skill');
$post = $skill_obj;
setup_postdata($post);
?>
<div class="skill-block" id="skill-block">
	<div class="skill-wrapper inner-container">
		<h1 class="common-title">
			<?php the_title(); ?>
		</h1>
		<p class="common-caption">
			<?php echo get_the_excerpt(); ?>
		</p>
<?php wp_reset_postdata();?>
		<div class="skill-container">
<?php
$skills = get_terms('skill');
foreach($skills as $skill):
$args = array(
    'post_type' => 'appeal',
    'tax_query' => array(
        array(
            'taxonomy' => 'skill',
            'field' => 'slug',
            'terms' => $skill->slug,
        ),
    ),
    'posts_per_page' => -1,
);
$skill_query = new WP_Query($args);
if($skill_query->have_posts()):
    while($skill_query->have_posts()): $skill_query->the_post();
?>
			<article class="skill-article fadeIn">
				<h2 class="skill-title">
					<?php the_title(); ?>
				</h2>
				<div class="skill-content">
					<?php the_content(); ?>
				</div>
			</article>
<?php
    endwhile;
    wp_reset_postdata();
endif;
endforeach;
?>
		</div>
	</div>
</div>

<?php
$work_obj = get_page_by_path('works');
$post = $work_obj;
setup_postdata($post);
?>
<div class="work-block" id="work-block">
	<div class="work-wrapper outer-container">
		<h1 class="common-title">
			<?php the_title(); ?>
		</h1>
		<p class="common-caption">
			<?php echo get_the_excerpt(); ?>
		</p>
<?php wp_reset_postdata();?>
		<div class="work-container">
			<div class="pop-bg"></div>
<?php
$works = get_terms('work');
foreach($works as $work):
$args = array(
    'post_type' => 'appeal',
    'tax_query' => array(
        array(
            'taxonomy' => 'work',
            'field' => 'slug',
            'terms' => $work->slug,
        ),
    ),
    'posts_per_page' => -1,
);
$work_query = new WP_Query($args);
if($work_query->have_posts()):
    while($work_query->have_posts()): $work_query->the_post();
?>
    		<div class="pop-wrapper" id="pop-<?php the_ID(); ?>">
				<div class="pop-img">
					<img src="<?php the_field('main_image'); ?>">
				</div>
				<p class="pop-caption"><?php the_title(); ?></p>
				<div class="pop-btn">&#x00D7;</div>
			</div>
    		<div class="article-wrapper fadeIn">
    			<article class="work-article">
    				<?php the_post_thumbnail('medium'); ?>
    				<a class="work-link" href="#pop-<?php the_ID(); ?>">
						<div class="article-item">
							<h3 class="work-term">
								<?php echo $work->name; ?>
							</h3>
							<h2 class="work-title">
								<?php the_title(); ?>
							</h2>
						</div>
    				</a>

    			</article>
    			<a href="<?php the_permalink(); ?>" class="article-link">
    				detail
    			</a>
    		</div>
<?php
    endwhile;
    wp_reset_postdata();
endif;
endforeach;
?>
		</div>
	</div>
</div>



<div class="contact-block" id="contact-block">
<?php
$contact_page = get_page_by_path('contact');
$post = $contact_page;
setup_postdata($post);
?>
	<div class="contact-wrapper inner-container">
		<h1 class="common-title">
			<?php the_title(); ?>
		</h1>
		<p class="contact-caption">
			<?php echo get_the_excerpt(); ?>
		</p>
		<div class="contact-content">
			<?php the_content(); ?>
		</div>
	</div>
<?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>