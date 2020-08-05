<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php bloginfo('name'); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="header-block">
	<div class="header-container">
        <div class="header-container__logo-image">
        	<div class="header-container__logo-image--wrapper">
        		<a href="<?php echo esc_url(home_url('/')); ?>">
        			<i class="fas fa-desktop"></i><span> Kenyu</span>
        		</a>
        	</div>
        </div>
        <?php if(is_front_page()): ?>
        <ul class="menu-block">
        	<li class="menu-block__menu-item">
        		<a href="#home-block" class="menu-block__menu-item--menu-link">Home</a>
        	</li>
        	<li class="menu-block__menu-item">
        		<a href="#about-block" class="menu-block__menu-item--menu-link">About</a>
        	</li>
        	<li class="menu-block__menu-item">
        		<a href="#skill-block" class="menu-block__menu-item--menu-link">Skill</a>
        	</li>
        	<li class="menu-block__menu-item">
        		<a href="#work-block" class="menu-block__menu-item--menu-link">Works</a>
        	</li>
        	<li class="menu-block__menu-item">
        		<a href="#contact-block" class="menu-block__menu-item--menu-link">Contact</a>
        	</li>
        </ul>
        <div class="menu-icon">
        	<a class="menu-icon__link">
        		<span class="menu-icon__link--line-top"></span>
        		<span class="menu-icon__link--line-center"></span>
        		<span class="menu-icon__link--line-bottom"></span>
        	</a>
        </div>
        <?php else: ?>
        <div class="page-nation">
            <?php
            $next_post = get_next_post();
            $prev_post = get_previous_post();
            ?>
            <?php if($next_post): ?>
        	<div class="next">
        		<a class="another-link" href="<?php echo get_permalink($next_post->ID); ?>">次の作品</a>
        	</div>
        	<?php endif; ?>
        	<?php if($prev_post): ?>
        	<div class="prev">
        		<a class="another-link" href="<?php echo get_permalink($prev_post->ID); ?>">前の作品</a>
        	</div>
        	<?php endif; ?>
        </div>
        <?php endif; ?>

	</div>

<div class="gnav">
    	<ul class="gnav__wrapper">
    		<li class="gnav__wrapper--item"><a href="#home-block">Home</a></li>
    		<li class="gnav__wrapper--item"><a href="#about-block">About</a></li>
    		<li class="gnav__wrapper--item"><a href="#skill-block">Skill</a></li>
    		<li class="gnav__wrapper--item"><a href="#work-block">Works</a></li>
    		<li class="gnav__wrapper--item"><a href="#contact-block">Contact</a></li>
    	</ul>
</div>
</header>