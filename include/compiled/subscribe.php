<?php include template("header");?>
<div class="topnav"><?php echo getTopCityBar();; ?></div>
<div class="hy_box" style="margin-top:0px" id="maillist">
	<div id="content" class="hy_left">
       
           <div class="hy_left_a"></div>
            <div class="hy_left_b welcome">
				<div class="head">
					 <h2>邮件订阅</h2>
				</div>
                <div class="sect">
					<div class="lead"><h4>把<?php echo $cityname['name']; ?>每天最新的精品团购信息发到您的邮箱。</h4></div>
					<div class="enter-address">
						<p style="padding:0px">立即邮件订阅每日团购信息，不错过每一天的惊喜。</p>
						<div class="enter-address-c">
						<form id="enter-address-form" action="/subscribe.php" method="post" class="validator">
						<div class="mail">
							<label>邮件地址：</label>
							<input id="enter-address-mail" name="email" class="f-input f-mail" type="text" value="<?php echo $login_user['email']; ?>" size="20" require="true" datatype="email" />
							<span class="tip">请放心，我们和您一样讨厌垃圾邮件</span>
						</div>
						<div class="city">
							<label>&nbsp;</label>
							<select name="city_id" class="f-city"><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'), $city['id']); ?></select>
							<input id="enter-address-commit" type="submit" class="formbutton" value="订阅" />
						</div>
						</form>
					</div>
					<div class="clear"></div>
				</div>
				<br>
				<div class="lead">
				<h4>我们每天将推出数款“超低价·高品质”的旅游产品，包括但不限于旅游线路、酒店、门票。</h4>
				</div>
			</div>
		</div>
		<div class="hy_left_c"></div>
	
</div>
<div  class="hy_right">
	<?php include template("block_side_about");?>
</div>
</div>


<?php include template("footer");?>
