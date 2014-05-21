<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv=content-type content="text/html; charset=UTF-8" />
<?php if(!$pagetitle||$request_uri=='index'){?>
	<title>上海旅游团购、北京旅游团购、酒店门票团购【适合我旅游团购网】</title>
<?php } else { ?>
	<title><?php echo $pagetitle; ?> | <?php echo $INI['system']['sitename']; ?> - <?php echo $INI['system']['sitetitle']; ?> <?php echo $INI['system']['subtitle']; ?></title>
<?php }?>

<?php if(!$pagetitle||$request_uri=='index'){?>
 <meta name="description" content="适合我旅游团购网，是国内领先的旅游团购网站，专注于旅游产品的团购，为广大游客提供【高品质·超低价·有保障】的旅游产品。总有一团，有惊喜；总有一团，适合我！" />
<?php } else { ?>
<?php if($seo_description){?>
	<meta name="description" content="<?php echo $seo_description; ?>" />
<?php } else if($team) { ?>
	<meta name="description" content="<?php echo mb_strimwidth(strip_tags($team['title'] .', '. $team['summary'] .', '. $team['systemreview']), 0, 320); ?>" />
<?php } else { ?>
	<meta name="description" content="<?php echo $INI['system']['sitetitle']; ?>|<?php echo $city['name']; ?>购物|<?php echo $city['name']; ?>团购|<?php echo $city['name']; ?>打折" />
<?php }?>
<?php }?>
<?php if(!$pagetitle||$request_uri=='index'){?>
	<meta name="keywords" content="适合我旅游团购，上海旅游团购网，北京旅游团购，酒店门票团购，打折，精品消费，购物指南，消费指南" />
<?php } else { ?>
<?php if($seo_keyword){?>
	<meta name="keywords" content="<?php echo $seo_keyword; ?>，<?php echo $city['name']; ?>购物，<?php echo $city['name']; ?>团购，<?php echo $city['name']; ?>打折，团购，打折，精品消费，购物指南，消费指南" />
<?php } else { ?>
	<meta name="keywords" content="<?php echo $INI['system']['sitename']; ?>, <?php echo $city['name']; ?>, <?php echo $city['name']; ?><?php echo $INI['system']['sitename']; ?>，<?php echo $city['name']; ?>购物，<?php echo $city['name']; ?>团购，<?php echo $city['name']; ?>打折，团购，打折，精品消费，购物指南，消费指南" />
<?php }?>
<?php }?>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<link href="<?php echo $INI['system']['wwwprefix']; ?>/feed.php?ename=<?php echo $city['ename']; ?>" rel="alternate" title="订阅更新" type="application/rss+xml" />
	<link rel="shortcut icon" href="/static/icon/favicon.ico" />
	<link rel="stylesheet" href="/static/css/index.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript">var WEB_ROOT = '<?php echo WEB_ROOT; ?>';</script>
	<script type="text/javascript">var LOGINUID= <?php echo abs(intval($login_user_id)); ?>;</script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="/static/js/jquery.js"><\/script>');</script>
	<script src="/static/js/index.js" type="text/javascript"></script>
	<?php echo Session::Get('script',true);; ?>
</head>
<body class="<?php echo $request_uri=='index'?'bg-alt':'newbie'; ?>">
<div id="pagemasker"></div><div id="dialog"></div>
<div id="doc">
