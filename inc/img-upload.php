<?php 
/**
 * WordPress 投稿页上传图片，支持游客上传
 * 原文地址：https://www.iowen.cn/wordpress-visitors-upload-pictures
 * 一为忆
 * WebStack 导航主题
 * 
 * 弃用，已经移至ajax.php
 */

if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}

require dirname(__FILE__).'/../../../../wp-load.php';
nocache_headers();

$extArr = array("jpg", "png", "jpeg");
$file = $_FILES['files'];
if ( !empty( $file ) ) {
    $wp_upload_dir = wp_upload_dir();                                     // 获取上传目录信息
    $basename = $file['name'];
    $basesize = $file['size'];
    $baseext = pathinfo($basename, PATHINFO_EXTENSION);
    /*  使用前台 js 判断
    if (!in_array($baseext, $extArr)) { 
        echo '{"status":3,"msg":"图片类型只能是jpeg,jpg,png！"}'; 
        exit();
    }  
    if ($basesize > (1000 * 1024)) { 
        echo '{"status":3,"msg":"图片大小不能超过1M"}'; 
        exit();
    } 
    */
    $dataname = date("YmdHis_").substr(md5(time()), 0, 8) . '.' . $baseext;
    $filename = $wp_upload_dir['path'] . '/' . $dataname;
    rename( $file['tmp_name'], $filename );                               // 将上传的图片文件移动到上传目录
    $attachment = array(
        'guid'           => $wp_upload_dir['url'] . '/' . $dataname,      // 外部链接的 url
        'post_mime_type' => $file['type'],                                // 文件 mime 类型
        'post_title'     => preg_replace( '/\.[^.]+$/', '', $basename ),  // 附件标题，采用去除扩展名之后的文件名
        'post_content'   => '',                                           // 文章内容，留空
        'post_status'    => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $filename );          // 插入附件信息
    if($attach_id != 0){
        require_once( ABSPATH . 'wp-admin/includes/image.php' );          // 确保包含此文件，因为wp_generate_attachment_metadata（）依赖于此文件。
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
        wp_update_attachment_metadata( $attach_id, $attach_data );        // 生成附件的元数据，并更新数据库记录。
        // 返回消息至前端
        print_r(json_encode(array('status'=>1,'msg'=>'图片添加成功','data'=>array('id'=>$attach_id,'src'=>wp_get_attachment_url( $attach_id ),'title'=>time()))));
        exit();
    }else{
        echo '{"status":4,"msg":"图片上传失败！"}';
        exit();
    }
} 
