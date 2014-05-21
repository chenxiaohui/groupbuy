<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="help">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_vote('feedback'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>调查反馈 列表</h2>
					<ul class="filter">
						<li><a href="feedback.php?action=question_list">调查中的问题列表</a></li>
						<li><a href="feedback.php?action=question_list&show_all=1">全部问题列表</a></li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr>
						<th width="40">ID</th>
						<th width="200">用户</th>
						<th width="100">IP</th>
						<th width="150">时间</th>
						<th width="200">操作</th>
					</tr>
					<?php if(!$feedback_list){?>
					<tr>
						<td colspan=5 align="center">无反馈</td>
					</tr>
					<?php }?>

					<?php if(is_array($feedback_list)){foreach($feedback_list AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
							<td><?php echo $one['id']; ?></td>
							<td><?php echo $one['username'] ? '<a href="../user/edit.php?id='. $one['user_id'] .'">' . $one['username'] . '</a>' : '游客'; ?></td>
							<td><?php echo $one['ip']; ?></td>
							<td><?php echo date("Y-m-d H:i:s", $one['addtime']); ?></td>
							<td class="op">
								<a href="feedback.php?action=view&id=<?php echo $one['id']; ?>">查看</a>
								<a href="javascript: if(confirm('确认删除？')) window.location.href = 'feedback.php?action=del&id=<?php echo $one['id']; ?>'">删除</a>
							</td>
						</tr>
					<?php }}?>
					<tr><td colspan="8"><?php echo $pagestring; ?></tr>
                    </table>
				</div>
			</div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
