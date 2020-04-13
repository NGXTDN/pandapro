<?php

/*
            /$$            
    /$$    /$$$$            
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$ 
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/ 
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-16 11:36:51
  	@Last Modified by:   Dami
  	@Last Modified time: 2018-01-10 21:05:47

*/
if( !class_exists('MiShare') ) :

class MiShare {

	//private $config;

	private $config;

	function __construct(){

		$this->config = array(
			'url'   => get_permalink(),
			'title' => get_the_title(),
			'pic'   => null,
			'des'   => pandapro_print_excerpt(40, null, false),
		);

	}

	function __set($property,$value){ 
    	$this->$property = $value; 
    }

    /**
     * [weibo Share]
     * @return [str] [ Share api link]
     */
	public function weibo() {

		$pic = isset($this->config['pic']) ? '&pic='.urlencode( $this->config['pic'] ) : '';

		if( isset( $this->config['des'] ) ){
			$text = urlencode( sprintf( '【%s】%s', $this->config['title'], $this->config['des']) );
		}else{
			$text = $this->config['title'];
		}

		$share_link = sprintf( '//service.weibo.com/share/share.php?url=%s&type=button&language=zh_cn&title=%s%s&searchPic=true', urlencode( $this->config['url'] ), $text , $pic );

		return $share_link;
		
	}

	/**
	 * [qq Share]
	 * @return [str] [ Share api link]
	 */
	public function qq() {

		$pic = isset($this->config['pic']) ? '&pics='.urlencode( $this->config['pic'] ) : '';

		$des = isset($this->config['des']) ? '&summary='.urlencode($this->config['des']) : '';
		
		$share_link = sprintf( 'https://connect.qq.com/widget/shareqq/index.html?url=%s&title=%s%s%s', urlencode( $this->config['url'] ), urlencode($this->config['title']), $pic, $des );

		return $share_link;


	}

	/**
	 * [weixin Share]
	 * @return [str] [Share qrcode link]
	 */
	public function weixin() {

		$share_link = get_template_directory_uri() . '/modules/qrcode.php?data='.urlencode( $this->config['url'] );

		return $share_link;		

	}

	/**
	 * facebook
	 */
	public function facebook(){
		$share_link = sprintf( 'https://www.facebook.com/sharer.php?u=%s', urlencode( $this->config['url'] ) );
		return $share_link;	
	}

	/**
	 * twitter
	 */
	public function twitter(){
		$share_link = sprintf( 'https://twitter.com/intent/tweet?url=%s', urlencode( $this->config['url'] ) );
		return $share_link;	
	}

	/**
	 * linkedin
	 */
	public function linkedin(){
		$share_link = sprintf( 'https://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s&summary=%s', urlencode( $this->config['url'] ), urlencode($this->config['title']), urlencode($this->config['des']) );
		return $share_link;	
	}


}
endif;
// $s = new MiShare();
// $s->config = array( 'url' => 'https://www.baidu.com', 'title' => '标题', 'pic' => 'https://cdn.v2ex.com/gravatar/afa39accf8700cbbe7b13e1d01aa5b17', 'des' => '123');

// echo $s->weixin();

