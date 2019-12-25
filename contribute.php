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
                                    <?php edit_post_link(__('编辑','i_owen'), '<span class="edit-link">', '</span>' ); ?>
	    		                <?php endwhile; ?> 
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="panel panel-tougao">
                    <h1 class="h2">添加网站</h1>
                    <form id="tougao" class="io-tougao mb-4" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                        <div style="text-align: left; padding-top: 10px;">
                            <label for="tougao_sites_ico">网站图标:</label>
                            <input type="hidden" value="" id="tougao_sites_ico" name="tougao_sites_ico" />
                            <div class="upload_img">
                                <div class="show_ico">
                                    <img id="show_sites_ico" src="<?php echo get_template_directory_uri() . '/images/add.png' ?>" alt="网站图标">
                                </div> 
                                <input type="file" id="upload_ico" data-type="sites_ico" accept="image/*" onchange="uploadImg(this)" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-2"  > 
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-sitemap fa-fw" aria-hidden="true"></i></div>
                                <input type="text" class="form-control" value="" id="tougao_title" name="tougao_title" placeholder="网站名称 *" maxlength="30"/>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-link fa-fw" aria-hidden="true"></i></div>
                                <input type="text" class="form-control" value="" id="tougao_sites_link" name="tougao_sites_link" placeholder="网站链接"/>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-braille fa-fw" aria-hidden="true"></i></div>
                                <input type="text" class="form-control" value="" id="tougao_sites_sescribe" name="tougao_sites_sescribe"  placeholder="网站描叙 *" maxlength="50"/>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-star fa-fw" aria-hidden="true"></i></div>
                                    <?php
                                    $cat_args = array(
                                        'show_option_all'     => "选择分类 *",
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
                                <label for="tougao_wechat_qr">公众号二维码:</label>
                                <input type="hidden" value="" id="tougao_wechat_qr" name="tougao_wechat_qr" />
                                <div class="upload_img wechat">
                                    <div class="show_ico">
                                        <img id="show_wechat_qr" src="<?php echo get_template_directory_uri() . '/images/add.png' ?>" alt="网站图标">
                                    </div> 
                                    <input type="file" id="upload_ico" data-type="wechat_qr" accept="image/*" onchange="uploadImg(this)" >
                                </div>
                            </div>
                            <div class="col-sm-9 col-md-10 mt-2">
                                <label style="vertical-align:top" for="tougao_content">网站介绍:</label>
                                <textarea rows="6" cols="55" id="tougao_content" name="tougao_content"></textarea>
                            </div>
                        </div>
                        <br  >
                        <div class="form-inline">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
                                    <input type="text" name="tougao_form"  class="form-control" id="inputVeri" maxlength="4" placeholder="输入验证码">
                                    <div id="verification-text" class="input-group-addon">0000</div>
                                </div>
                            </div>
                            <button id="submit" type="submit" class="btn">提交</button>
                        </div>
                    </form> 
	    	    </div>
	    	</div>
	    </div>
    </div>
 
<?php  
$imgUpload  = get_bloginfo('template_directory') . '/inc/img-upload.php'; 
$contribute = get_bloginfo('template_directory') . '/inc/contribute-ajax.php'; 
?>
<script> 
    var verification = Math.floor(Math.random()*(9999-1000+1)+1000);
    $('#verification-text').text(verification);

    $('#tougao').submit(function() {
        if($('#inputVeri').val() != verification){
            showAlert(JSON.parse('{"status":3,"msg":"验证码错误！"}'));
            return false;
        }
		$.ajax( {
			url:      '<?php echo $contribute ?>',
            type:     'POST',
            dataType: 'json',
            data:     $(this).serialize(), 
            error: function(result) {
                showAlert(JSON.parse('{"status":3,"msg":"网络连接错误！"}'));
			},
			success: function(result) {
                if(result.status == 1){
                    verification = Math.floor(Math.random()*(9999-1000+1)+1000);
                    $('#verification-text').text(verification);
                }
                showAlert(result);
            }
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
    function uploadImg(obj) {
        upload(obj)
    }
    function upload(file) {
        var doc_id=file.getAttribute("data-type");
        if (file.files != null && file.files[0] != null) {
            if (!/\.(jpg|jpeg|png|JPG|PNG)$/.test(file.files[0].name)) {    
                showAlert(JSON.parse('{"status":3,"msg":"图片类型只能是jpeg,jpg,png！"}'));   
                return false;    
            } 
            if(file.files[0].size > (1000 * 1024)){
                showAlert(JSON.parse('{"status":3,"msg":"图片大小不能超过1M"}'));
                return false;
            }
            var formData = new FormData();
            formData.append('files', file.files[0]);
    	    $.ajax({
    	        url: '<?php echo $imgUpload ?>',
                type: 'POST',
                cache: false,
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false
            }).done(function (result) {
                //console.log('--->>>'+JSON.stringify(result));
                showAlert(result);
                if(result.status == 1){
                    document.getElementById("show_"+doc_id).src = result.data.src;
                    document.getElementById("tougao_"+doc_id).value = result.data.src;
                }
            }).fail(function (result) {
                showAlert(JSON.parse('{"status":3,"msg":"网络连接错误！"}'));
            });
        }else{
            showAlert(JSON.parse('{"status":2,"msg":"请选择文件！"}'));
            return false;
        }
    }
</script>

<?php get_footer(); ?>
<div id="alert_placeholder" style="position: fixed;bottom: 10px;right: 10px;z-index: 1000;text-align: right;text-align: -webkit-right"></div>
