<?php include template("header");?>

<div id="bdw" class="bdw">

<div id="reset">
    <div id="content">
        <div class="box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>重设密码</h2></div>
                <div class="sect">
				<?php if($_POST){?>
				<?php } else { ?>
					<form method="post" action="/account/repass.php">
                    <div class="field email">
                        <label class="f-label" for="reset-email">Email</label>
                        <input type="text" name="email" class="f-input" id="reset-email" value="" />
                        <span class="hint">您用来登录的 Email 地址</span>
                    </div>
                    <div class="act">
                        <input type="submit" class="formbutton" value="重设密码" />
                    </div>
                    </form>
				</div>
				<?php }?>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
    <div id="sidebar">
    </div>
</div>

</div> <!-- bdw end -->
 
<?php include template("footer");?>
