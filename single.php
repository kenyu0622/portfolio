<?php get_header(); ?>

<div class="work-detail-header">
    <?php
//     $term_obj = get_term_by('slug', 'application', 'work');
    global $post;
    $term_obj = get_the_terms($post->ID, 'work');
    $attachment_id = get_field('work-main-image', $term_obj[0]->taxonomy.'_'.$term_obj[0]->term_id);
    echo wp_get_attachment_image($attachment_id, 'large');
    ?>
	<div class="work-detail-wrapper">
		<h1 class="work-term-name">
			<?php
			global $post;
			$term_obj = get_the_terms($post->ID, 'work');
			echo $term_obj[0]->name;
			?>
		</h1>
		<h1 class="work-detail-title">
			<?php echo get_the_title(); ?>
		</h1>
	</div>
</div>

<?php

?>

<div class="work-detail-block">

<?php
if(have_posts()):
    while(have_posts()): the_post();
        get_template_part('content-single');
    endwhile;
endif;
?>

</div>

<?php get_footer(); ?>