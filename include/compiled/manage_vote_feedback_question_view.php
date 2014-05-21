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
                    <h2>“<?php echo $question['title']; ?>”反馈详情</h2>
					<ul class="filter">
						<li><a href="feedback.php?action=question_list">调查中的问题列表</a></li>
						<li><a href="feedback.php?action=question_list&show_all=1">全部问题列表</a></li>
						<li><a href="feedback.php?action=list">详细反馈列表</a></li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr>
						<th width="40">ID</th>
						<th width="300">名称</th>
						<th width="100">反馈(人次)</th>
						<th width="100">状态</th>
						<th width="100">排序</th>
						<th width="50">操作</th>
					</tr>
					<?php if(!$options_list){?>
					<tr>
						<td colspan=5 align="center">无选项</td>
					</tr>
					<?php }?>
					<?php if(is_array($options_list)){foreach($options_list AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
							<td><?php echo $one['id']; ?></td>
							<td><?php echo $one['is_input'] ? '<font color="red">'.$one['name'].'</font>' : $one['name']; ?></td>
							<td><?php echo $one['feedback']; ?></td>
							<td><?php echo $one['is_show'] ? '显示' : '隐藏'; ?></td>
							<td><?php echo $one['order']; ?></td>
							<td><?php echo $one['is_input'] ? '<a href="feedback.php?action=input_list&options_id='.$one['id'].'">查看</a>' : ''; ?></td>
						</tr>
						<?php echo $one['is_br'] ? '<tr><td colspan=5>&nbsp;</td></tr>' : ''; ?>
					<?php }}?>
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
