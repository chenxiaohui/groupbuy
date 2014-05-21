<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_system('option'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
					<h2>选项设置</h2>
					<ul class="filter"><?php echo current_system_option($s); ?></ul>
				</div>
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>1、前台效果</h3></div>
                        <div class="field">
                            <label>首页多团</label>
							<select name="option[indexmulti]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('indexmulti')); ?></select><span class="inputtip">是否在首页主栏同时显示多个团购项目</span>
						</div>
                        <div class="field">
                            <label>多团模板</label>
							<select name="option[indexmultimeituan]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('indexmultimeituan')); ?></select><span class="inputtip">首页多团模板采用美团样式</span>
						</div>
						<div class="wholetip clear"><h3>2、验证码设置</h3></div>
						<div class="field">
                            <label>用户注册</label>
							<select name="option[verifyregister]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('verifyregister')); ?></select><span class="inputtip">用户注册时，是否需要验证码</span>
                        </div>
						<div class="field">
                            <label>讨论区发帖</label>
							<select name="option[verifytopic]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('verifytopic')); ?></select><span class="inputtip">讨论区发帖时，是否需要验证码</span>
                        </div>
						<div class="field">
                            <label>意见反馈</label>
							<select name="option[verifyfeedback]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('verifyfeedback')); ?></select><span class="inputtip">发送意见反馈时，是否需要验证码</span>
                        </div>
						<div class="act">
                            <input type="submit" value="保存" name="commit" class="formbutton" />
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
