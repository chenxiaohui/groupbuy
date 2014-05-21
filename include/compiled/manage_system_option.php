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
						<div class="wholetip clear"><h3>1、导航栏显示</h3></div>
						<div class="field">
                            <label>团购预告</label>
							<select name="option[navpredict]"><?php echo Utility::Option($option_yn, option_yesv('navpredict')); ?></select>
						</div>
                        <div class="field">
                            <label>品牌商户</label>
							<select name="option[navpartner]"><?php echo Utility::Option($option_yn, option_yesv('navpartner')); ?></select>
						</div>
						<div class="field">
                            <label>秒杀抢团</label>
							<select name="option[navseconds]"><?php echo Utility::Option($option_yn, option_yesv('navseconds')); ?></select>
						</div>
						<div class="field">
                            <label>热销商品</label>
							<select name="option[navgoods]"><?php echo Utility::Option($option_yn, option_yesv('navgoods')); ?></select>
                        </div>
						<div class="field">
                            <label>讨论区</label>
							<select name="option[navforum]"><?php echo Utility::Option($option_yn, option_yesv('navforum')); ?></select>
                        </div>
						<div class="wholetip clear"><h3>2、杂项设置</h3></div>
						<div class="field">
                            <label>失败团购显示</label>
							<select name="option[displayfailure]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('displayfailure')); ?></select><span class="inputtip">在往期团购中，是否显示失败的团购</span>
                        </div>
						<div class="field">
                            <label>全部答疑显示</label>
							<select name="option[teamask]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('teamask')); ?></select><span class="inputtip">本单答疑栏目中，是否显示全部团购项目答疑</span>
                        </div>
						<div class="field">
                            <label>仅余额可秒杀</label>
							<select name="option[creditseconds]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('creditseconds')); ?></select><span class="inputtip">是否，秒杀项目是否仅允许余额付款</span>
                        </div>
						<div class="field">
                            <label>开启短信订阅</label>
							<select name="option[smssubscribe]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('smssubscribe')); ?></select><span class="inputtip">是否开启短信订阅团购信息功能</span>
                        </div>
						<div class="field">
                            <label>简体繁体转换</label>
							<select name="option[trsimple]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('trsimple')); ?></select><span class="inputtip">是否显示在线简体繁体转换链接</span>
                        </div>
						<div class="field">
                            <label>用户节省钱数</label>
							<select name="option[moneysave]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('moneysave')); ?></select><span class="inputtip">在团购列表页显示共为用户节省多少钱</span>
                        </div>
						<div class="field">
                            <label>项目详情通栏</label>
							<select name="option[teamwhole]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('teamwhole')); ?></select><span class="inputtip">团购项目详情和商户信息通栏显示，不分左右两栏</span>
                        </div>
						<div class="field">
                            <label>整站混淆编号</label>
							<select name="option[encodeid]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('encodeid')); ?></select><span class="inputtip">将所有数字ID编码后显示</span>
                        </div>
						<div class="field">
                            <label>保护用户隐私</label>
							<select name="option[userprivacy]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('userprivacy')); ?></select><span class="inputtip">是否充分保护用户隐私</span>
                        </div>
						<div class="field">
                            <label>开启积分功能</label>
							<select name="option[usercredit]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('usercredit')); ?></select><span class="inputtip">是否开启积分及兑换功能</span>
                        </div>
						<div class="wholetip clear"><h3>3、分类显示</h3></div>
                        <div class="field">
                            <label>往期团购</label>
							<select name="option[cateteam]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('cateteam')); ?></select><span class="inputtip">是否项目分类显示？</span>
						</div>
                        <div class="field">
                            <label>品牌商户1</label>
							<select name="option[catepartner]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('catepartner')); ?></select><span class="inputtip">是否商户分类显示？</span>
						</div>
                        <div class="field">
                            <label>品牌商户2</label>
							<select name="option[citypartner]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('citypartner')); ?></select><span class="inputtip">是否商户按城市显示？</span>
						</div>
						<div class="field">
                            <label>秒杀抢团</label>
							<select name="option[cateseconds]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('cateseconds')); ?></select><span class="inputtip">是否项目分类显示？</span>
						</div>
						<div class="field">
                            <label>热销商品</label>
							<select name="option[categoods]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('categoods')); ?></select><span class="inputtip">是否项目分类显示？</span>
                        </div>
						<div class="wholetip clear"><h3>n、注册选项</h3></div>
						<div class="field">
                            <label>邮箱验证</label>
							<select name="option[emailverify]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('emailverify')); ?></select><span class="inputtip">用户注册时，是否必须进行邮箱验证</span>
                        </div>
						<div class="field">
                            <label>手机号码必填</label>
							<select name="option[needmobile]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('needmobile')); ?></select><span class="inputtip">用户注册时，是否必须必须输入合法的手机号码</span>
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
