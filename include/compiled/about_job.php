<?php include template("header");?>
<div id="bdw" class="bdw">

<div id="about">
	<div class="dashboard" id="dashboard">
		<ul><?php echo current_about('job'); ?></ul>
	</div>
	<div id="content" class="job">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>加入我们</h2></div>
                <div class="sect"><?php echo $page['value']; ?></div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
</div>

</div> <!-- bdw end -->

<?php include template("footer");?>
