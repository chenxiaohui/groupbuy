<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_system('sms'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>短信配置</h2></div>
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>1、基本信息</h3></div>
                        <div class="field">
                            <label>cpid</label>
                            <input type="text" size="30" name="sms[user]" class="f-input" value="<?php echo $INI['sms']['user']; ?>" style="width:200px;" />
                        </div>
                        <div class="field">
                            <label>短信密码</label>
                            <input type="password" size="30" name="sms[pass]" class="f-input" value="<?php echo $INI['sms']['pass']; ?>" style="width:200px;" /></span>
                        </div>
						                        <div class="field">
                            <label>channel</label>
                            <input type="text" size="30" name="sms[channelid]" class="f-input" value="<?php echo $INI['sms']['channelid']; ?>" style="width:200px;" />
                        </div>
                        <div class="field">
                            <label>点发频率</label>
                            <input type="text" size="30" name="sms[interval]" class="number" value="<?php echo abs(intval($INI['sms']['interval'])); ?>"/>
                            <span class="inputtip">用户联系点击短信发送的，时间间隔限制，管理员点发不受此限制，建议：60-300s</span>
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
