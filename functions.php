<?php

/*
 * Plugin Name: VP News Ticker
 * Plugin URI: http://wordpress.org/plugins/vp-news-ticker/
 * Description: A brief description of the Plugin.
 * Version: 1.0
 * Author: Maruf Arafat
 */

function vp_news_ticker_plugin() {
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'vp_style', plugins_url('css/ticker-style.css', __FILE__), true, 1.0);
    wp_enqueue_script( 'vp_newsticker_js', plugins_url( '/js/jquery.ticker.js', __FILE__ ), array('jquery'), 1.0, false);
}

add_action('init','vp_news_ticker_plugin');

function vp_news_ticker_shortcode($atts){
	extract( shortcode_atts( array(
		'ppp' => '4',
		'type' => 'post',
		'cat' => '',
		'id' => 'news',
		'title' => 'Latest',
		'speed' => '0.10',
		'fus' => '300',
		'fis' => '600',
		'poi' => '2000',
		'color' => '#000',
		'bg' => '#999',
	), $atts, 'pricing_table' ) );
	
    $q = new WP_Query(
        array('posts_per_page' => $ppp, 'post_type' => $type, 'category_name' => $cat)
        );		
		
		
	$list = '
	<script type="text/javascript">
    jQuery(function () {
        jQuery("#VP_Ticker'.$id.'").ticker({
        speed: '.$speed.',
        controls: false,
        fadeOutSpeed: '.$fus.' ,
        fadeInSpeed: '.$fis.',
        pauseOnItems: '.$poi.',
        titleText: "'.$title.'",

        });
    });
	</script>
	<style>
		.ticker-wrapper .ticker-title{color:'.$color.';background:'.$bg.';padding:7px 10px;}
		.ticker-wrapper .ticker{padding-bottom:6px;}
		.ticker-wrapper .ticker-content{padding-bottom: 2px;padding-left: 5px;background: none;}
		.ticker-wrapper .ticker-content a{color:'.$bg.';}
	</style>

	<ul id="VP_Ticker'.$id.'" class="js-hidden">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$list .= '<li class="news-item"><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';        
	endwhile;
	$list.= '</ul>';
	wp_reset_query();
	return $list;
}
add_shortcode('VP_Ticker', 'vp_news_ticker_shortcode');	

?>