<?php include template("header");?>
<div class="hr40"></div>
<div class="ccity_a"></div>
<div class="ccity_c">
<div class="ccity_con"><div class="city_nav"><a href="/all"></a></div>您现在应该是在<span><?php echo $city['name']; ?></span>？请进入<span><A href="/city.php?ename=<?php echo $city['ename']; ?>"><?php echo $city['name']; ?>>></A></span></div>
<div style="height:70px"></div>

<?php echo current_classcategory(); ?>


</div>
<div class="ccity_b"></div>
<div class="hr40"></div>
<?php include template("footer");?>
