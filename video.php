<?php 
/**
Plugin Name: Video Short Code
Plugin URI: https://github.com/caijiamx/video-short-code
Description: This plugin can  insert video quikly width shortcode ,specially for some chinese video sites, like  youku.com,tudou.com,ku6.com.
Author: Matt
Version: 1.1
Author URI: http://www.xbc.me
*/

class VideoShortCode{
    public function __construct(){
        add_shortcode('youku', array($this , 'play_youku'));
        add_shortcode('tudou', array($this , 'play_tudou'));
        add_shortcode('ku6', array($this , 'play_ku6'));
        add_shortcode('youtube', array($this , 'play_youtube'));
    }

    public function run(){

    }

    public function play_youtube($atts){
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
    }

    public function play_youku($atts){
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

    public function play_tudou($atts){
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

    public function play_ku6($atts){
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
}

$shortcode = new VideoShortCode();
$shortcode->run();