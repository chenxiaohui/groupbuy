<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_system('grabhotel'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>爬取酒店</h2></div>
                <div class="sect">
				<form action="/manage/system/Parser.php" id="form1" name="form1" method="post" target="hidden_frame" >
					<div class="act">
                            <input type="submit" value="开始">
					</div>
                 </form>
				<iframe name="hidden_frame" id="hidden_frame" style="width:100%;height:100%"></iframe>
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
