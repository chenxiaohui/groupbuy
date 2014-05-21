<?php header('Content-Type: text/html;charset=UTF-8');; ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if(!$pagetitle||$request_uri=='index'){?>
	<title><?php echo $INI['system']['sitename']; ?> - <?php echo $INI['system']['sitetitle']; ?>|<?php echo $city['name']; ?>购物|<?php echo $city['name']; ?>团购|<?php echo $city['name']; ?>打折</title>
<?php } else { ?>
	<title><?php echo $pagetitle; ?> | <?php echo $INI['system']['sitename']; ?> - <?php echo $INI['system']['sitetitle']; ?> |<?php echo $city['name']; ?>购物|<?php echo $city['name']; ?>团购|<?php echo $city['name']; ?>打折<?php echo $INI['system']['subtitle']; ?></title>
<?php }?>
	<meta name="description" content="<?php echo $INI['system']['sitetitle']; ?>|<?php echo $city['name']; ?>购物|<?php echo $city['name']; ?>团购|<?php echo $city['name']; ?>打折" />
	<meta name="keywords" content="<?php echo $INI['system']['sitename']; ?>, <?php echo $city['name']; ?>, <?php echo $city['name']; ?><?php echo $INI['system']['sitename']; ?>，<?php echo $city['name']; ?>购物，<?php echo $city['name']; ?>团购，<?php echo $city['name']; ?>打折，团购，打折，精品消费，购物指南，消费指南" />
<style type="text/css">
body,ul,ol,form{margin:0 0;padding:0 0}
ul,ol{list-style:none}
h1,h2,h3,div,li,p{margin:0;padding:2px;font-size:medium}
h2,li,.s{border-bottom:1px solid #ccc}
h1{background:#FF8A00;}
h2{background:#EEEEEE;}
.n{border:1px solid #ffed00;background:#fffcaa}
.t,.a,.stamp,#ft{color:#999;font-size:small}
a{color:#C55400;}
img{border:0px;}
h1 a{color:#FFFFFF; text-decoration:none;}
</style>
</head>
<body>
<h1><a href="index.php"><?php echo $INI['system']['sitename']; ?>&nbsp;-&nbsp;<?php echo $city['name']; ?></a></h1>
<?php $notice = Session::Get('notice', true); ?>
<?php if($notice){?>
<p class='n'><?php echo $notice; ?></p>
<?php }?>
<?php $error = Session::Get('error', true); ?>
<?php if($error){?>
<p class='n'><?php echo $error; ?></p>
<?php }?>
