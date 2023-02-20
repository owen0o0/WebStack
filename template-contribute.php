<?php
/*
Template Name: 投稿模板
*/

get_header(); 

$categories= get_categories(array(
  'taxonomy'     => 'favorites',
  'meta_key'     => '_term_order',
  'orderby'      => 'meta_value_num',
  'order'        => 'desc',
  'hide_empty'   => 0,
  )
); 
include( 'templates/header-nav.php' );
?>
<div class="main-content page">
    <div class="container">
	    <div class="row">
	    	<div class="col-12 mx-auto">
                <div class="panel panel-default">
                    <h1 class="h2"><?php echo get_the_title() ?></h1>
                    <div class="panel-body mt-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php while( have_posts() ): the_post(); ?>
	    			            <?php the_content();?>
                                    <?php edit_post_link(__('编辑','i_theme'), '<span class="edit-link">', '</span>' ); ?>
	    		                <?php endwhile; ?> 
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="panel panel-tougao">
                    <h1 class="h2"><?php _e('添加网站','i_theme') ?></h1>
                    <form id="tougao" class="io-tougao mb-4" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                        <div style="text-align: left; padding-top: 10px;">
                            <label for="tougao_sites_ico"><?php _e('网站图标:','i_theme') ?></label>
                            <input type="hidden" value="" id="tougao_sites_ico" name="tougao_sites_ico" />
                            <div class="upload_img">
                                <div class="show_ico">
                                    <img id="show_sites_ico" src="<?php echo get_theme_file_uri('/images/add.png') ?>" alt="<?php _e('网站图标','i_theme') ?>">
                                    <i id="remove_sites_ico" class="fa fa-times-circle remove" data-id="" data-type="sites_ico" style="display: none;"></i>
                                </div> 
                                <input type="file" id="upload_sites_ico" data-type="sites_ico" accept="image/*" onchange="uploadImg(this)" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-2"  > 
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-sitemap fa-fw" aria-hidden="true"></i></div>
                                <input type="text" class="form-control" value="" id="tougao_title" name="tougao_title" placeholder="<?php _e('网站名称','i_theme') ?> *" maxlength="30"/>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-link fa-fw" aria-hidden="true"></i></div>
                                <input type="text" class="form-control" value="" id="tougao_sites_link" name="tougao_sites_link" placeholder="<?php _e('网站链接','i_theme') ?>"/>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-braille fa-fw" aria-hidden="true"></i></div>
                                <input type="text" class="form-control" value="" id="tougao_sites_sescribe" name="tougao_sites_sescribe"  placeholder="<?php _e('网站描叙','i_theme') ?> *" maxlength="50"/>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-star fa-fw" aria-hidden="true"></i></div>
                                    <?php
                                    $cat_args = array(
                                        'show_option_all'     => __("选择分类","i_theme")." *",
                                        'hide_empty'          => 0,
                                        'id'                  => 'tougaocategorg',
                                        'taxonomy'            => 'favorites',
                                        'name'                => 'tougao_cat',
                                        'class'               => 'form-control',
                                        'show_count'          => 1,
                                        'hierarchical'        => 1,
                                    );
                                    wp_dropdown_categories($cat_args);
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-2 mt-2">
                                <label for="tougao_wechat_qr"><?php _e('公众号二维码:','i_theme') ?></label>
                                <input type="hidden" value="" id="tougao_wechat_qr" name="tougao_wechat_qr" />
                                <div class="upload_img wechat">
                                    <div class="show_ico">
                                        <img id="show_wechat_qr" src="<?php echo get_theme_file_uri('/images/add.png') ?>" alt="<?php _e('公众号二维码','i_theme') ?>">
                                        <i id="remove_wechat_qr" class="fa fa-times-circle remove" data-id="" data-type="wechat_qr" style="display: none;"></i>
                                    </div> 
                                    <input type="file" id="upload_wechat_qr" data-type="wechat_qr" accept="image/*" onchange="uploadImg(this)" >
                                </div>
                            </div>
                            <div class="col-sm-9 col-md-10 mt-2">
                                <label style="vertical-align:top" for="tougao_content"><?php _e('网站介绍:','i_theme') ?></label>
                                <textarea rows="6" cols="55" id="tougao_content" name="tougao_content"></textarea>
                            </div>
                        </div>
                        <br  >
                        <div class="form-inline">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
                                    <input type="text" name="tougao_form"  class="form-control" id="inputVeri" maxlength="4" placeholder="<?php _e('输入验证码','i_theme') ?>">
                                    <div id="verification-text" class="input-group-addon">0000</div>
                                </div>
                            </div>
                            <button id="submit" type="submit" class="btn"><?php _e('提交','i_theme') ?></button>
                        </div>
                    </form> 
	    	    </div>
	    	</div>
	    </div>
    </div>
    
<script> 
    var verification = Math.floor(Math.random()*(9999-1000+1)+1000);
    $('#verification-text').text(verification);

    $('#tougao').submit(function() {
        if($('#inputVeri').val() != verification){
            showAlert(JSON.parse('{"status":3,"msg":"<?php _e('验证码错误！','i_theme') ?>"}'));
            return false;
        }
		$.ajax({
    	    url: theme.ajaxurl,
            type:     'POST',
            dataType: 'json',
            data:     $(this).serialize() + "&action=contribute_post", 
        }).done(function (result) {
            if(result.status == 1){
                verification = Math.floor(Math.random()*(9999-1000+1)+1000);
                $('#verification-text').text(verification);
            }
            showAlert(result);
        }).fail(function (result) {
            showAlert(JSON.parse('{"status":3,"msg":"<?php _e('网络连接错误！','i_theme') ?>"}'));
        });
        return false;
    });
    function showAlert(data) {
        var alert,ico;
        switch(data.status) {
            case 1: 
                alert='success';
                ico='fa-check-circle';
               break;
            case 2: 
                alert='info';
                ico='fa-comment';
               break;
            case 3: 
                alert='warning';
                ico='fa-exclamation-circle';
               break;
            case 4: 
                alert='danger';
                ico='fa-meh-o';
               break;
            default: 
        } 
        var msg = data.msg;
        $html = $('<div class="alert-body" style="display:none;"><div class="alert alert-'+alert+'"><i class="fa '+ico+' fa-2x" style="vertical-align: middle;margin-right: 10px"></i><span style="vertical-align: middle">'+msg+'</span></div></div>');
        $('#alert_placeholder').append( $html );//prepend
        $html.show(100).delay(3000).hide(200, function(){ $(this).remove() }); 
    }
    function uploadImg(file) {
        var doc_id=file.getAttribute("data-type");
        if (file.files != null && file.files[0] != null) {
            if (!/\.(jpg|jpeg|png|JPG|PNG)$/.test(file.files[0].name)) {    
                showAlert(JSON.parse('{"status":3,"msg":"<?php _e('图片类型只能是jpeg,jpg,png！','i_theme') ?>"}'));   
                return false;    
            } 
            if(file.files[0].size > (1000 * 128)){
                showAlert(JSON.parse('{"status":3,"msg":"<?php _e('图片大小不能超过128kb','i_theme') ?>"}'));
                return false;
            }
            var formData = new FormData();
            formData.append('files', file.files[0]);
            formData.append('action','img_upload');
    	    $.ajax({
    	        url: theme.ajaxurl,
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false
            }).done(function (result) {
                //console.log('--->>>'+JSON.stringify(result));
                showAlert(result);
                if(result.status == 1){
                    $("#show_"+doc_id).attr("src", result.data.src);
                    $("#tougao_"+doc_id).val(result.data.src);
                    $("#remove_"+doc_id).data('id',result.data.id).show();
                    $(file).attr("disabled","disabled").parent().addClass('disabled');
                }
            }).fail(function (result) {
                showAlert(JSON.parse('{"status":3,"msg":"<?php _e('网络连接错误！','i_theme') ?>"}'));
            });
        }else{
            showAlert(JSON.parse('{"status":2,"msg":"<?php _e('请选择文件！','i_theme') ?>"}'));
            return false;
        }
    }
    $('.fa.remove').click(function() {
        if(!confirm('<?php _e('确定要删除图片吗?','i_theme') ?>')){
            return false;
        }
        var doc_id = $(this).data('type');
		$.ajax( {
			url: theme.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
				action: "img_remove",
				id: $(this).data("id")
			}
        }).done(function (result) {
            showAlert(result);
            if(result.status == 1){
                $("#show_"+doc_id).attr("src", theme.addico);
                $("#tougao_"+doc_id).val('');
                $("#remove_"+doc_id).data('id','').hide();
                $("#upload_"+doc_id).removeAttr("disabled").val("").parent().removeClass('disabled');
            }
        }).fail(function (result) {
            showAlert(JSON.parse('{"status":3,"msg":"<?php _e('网络连接错误！','i_theme') ?>"}'));
        });
    });
</script>

<?php get_footer(); ?>
<div id="alert_placeholder" style="position: fixed;bottom: 10px;right: 10px;z-index: 1000;text-align: right;text-align: -webkit-right"></div>
