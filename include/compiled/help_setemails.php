<?php include template("header_nohover");?>
<div class="hy_box" style="margin-top:0px">
        <div class="hy_left">
        <div class="hy_left_a"></div>
	<div class="hy_left_b">
		<div class="hy_left_b_1">&nbsp;<?php echo $mailname; ?>帮助</div>
		<div class="hy_left_b_2"></div>
		<div class="hy_left_b_3">
			<div class="hy_left_b_31">收不到邮件？请将 <strong style="font-family:Candara;"><?php echo $helpmail; ?></strong> 加入白名单<a href="<?php echo $maillink; ?>" style="text-decoration:none; color:#e66f1b">&gt;&gt;立即开始设置您的邮箱</a></div>
		</div>
		<?php if($mail=='yahoo'){?>
		<div class="hy_left_b_4">第一步：打开邮箱，点击左上角的“<strong>选项</strong>”下的“<strong>邮箱设置</strong>”</div>
		<div class="hy_left_b_5"><img src="../static/css/i/heibai/y1.png" /></div>
		<div class="hy_left_b_6">第二步：在“设置”中选择“<strong>过滤器</strong>”下的“<strong>添加过滤器</strong>”</div>
		<div class="hy_left_b_7"><img src="../static/css/i/heibai/y2.png" /></div>
		<div class="hy_left_b_8">第三步：在“新过滤器”之“<strong>发件人包含</strong>”中填写内容，并在“移至文件夹”中选择“<strong>收件箱</strong>”，在点击“<strong>添加过滤器</strong>”</div>
		<div class="hy_left_b_9"><img src="../static/css/i/heibai/y3.png" /></div>
		<?php } else if(($mail=='163')) { ?>
		<div class="hy_left_b_4">第一步：打开邮箱，点击右上角的“<strong>设置</strong>”</div>
		<div class="hy_left_b_5"><img src="../static/css/i/heibai/w1.png" /></div>
		<div class="hy_left_b_6">第二步：点击“<strong>白名单</strong>”进入</div>
		<div class="hy_left_b_7"><img src="../static/css/i/heibai/w2.png" /></div>
		<div class="hy_left_b_8">第三步：里面有个"<strong>添加白名单</strong>",点击进入在里面“<strong>输入邮箱或域名</strong>”，然后确定。</div>
		<div class="hy_left_b_9"><img src="../static/css/i/heibai/w3.png" /></div>
		<!--{elif($mail=='qq')}-->
		<div class="hy_left_b_4">第一步：打开邮箱，点击“<strong>设置</strong>”</div>
		<div class="hy_left_b_5"><img src="../static/css/i/heibai/q1.png" /></div>
		<div class="hy_left_b_6">第二步：点击“<strong>反垃圾</strong>”下方的“<strong>白名单</strong>”里的“<strong>设置域名白名单</strong>”进入</div>
		<div class="hy_left_b_7"><img src="../static/css/i/heibai/q2.png" /></div>
		<div class="hy_left_b_8">第三步：在“<strong>设置域名白名单</strong>”中填写，并点击“<strong>添加到域白名单</strong>”按钮。</div>
		<div class="hy_left_b_9"><img src="../static/css/i/heibai/q3.png" /></div>
		<?php } else if(($mail=='gmail')) { ?>
		<div class="hy_left_b_4">第一步：打开邮箱，点击右上角“<strong>设置</strong>”，在点击“<strong>显示搜索选项创建过滤器</strong>”</div>
		<div class="hy_left_b_5"><img src="../static/css/i/heibai/g1.png" /></div>
		<div class="hy_left_b_6">第二步：在“<strong>发件人</strong>”中填写内容，并点击“<strong>下一步</strong>”继续</div>
		<div class="hy_left_b_7"><img src="../static/css/i/heibai/g2.png" /></div>
		<div class="hy_left_b_8">第三步：勾下“<strong>不要将其发送至‘垃圾邮件’</strong>”，点击“<strong>创建过滤器</strong>”</div>
		<div class="hy_left_b_9"><img src="../static/css/i/heibai/g3.png" /></div>
		<div class="hy_left_b_10">第四步：过滤器创建成功</div>
		<div class="hy_left_b_11"><img src="../static/css/i/heibai/g4.png" /></div>
		<?php } else if(($mail=='hotmail')) { ?>
		<div class="hy_left_b_4">第一步：打开邮箱，点击右上角的“<strong>选项</strong>”，并在菜单中点击“<strong>更多选项</strong>”</div>
		<div class="hy_left_b_5"><img src="../static/css/i/heibai/h1.png" /></div>
		<div class="hy_left_b_6">第二步：点击“<strong>阻止垃圾邮件</strong>”下的“<strong>白名单和黑名单</strong>”</div>
		<div class="hy_left_b_7"><img src="../static/css/i/heibai/h2.png" /></div>
		<div class="hy_left_b_8">第三步：点击“<strong>白名单</strong>”</div>
		<div class="hy_left_b_9"><img src="../static/css/i/heibai/h3.png" /></div>
		<div class="hy_left_b_10">第四步：在“<strong>标记为安全的发件人区域</strong>”中填写内容，并点击“<strong>添加至列表</strong>”</div>
		<div class="hy_left_b_11"><img src="../static/css/i/heibai/h4.png" /></div>
		<?php } else if(($mail=='sina')) { ?>
		<div class="hy_left_b_4">第一步：打开邮箱，点击右上角的“<strong>设置</strong>”</div>
		<div class="hy_left_b_5"><img src="../static/css/i/heibai/x1.png" /></div>
		<div class="hy_left_b_6">第二步：点击“反垃圾”下的“<strong>设置白名单</strong>”</div>
		<div class="hy_left_b_7"><img src="../static/css/i/heibai/x2.png" /></div>
		<div class="hy_left_b_8">第三步：里面有个"<strong>白名单设置</strong>",在里面输入内容，点击“<strong>添加到白名单</strong>”</div>
		<div class="hy_left_b_9"><img src="../static/css/i/heibai/x3.png" /></div>
		<?php } else if(($mail=='sohu')) { ?>
		<div class="hy_left_b_4">第一步：打开邮箱，点击左上角的“<strong>选项</strong>”</div>
		<div class="hy_left_b_5"><img src="../static/css/i/heibai/s1.png" /></div>
		<div class="hy_left_b_6">第二步：点击反垃圾过滤功能下的“<strong>白名单</strong>”进入</div>
		<div class="hy_left_b_7"><img src="../static/css/i/heibai/s2.png" /></div>
		<div class="hy_left_b_8">第三步：在“<strong>添加邮件地址区域</strong>”中填上内容，并点击“<strong>确定</strong>”</div>
		<div class="hy_left_b_9"><img src="../static/css/i/heibai/s3.png" /></div>
		<?php } else if(($mail=='139')) { ?>
		<div class="hy_left_b_4">第一步：打开邮箱，点击左上角的“<strong>设置</strong>”</div>
		<div class="hy_left_b_5"><img src="../static/css/i/heibai/11.png" /></div>
		<div class="hy_left_b_6">第二步：点击“反垃圾/反病毒”下的“<strong>白名单设置</strong>”</div>
		<div class="hy_left_b_7"><img src="../static/css/i/heibai/12.png" /></div>
		<div class="hy_left_b_8">第三步：在“<strong>白名单</strong>”中填上内容，并点击“<strong>添加</strong>”</div>
		<div class="hy_left_b_9"><img src="../static/css/i/heibai/13.png" /></div>
		<?php } else if(($mail=='others')) { ?>
		<div class="hy_left_b_4">第一步：点击“<strong>选项</strong>”链接</div>
		<div class="hy_left_b_5">第二步：点击“<strong>白名单</strong>”链接</div>
		<div class="hy_left_b_6">第三步：把 help@shihewo.com 添加到“<strong>白名单</strong>”中，保存</div>
		<div class="hy_left_b_7"></div>	
		<?php }?>
		<div class="hy_left_b_3">
			<div class="hy_left_b_31">收不到邮件？请将 <strong style="font-family:Candara;"><?php echo $helpmail; ?></strong> 加入白名单<a href="<?php echo $maillink; ?>" style="text-decoration:none; color:#e66f1b;">&gt;&gt;立即开始设置您的邮箱</a></div>
		</div>
		<div class="hy_left_b_10">
		</div>
        
	</div><div class="hy_left_c"></div>
    </div>
    <div class="hy_right">
    <div class="hy_right_a"></div>
	<div class="hy_right_b">
		<div class="hy_right_b_1"> 
			<?php echo getEmailList($mail); ?>
			<div class="hy_right_b_11"></div>
		</div>
	</div>
    <div class="hy_right_c"></div>
    </div>
</div>
<?php include template("footer");?>
