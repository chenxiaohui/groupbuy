<?php include template("manage_header");?>
<style type="text/css">
<!--
table{
border-top:#000 1px solid;
border-left:#000 1px solid;
}
table td{
border-bottom:#000 1px solid;
border-right:#000 1px solid;
}
//-->
</style>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_system('echoseo'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>显示seo信息</h2></div>
                <div class="sect">
					<?php echo echoseo(); ?>
				</div>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>

<div id="sidebar">
</div>

</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
