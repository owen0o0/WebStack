<?php 

if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}

require dirname(__FILE__).'/../../../../wp-load.php';
nocache_headers();

if( isset($_COOKIE["tougao"]) && ( time() - $_COOKIE["tougao"] ) < 120 ){
	error('{"status":2,"msg":"您投稿也太勤快了吧，先歇会儿！"}');
} 

//表单变量初始化
$sites_link = isset( $_POST['tougao_sites_link'] ) ? trim(htmlspecialchars($_POST['tougao_sites_link'], ENT_QUOTES)) : '';
$sites_sescribe = isset( $_POST['tougao_sites_sescribe'] ) ? trim(htmlspecialchars($_POST['tougao_sites_sescribe'], ENT_QUOTES)) : '';
$title = isset( $_POST['tougao_title'] ) ? trim(htmlspecialchars($_POST['tougao_title'], ENT_QUOTES)) : '';
$category = isset( $_POST['tougao_cat'] ) ? $_POST['tougao_cat'] : '0';
$sites_ico = isset( $_POST['tougao_sites_ico'] ) ? trim(htmlspecialchars($_POST['tougao_sites_ico'], ENT_QUOTES)) : '';
$wechat_qr = isset( $_POST['tougao_wechat_qr'] ) ? trim(htmlspecialchars($_POST['tougao_wechat_qr'], ENT_QUOTES)) : '';
$content = isset( $_POST['tougao_content'] ) ? trim(htmlspecialchars($_POST['tougao_content'], ENT_QUOTES)) : '';

// 表单项数据验证
if ( $category == "0" ){
	error('{"status":4,"msg":"请选择分类。"}');
}
if ( !empty(get_term_children($category, 'favorites'))){
	error('{"status":4,"msg":"不能选用父级分类目录。"}');
}
if ( empty($sites_sescribe) || mb_strlen($sites_sescribe) > 50 ) {
	error('{"status":4,"msg":"网站描叙必须填写，且长度不得超过50字。"}');
}
if ( empty($sites_link) && empty($wechat_qr) ){
	error('{"status":3,"msg":"网站链接和公众号二维码至少填一项。"}');
}
elseif ( !empty($sites_link) && !preg_match('/http(s)?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $sites_link)) {
	error('{"status":4,"msg":"网站链接必须符合URL格式。"}');
}
if ( empty($title) || mb_strlen($title) > 30 ) {
	error('{"status":4,"msg":"网站名称必须填写，且长度不得超过30字。"}');
}
//if ( empty($content) || mb_strlen($content) > 10000 || mb_strlen($content) < 6) {
//	error('{"status":4,"msg":"内容必须填写，且长度不得超过10000字，不得少于6字。"}');
//}
$tougao = array(
	'comment_status'   => 'closed',
	'ping_status'      => 'closed',
	//'post_author'      => 1,//用于投稿的用户ID
	'post_title'       => $title,
	'post_content'     => $content,
	'post_status'      => 'pending',
	'post_type'        => 'sites',
	//'tax_input'        => array( 'favorites' => array($category) ) //游客不可用
);

// 将文章插入数据库
$status = wp_insert_post( $tougao );
if ($status != 0){
	global $wpdb;
	add_post_meta($status, '_sites_sescribe', $sites_sescribe);
	add_post_meta($status, '_sites_link', $sites_link);
	add_post_meta($status, '_sites_order', '0');
	if( !empty($sites_ico))
		add_post_meta($status, '_thumbnail', $sites_ico); 
	if( !empty($wechat_qr))
		add_post_meta($status, '_wechat_qr', $wechat_qr); 
	wp_set_post_terms( $status, array($category), 'favorites'); //设置文章分类
	setcookie("tougao", time(), time()+30);
	error('{"status":1,"msg":"投稿成功！"}');
}else{
	error('{"status":4,"msg":"投稿失败！"}');
}

function error($ErrMsg) {
    echo $ErrMsg;
    exit;
} 