<?php 
/**
 * Plugin Name: Video Short Code
 * Plugin URI: https://github.com/caijiamx/video-short-code
 * Description: This plugin can  insert video quikly width shortcode ,specially for some chinese video sites, like  youku.com,tudou.com,ku6.com.
 * Author: Matt
 * Version: 1.1
 * Author URI: http://www.xbc.me
*/

define('VIDEO_SHORT_CODE_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('VIDEO_SHORT_CODE_PLUGIN_URL', plugin_dir_url( __FILE__ ));

class VideoShortCode{
    public $debug        = true;
    private $_optionKey  = 'video_short_code_notices';
    private $_textDomain = 'video_short_code';
    private $_logFile    = 'video_short_code.log';
    private $_object = array(
        'youku'   => 'http://player.youku.com/player.php/sid/{code}/v.swf',
        'tudou'   => 'http://www.tudou.com/a/{code}/v.swf',
        'ku6'     => 'http://player.ku6.com/refer/{code}/v.swf',
        'tvsohu'  => 'http://share.vrs.sohu.com/{code}/v.swf&topBar=1&autoplay=false&pub_catecode=0&from=page',
        'vqq'     => 'http://static.video.qq.com/TPout.swf?vid={code}&auto=0',
        'letv'    => 'http://i7.imgs.letv.com/player/swfPlayer.swf?id={code}&autoplay=0',
        '56com'   => 'http://player.56.com/v_{code}.swf',
    );
    private $_regexs = array(
        'youku'   => array(
            'regex' => '/http:\/\/v\.youku\.com\/v_show\/id_(\w+)\.html(\?from=(.*)+)?/',
            'count' => 1,
        ),
        'tudou'   => array(
            'regex' => '/http:\/\/www\.tudou\.com\/listplay\/(\w+)\/(\w+)\.html/',
            'count' => 1,
        ),
        'ku6'     => array(
            'regex' => '/http:\/\/v\.ku6\.com\/show\/([-\w]+\.\.)\.html(\?hpsrc=(\w+))?/',
            'count' => 1,
        ),
        'tvsohu'  => array(
            'regex' => '',
            'count' => 0,
        ),
        'vqq'     => array(
            'regex' => '/http:\/\/v\.qq\.com\/cover\/(\w+)\/(\w+)\.html\?vid=(\w+)/',
            'count' => 3,
        ),
        'letv'    => array(
            'regex' => '/http:\/\/www\.letv\.com\/ptv\/vplay\/(\w+)\.html(\?ref=(\w+))?/',
            'count' => 1,
        ),
        '56com'   => array(
            'regex' => '/http:\/\/www\.56\.com\/(\w+)\/v_(\w+)\.html/',
            'count' => 2,
        ),
    );

    public function __construct(){
        add_action( 'admin_notices', array( $this, 'getNotices' ) );
    }

    public function checkRequire(){
        $result = true;
        $check_functons = array(
            'file_put_contents',
            'preg_match',
        );
        foreach ($check_functons as $function) {
            if(!function_exists($function)){
                $this->error("$function 被禁用，请检查您的服务器是否支持该函数！");
                $result = false;
            }
        }
        return $result;
    }

    public function run(){
        $result = $this->checkRequire();
        if($result){
            $this->_logFile    = VIDEO_SHORT_CODE_PLUGIN_DIR . $this->_logFile;
            $this->loger('$this->_logFile = ' . $this->_logFile , __FUNCTION__);
            add_shortcode('youku', array($this , 'play_youku'));
            add_shortcode('tudou', array($this , 'play_tudou'));
            add_shortcode('ku6', array($this , 'play_ku6'));
            add_shortcode('tvsohu', array($this , 'play_tvsohu'));
            add_shortcode('vqq', array($this , 'play_vqq'));
            add_shortcode('letv', array($this , 'play_letv'));
            add_shortcode('56com', array($this , 'play_56com'));
            add_filter( 'content_save_pre', array($this , 'saveContentBefore'), 10, 1 );
        }
    }

    public function play_youku($atts){
        return $this->_call(__FUNCTION__ , $atts);
    }

    public function play_tudou($atts){
        return $this->_call(__FUNCTION__ , $atts);
    }

    public function play_ku6($atts){
        return $this->_call(__FUNCTION__ , $atts);
    }

    public function play_youtube($atts){
        return $this->_call(__FUNCTION__ , $atts);
    }

    public function play_tvsohu($atts){
        return $this->_call(__FUNCTION__ , $atts);
    }

    public function play_vqq($atts){
        return $this->_call(__FUNCTION__ , $atts);
    }

    public function play_letv($atts){
        return $this->_call(__FUNCTION__ , $atts);
    }

    public function play_56com($atts){
        return $this->_call(__FUNCTION__ , $atts);
    }

    private function _call($name, $atts){
        $type = str_replace('play_', '', $name);
        $atts = shortcode_atts(array(
            'code'   =>'',
            'width'  =>'480',
            'height' =>'400'
        ),$atts);
        $code   = $atts['code'];
        $width  = $atts['width'];
        $height = $atts['height'];
        $data   = $this->_object[$type];
        $data   = str_replace('{code}', $code, $data);
        $flash = '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="' . $data .'"><param name="quality" value="high"><param name="allowScriptAccess" value="always"><param name="flashvars" value="playMovie=true&isAutoPlay=true"></object>';
        $this->loger('$name = ' . $name , __FUNCTION__);
        $this->loger($atts , __FUNCTION__);
        $this->loger('$type = ' . $type , __FUNCTION__);
        $this->loger('$code = ' . $code , __FUNCTION__);
        $this->loger('$data = ' . $data , __FUNCTION__);
        if(is_single()){
            return $flash ;
        }
        return '';
    }

    public function saveContentBefore($content){
        foreach ($this->_regexs as $key => $value) {
            $regex = $value['regex'];
            if($value && $regex){
                $count = $value['count'];
                $replace = '[' . $key . " code='\${" . $count . "}']";
                $content = preg_replace( $regex, $replace , $content);
                $this->loger('$regex = ' . $regex , __FUNCTION__);
                $this->loger('$replace = ' . $replace , __FUNCTION__);
                $this->loger('$content = ' . $content , __FUNCTION__);
            }
        }
        return $content;
    }

    public function error($msg = ''){
        $notices= get_option($this->_optionKey, array());
        $notices[] = __($msg , $this->_textDomain);
        update_option($this->_optionKey, $notices);
    }

    public function getNotices(){
        if ($notices= get_option($this->_optionKey)) {
            foreach ($notices as $notice) {
              echo "<div class='error'><p>$notice</p></div>";
            }
            delete_option($this->_optionKey);
        }
    }

    public function loger($data , $func){
        if($this->debug){
            $data = "$func : " . var_export($data ,true) . "\n";
            $f = file_put_contents($this->_logFile, $data , FILE_APPEND | LOCK_EX);
            if($f === false){
                $this->error('写入日志文件失败');
            }
        }
    }
}

$shortcode = new VideoShortCode();
$shortcode->run();