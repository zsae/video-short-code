<?php 
/**
Plugin Name: Insert Video With Shortcode
Plugin URI: http://www.xbc.me/wordpress-shortcode-for-insert-video/
Description: This plugin can  insert video quikly width shortcode ,specially for some chinese video sites, like  youku.com,tudou.com,ku6.com.
Author: Matt
Version: 1.0
Author URI: http://www.xbc.me
*/
/*function play_youtube($atts){
	extract(shortcode_atts(array(
	'code'=>'',
	'width'=>'480',
	'height'=>'400'
	),$atts));
	$flash = '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$code.'&hl=en_US&fs=1&autoplay=1"><param name="quality" value="high"><param name="allowScriptAccess" value="always"><param name="flashvars" value="playMovie=true&isAutoPlay=true"></object>';
	if(is_single()){
	return $flash ;
	}
	return '';
}*/
function play_youku($atts){
	extract(shortcode_atts(array(
	'code'=>'',
	'width'=>'480',
	'height'=>'400'
	),$atts));
	$flash = '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://player.youku.com/player.php/sid/'.$code.'/v.swf"><param name="quality" value="high"><param name="allowScriptAccess" value="always"><param name="flashvars" value="playMovie=true&isAutoPlay=true"></object>';
	if(is_single()){
	return $flash ;
	}
	return '';
}
function play_tudou($atts){
	extract(shortcode_atts(array(
	'code'=>'',
	'width'=>'480',
	'height'=>'400'
	),$atts));
	$flash = '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://www.tudou.com/v/'.$code.'/v.swf"><param name="quality" value="high"><param name="allowScriptAccess" value="always"><param name="flashvars" value="playMovie=true&isAutoPlay=true"></object>';
	if(is_single()){
	return $flash ;
	}
	return '';
}
function play_ku6($atts){
	extract(shortcode_atts(array(
	'code'=>'',
	'width'=>'480',
	'height'=>'400'
	),$atts));
	$flash = '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://player.ku6.com/refer/'.$code.'/v.swf"><param name="quality" value="high"><param name="allowScriptAccess" value="always"><param name="flashvars" value="playMovie=true&isAutoPlay=true"></object>';
	if(is_single()){
	return $flash ;
	}
	return '';
}
	//add_shortcode('youtube', 'play_youtube');
	add_shortcode('youku', 'play_youku');
	add_shortcode('tudou', 'play_tudou');
	add_shortcode('ku6', 'play_ku6');
?>