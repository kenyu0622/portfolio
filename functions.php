<?php
function my_enqueue_scripts(){
    wp_enqueue_script('jquery');
    wp_enqueue_script(
        'script_js',
        get_template_directory_uri().'/assets/js/script.js',
        array(),
        date('YmdGis', filemtime(get_template_directory().'/assets/js/script.js'))
    );
    wp_enqueue_style(
        'my_style',
        get_template_directory_uri().'/assets/css/style.css',
        array(),
        date('YmdGis', filemtime(get_template_directory().'/assets/css/style.css'))
    );
    wp_enqueue_style(
        'font_awesome',
        'https://use.fontawesome.com/releases/v5.6.1/css/all.css'
    );
    wp_enqueue_style(
        'Noto_Sans_Japanese',
        'https://fonts.googleapis.com/earlyaccess/notosansjapanese.css'
    );
    wp_enqueue_style(
        'Sawarabi_Gothic',
        'https://fonts.googleapis.com/css?family=Sawarabi+Gothic'
    );
    wp_enqueue_style(
        'language_font',
        'https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css'
    );




}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

//抜粋分を固定ページに使えるようにする
add_post_type_support('page', 'excerpt');

//抜粋文の文末を変更する
function cms_excerpt_more(){
    return '...';
}
add_filter('excerpt_more', 'cms_excerpt_more');

//抜粋文の改行を有効化する
function apply_excerpt_br($value){
    return nl2br($value);
}

//アイキャッチ画像を有効化する
function thum_setup_theme() {
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'thum_setup_theme' );

//ヘッダーのカスタムメニュー化
register_nav_menus(
    array(
        'place_global' => 'グローバル',
    )
    );

