<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_system('hotcities'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>热门城市</h2></div>
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>城市列表</h3></div>
                        <div class="field">
							<span class="inputtip">请用半角逗号分隔</span>
                            <input type="text" size="30" name="hotcities[city]" class="f-input" value="<?php echo $INI['hotcities']['city']; ?>" style="width:200px;" />
                        </div>
                        <div class="act">
                            <input type="submit" value="保存" name="commit" class="formbutton"/>
                        </div>
                    </form>
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
