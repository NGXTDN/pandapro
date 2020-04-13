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
  	@Date:   2018-12-29 02:36:11
  	@Last Modified by:   Dami
  	@Last Modified time: 2018-12-29 11:10:02

*/

if( !class_exists('Nc_Store_Skin') ){

	include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

	class Nc_Store_Skin extends WP_Upgrader_Skin {

	    public function feedback( $stream, ...$args ){

	    }

	    public function header(){

	    }

		public function footer(){

		}
	}

}

if( !function_exists('nicetheme_store_install_program') ){

	function nicetheme_store_install_program(){

		if( !current_user_can('manage_options') ) die('蛤？');

		$api_domain = 'https://www.nicetheme.cn';
		$api_url = $api_domain . '/wp-json/nicetheme-store/v1/get-nc-store';

		$response = wp_remote_get( $api_url );

		if ( is_array( $response ) && $response['response']['code'] == 200 ) {
			$body = json_decode( $response['body'] );

			if( isset( $body->status ) && $body->status == 200 ){

				include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' ); 
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				include_once( ABSPATH . 'wp-admin/includes/file.php' );
				include_once( ABSPATH . 'wp-admin/includes/misc.php' );
				
				remove_action( 'upgrader_process_complete', 'wp_update_plugins' );
				remove_action( 'upgrader_process_complete', 'wp_update_themes' );

				$upgrader = new Plugin_Upgrader( new Nc_Store_Skin() );

				if( $upgrader->install( $body->package, array( 'clear_update_cache' => false ) ) ){

					$plugin_file = $upgrader->plugin_info();

					$msg = array(
						'status' => 200,
						'url'    => admin_url( 'plugins.php?action=activate&plugin=' . urlencode( $plugin_file ) . '&_wpnonce=' . wp_create_nonce( 'activate-plugin_' . $plugin_file ) )
					);
					

				}else{
					$msg = array(
						'status' => 500,
						'msg'    => '安装失败，请稍后再试'
					);
				}

			}else{

				$msg = array(
					'status' => 500,
					'msg'    => '远程请求错误'
				);

			}

		}else{

			$msg = array(
				'status' => 500,
				'msg'    => '远程请求错误'
			);

		}

		echo json_encode( $msg );
		die();
	}
	add_action( 'wp_ajax_nc-store-install', 'nicetheme_store_install_program' );

}

