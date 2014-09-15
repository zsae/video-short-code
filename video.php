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
    private $_object = array(
        'youku'   => 'http://player.youku.com/player.php/sid/{code}/v.swf',
        'tudou'   => 'http://www.tudou.com/v/{code}/v.swf',
        'ku6'     => 'http://player.ku6.com/refer/{code}/v.swf',
        'tvsohu'  => 'http://share.vrs.sohu.com/{code}/v.swf',
        'vqq'     => 'http://static.video.qq.com/TPout.swf?vid={code}&auto=0',
        'letv'    => 'http://i7.imgs.letv.com/player/swfPlayer.swf?id={code}&autoplay=0',
        '56com'   => 'http://player.56.com/v_{code}.swf',
    );
    public function __construct(){
        add_shortcode('youku', array($this , 'play_youku'));
        add_shortcode('tudou', array($this , 'play_tudou'));
        add_shortcode('ku6', array($this , 'play_ku6'));
        add_shortcode('youtube', array($this , 'play_youtube'));
        add_shortcode('tvsohu', array($this , 'play_tvsohu'));
        add_shortcode('vqq', array($this , 'play_vqq'));
        add_shortcode('letv', array($this , 'play_letv'));
        add_shortcode('56com', array($this , 'play_56com'));
    }

    public function run(){

    }

    public function __call($name, $arguments){
        $atts = $arguments[0];
        $type = str_replace('play_', '', $name);
        extract(shortcode_atts(array(
        'code'=>'',
        'width'=>'480',
        'height'=>'400'
        ),$atts));
        $data = $this->_object($type);
        $data = str_replace('{code}', $code, $data);
        $flash = '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="' . $data .'"><param name="quality" value="high"><param name="allowScriptAccess" value="always"><param name="flashvars" value="playMovie=true&isAutoPlay=true"></object>';
        if(is_single()){
            return $flash ;
        }
        return '';
    }
}

$shortcode = new VideoShortCode();
$shortcode->run();