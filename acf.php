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
*/

define( 'Apollo19_DIR', dirname(__FILE__) );
define( 'Apollo19_RELATIVE_DIR', Apollo19_DIR );
define( 'Apollo19_VERSION', '3.0' );

// nc store check
if( !defined('NC_STORE_ROOT_PATH') ){

	add_action( 'admin_notices', 'pandapro_init_check' );
	function pandapro_init_check(){
		$script_url = get_template_directory_uri() . '/js/nc-store-install.js';
		$html = '<div class="notice notice-error">
			<p><b>错误：</b> Panda PRO 主题 缺少依赖插件 <code>nicetheme 积木</code> 请先安装并启用 <code>nicetheme 积木</code> 插件。<a href="javascript:;" class="install-nc-store-now">现在安装？</a></p>
		</div><script type="text/javascript" src="' . $script_url . '"></script>';
		echo $html;
	}

	if( !is_admin() ){
		wp_die('Panda PRO 主题 缺少依赖插件 <code>nicetheme 积木</code> 请先安装并启用 <a href="https://www.nicetheme.cn/jimu">nicetheme 积木</a> 插件。');
	}

} else {


	acf_add_options_sub_page(
		array(
			'page_title'      => 'Panda PRO 主题设置',
			'menu_title'      => 'Panda PRO 主题设置',
			'menu_slug'       => 'pandapro-options',
			'parent_slug'     => 'nc-modules-store',
			'capability'      => 'manage_options',
			'update_button'   => '保存',
			'updated_message' => '设置已保存！'
		)
	);


	add_filter('nc_save_json_paths', 'pandapro_acf_json_save_point');

	function pandapro_acf_json_save_point( $path ) {

	    // update path
	    $path[] = Apollo19_DIR . '/conf';

	    // return
	    return $path;

	}

	add_filter('acf/settings/load_json', 'pandapro_acf_json_load_point');

	function pandapro_acf_json_load_point( $paths ) {

	    // append path
	    $paths[] = Apollo19_DIR . '/conf';

	    // return
	    return $paths;

	}

	function pandapro_set_main_option() { 
		$field_group_json = 'group_5c4c7507f4039.json'; 
		$option_config = json_decode(file_get_contents(Apollo19_DIR . '/conf/' . $field_group_json), true); 
		$panda_option = get_all_custom_field_meta('option', $option_config);
		update_option('panda_option', $panda_option, true);
	} 
	add_action('acf/save_post', 'pandapro_set_main_option'); 

	$panda_option = get_option('panda_option');

	if (false == $panda_option) pandapro_set_main_option();
}