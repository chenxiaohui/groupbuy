<?php include template("header");?>

<div class="hy_box" style="margin-top:0px" id="maillist">
	<div id="content" class="hy_left">
       
            <div class="hy_left_a"></div>
            <div class="hy_left_b welcome">
				<div class="head">
					 <h2>邮件订阅</h2>
				</div>
                <div class="sect">
				  <div class="succ">您的邮箱 <strong><?php echo $_POST['email']; ?></strong> 将会收到<strong><?php echo $city['name']; ?></strong>每天最新的团购信息。</div>
				 </div>
			</div>
		
		<div class="hy_left_c"></div>
	</div>
	<div  class="hy_right">
	<?php include template("block_side_about");?>
	</div>
</div>


<?php include template("footer");?>
