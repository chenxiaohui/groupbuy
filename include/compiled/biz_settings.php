<?php include template("biz_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>商户资料</h2></div>
                <div class="sect">
                    <form id="login-user-form" method="post" action="/biz/settings.php" class="validator">
					<input type="hidden" name="id" value="<?php echo $partner['id']; ?>" />
						<div class="wholetip clear"><h3>1、登录信息</h3></div>
                        <div class="field">
                            <label>用户名</label>
                            <input type="text" size="30" name="username" id="partner-create-username" class="f-input" value="<?php echo $partner['username']; ?>" readonly/>
                        </div>
                        <div class="field password">
                            <label>新密码</label>
                            <input type="password" size="30" name="password" id="settings-password" class="f-input" />
                            <span class="hint">如果不想修改密码，请保持空白</span>
                        </div>
                        <div class="field password">
                            <label>确认新密码</label>
                            <input type="password" size="30" name="password2" id="settings-password-confirm" class="f-input" />
                        </div>

						<div class="wholetip clear"><h3>2、基本设置</h3></div>
                        <div class="field">
                            <label>商户名称</label>
                            <input type="text" size="30" name="title" id="partner-create-title" class="f-input" value="<?php echo $partner['title']; ?>" datatype="require" require="ture"/>
                        </div>
                        <div class="field">
                            <label>网站地址</label>
                            <input type="text" size="30" name="homepage" id="partner-create-homepage" class="f-input" value="<?php echo $partner['homepage']; ?>"/>
                        </div>
                        <div class="field">
                            <label>联系人</label>
                            <input type="text" size="30" name="contact" id="partner-create-contact" class="f-input" value="<?php echo $partner['contact']; ?>"/>
						</div>
                        <div class="field">
                            <label>商家地址</label>
                            <input type="text" size="30" name="address" id="partner-create-address" class="f-input" value="<?php echo $partner['address']; ?>" datatype="require" require="ture" />
						</div>
                        <div class="field">
                            <label>联系电话</label>
                            <input type="text" size="30" name="phone" id="partner-create-phone" class="f-input" value="<?php echo $partner['phone']; ?>" maxLength="12" datatype="require" require="ture"/>
						</div>
                        <div class="field">
                            <label>手机号码</label>
                            <input type="text" size="30" name="mobile" id="partner-create-mobile" class="f-input" value="<?php echo $partner['mobile']; ?>" maxLength="11" />
						</div>
                        <div class="field">
                            <label>位置信息</label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="location" id="partner-create-location" class="f-textarea editor"><?php echo htmlspecialchars($partner['location']); ?></textarea></div>
						</div>
                        <div class="field">
                            <label>其他信息</label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="other" id="partner-create-other" class="f-textarea editor"><?php echo htmlspecialchars($partner['other']); ?></textarea></div>
						</div>

						<div class="wholetip clear"><h3>3、银行信息</h3></div>
                        <div class="field">
                            <label>开户行</label>
                            <input type="text" size="30" name="bank_name" id="partner-create-bankname" class="f-input" value="<?php echo $partner['bank_name']; ?>" readonly />
                        </div>
                        <div class="field">
                            <label>开户名</label>
                            <input type="text" size="30" name="bank_user" id="partner-create-bankuser" class="f-input" value="<?php echo $partner['bank_user']; ?>" readonly />
                        </div>
                        <div class="field">
                            <label>银行账户</label>
                            <input type="text" size="30" name="bank_no" id="partner-create-bankno" class="f-input" value="<?php echo $partner['bank_no']; ?>" readonly />
                        </div>
                        <div class="act">
                            <input type="submit" value="编辑" name="commit" id="partner-submit" class="formbutton"/>
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

<?php include template("footer");?>
