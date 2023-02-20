<?php 
include "./wp-load.php";
$url = $_GET['url'];
$a = '';
if( $a==$url ) {
	$b = "";
// echo 'true';
} else {
	$b = $url;
	$b = base64_decode($b);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="refresh" content="0.1;url=<?php echo $b; ?>">
<meta name="robots" content="noindex,follow">
<title><?php _e('加载中','i_theme') ?></title>

<script type="text/javascript">
var msg = document.title;
msg = "" + msg;pos = 0;
function scrollMSG() {
	document.title = msg.substring(pos, msg.length) + msg.substring(0, pos);
	pos++;
	if (pos >  msg.length) pos = 0
	window.setTimeout("scrollMSG()",200);
}
scrollMSG();
</script>

<style>body{overflow:hidden;background:#17607D}.container{display:flex;justify-content:center;align-items:center;height:100vh;overflow:hidden;animation-delay:1s}.sk-cube-grid {width: 60px;height: 60px;margin-top:-45px;}.sk-cube-grid .sk-cube {width: 33.33%;height: 33.33%;background-color: #fff;float: left;-webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;}.sk-cube-grid .sk-cube1 {-webkit-animation-delay: 0.2s;animation-delay: 0.2s;}.sk-cube-grid .sk-cube2 {-webkit-animation-delay: 0.3s;animation-delay: 0.3s;}.sk-cube-grid .sk-cube3 {-webkit-animation-delay: 0.4s;animation-delay: 0.4s;}.sk-cube-grid .sk-cube4 {-webkit-animation-delay: 0.1s;animation-delay: 0.1s;}.sk-cube-grid .sk-cube5 {-webkit-animation-delay: 0.2s;animation-delay: 0.2s;}.sk-cube-grid .sk-cube6 {-webkit-animation-delay: 0.3s;animation-delay: 0.3s;}.sk-cube-grid .sk-cube7 {-webkit-animation-delay: 0.0s;animation-delay: 0.0s;}.sk-cube-grid .sk-cube8 {-webkit-animation-delay: 0.1s;animation-delay: 0.1s;}.sk-cube-grid .sk-cube9 {-webkit-animation-delay: 0.2s;animation-delay: 0.2s;}@-webkit-keyframes sk-cubeGridScaleDelay {0%,70%,100% {-webkit-transform: scale3D(1, 1, 1);transform: scale3D(1, 1, 1);}35% {-webkit-transform: scale3D(0, 0, 1);transform: scale3D(0, 0, 1);}}@keyframes sk-cubeGridScaleDelay {0%,70%,100% {-webkit-transform: scale3D(1, 1, 1);transform: scale3D(1, 1, 1);}35% {-webkit-transform: scale3D(0, 0, 1);transform: scale3D(0, 0, 1);}}</style>
</head>
<body>
	<div class="container">
		<div class="sk-cube-grid">
        	<div class="sk-cube sk-cube1"></div>
        	<div class="sk-cube sk-cube2"></div>
        	<div class="sk-cube sk-cube3"></div>
        	<div class="sk-cube sk-cube4"></div>
        	<div class="sk-cube sk-cube5"></div>
        	<div class="sk-cube sk-cube6"></div>
        	<div class="sk-cube sk-cube7"></div>
        	<div class="sk-cube sk-cube8"></div>
        	<div class="sk-cube sk-cube9"></div>
      	</div>
	</div>
</body>
</html>