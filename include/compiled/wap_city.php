<?php include template("wap_header");?>

<?php if(is_array($cities)){foreach($cities AS $letter=>$ones) { ?>	
<p><b><?php echo $letter; ?></b></p>
<?php if(is_array($ones)){foreach($ones AS $one) { ?><p><a href="city.php?n=<?php echo $one['ename']; ?>"><?php echo $one['name']; ?></a></p><?php }}?>
<?php }}?>

<?php include template("wap_footer");?>
