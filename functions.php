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

//キャストの個人ページでスケジュールを表示したい
function singlecalendar($id) {
    $week = array("日", "月", "火", "水", "木", "金", "土");
    $today = strtotime(date("Y-m-d", strtotime("+3 hour")));
    echo '<div class="krc_calendar clearfix">';
    for ($i = 0; $i <= 6; $i++) {
        $yy = date('w', strtotime('+'.$i.' day'));
        $y = date('D', strtotime('+'.$i.' day', $today));
        if ( date('Y-m-d', strtotime('+'.$i.' day', $today)) == $day ) $y = 'target';
        echo '<dl><dt class="' . mb_strtolower($y) . '">' . strtoupper(date('n/j(' . $week[$yy] . ')', strtotime('+'.$i.' day', $today))) . '</dt>';
        if ( $casttime = today_schedule($id, date('Y-m-d', strtotime('+'.$i.' day', $today))) ) {
            echo '<dd>';
            if ($casttime['starttime'] !== '0') echo esc_html($casttime['starttime']);
            echo '～';
            if ($casttime['endtime'] !== '0') echo esc_html($casttime['endtime']);
            echo '</dd></dl>';
        } else {
            echo '<dd>-</dd></dl>';
        }
    }
    echo '</div>';
}
function today_schedule($id, $day = '') { //本日の出勤確認
    $day = $day != '' ? $day : date("Y-m-d",strtotime("+3 hour"));
    $day = htmlentities($day, ENT_QUOTES, 'utf-8');
    $works = outschedule($day);
    if ($works && $works !='rest' && array_key_exists($id, $works) ) {
        return $works[$id];
    } else {
        return false;
    }
}

//スケジュール
function outschedule($day) { //DBから該当の日付のデータを取得
    global $wpdb;
    $table_name = $wpdb->prefix . 'krc_schedules';
    $schedules = $wpdb->get_var(
        $wpdb->prepare("SELECT work FROM $table_name WHERE day = %s AND status = %d", $day, 0)
        );
    $works = unserialize($schedules);
    return  $works;  //配列にして返す
}

function schedulesHtml() { //ショートコードの中身
    $day = isset($_GET["works"]) ? $_GET['works'] : date("Y-m-d");
    $works = outschedule($day);
    $len = 6; //+1

    $week = array("日", "月", "火", "水", "木", "金", "土");
    $w = date('w', strtotime($day));
    echo '<header class="sub_h_header">';
    echo '<h2 class="sub_h">' . date('n/j', strtotime($day));
    echo '(' . $week[$w] . ')';
    echo 'の出勤スケジュール</h2>';
    echo '</header>';

    echo '<nav class="krc_calendar clearfix"><ul>';
    for ($i = 0; $i <= $len; $i++) {
        $yy = date('w', strtotime('+'.$i.' day'));
        $y = date('D', strtotime('+'.$i.' day'));
        if ( date('Y-m-d', strtotime('+'.$i.' day')) == $day ) $y = 'target';
        echo '<li class="' . mb_strtolower($y) . '"><a href="' . home_url( '/' )  . '/schedule/?works=' . date('Y-m-d', strtotime('+'.$i.' day')) . '">' . strtoupper(date('n/j(' . $week[$yy] . ')', strtotime('+'.$i.' day'))) . '</a></li>';
    }
    echo '</ul></nav>';

    if (!$works) {
        //予定がない場合
        echo '<br>';
    } else if ( $works !='rest' ) {
        echo '<div class="container"><div class="row">';
        //postid順に配列に入っているのでs_order順にした配列を作る
        $works_array = array();
        foreach($works as $id => $val){
            $works_array[$val["s_order"]] = $id;
        }
        ksort($works_array);
        foreach ($works_array as $rder => $id) {
            $args = array(
                'post_type' => 'krc_cast',
                'post__in' => array($id),
            );
            query_posts($args);
            while ( have_posts() ) : the_post();
            set_query_var( 'work', $works[$id]);
            get_template_part('content',('castschedule'));
            endwhile;
            wp_reset_query();

        }
        echo '</div></div>';
    } else {
        //休み
        echo '<br>';
    }
}
add_shortcode('scheduleshtml', 'schedulesHtml'); //[scheduleshtml]というショートコードを作成

//TOPページ等に本日の出勤キャストを表示したい
function todaysCastHtml ($day = '') { //本日の出勤
    $time9 = 9 - 6;//6時に次の日のスケジュールに切り替わる仕様
    $day = $day != '' ? $day : date("Y-m-d",strtotime("+".$time9." hour"));
    $works = outschedule($day);
    addSchedules($works);
}
function addSchedules($works) {
    $schedule = 'schedule';

    if (!$works) {
        //予定がない場合
        echo '<br>';
    } else if ( $works !='rest' ) {
        $works_array = array();
        foreach($works as $id => $val){
            $works_array[$val["s_order"]] = array(
                'id'=> $id,
                'time' => $val
            );
        }
        ksort($works_array);
        foreach ($works_array as $id => $work) {
            $args = array(
                'post_type' => 'krc_cast',
                'post__in' => array($work['id']),
                'orderby' => 'post__in'
            );
            //$test =
            query_posts($args);
            //printR($test);
            while ( have_posts() ) : the_post();
            set_query_var( 'schedule', $work['time'] );
            get_template_part( 'content', 'castlist' ); //content-castlist.phpは用意しておいて下さい。
            endwhile;
            wp_reset_query();
        }
    } else {
        //休み
        echo '';
    }
}