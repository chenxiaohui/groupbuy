<?php include template("manage_html_header");?>
<script type="text/javascript" src="/static/js/xheditor/xheditor.js"></script> 
<div class="m_top">
        <div class="m_top_up"><?php if(is_manager()){?><div class="r">你好 
            <?php echo $login_user['realname']; ?>，&raquo;&nbsp;<a href="/manage/logout.php">管理员退出</a></div><?php }?><div class="l">欢迎使用适合我团购网管理系统</div></div>
        <div class="m_top_down"><ul><?php echo current_backend('super'); ?></ul></div>
    </div>


<?php if($session_notice=Session::Get('notice',true)){?>
<div class="sysmsgw" id="sysmsg-success"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">关闭</span></div></div> 
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div class="sysmsgw" id="sysmsg-error"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">关闭</span></div></div> 
<?php }?>
