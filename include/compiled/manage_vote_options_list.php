<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="help">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_vote('question'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>“<?php echo $question['title']; ?>”选项 列表</h2>
					<ul class="filter">
						<li>
							<a href="options.php?action=add&question_id=<?php echo $question_id; ?>">添加新选项</a>
						</li>
						<li>
							<a href="question.php">问题列表</a>
						</li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr>
						<th width="40">ID</th>
						<th width="300">名称</th>
						<th width="50">状态</th>
						<th width="50">排序</th>
						<th width="200">操作</th>
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
							<td><?php echo $one['is_show'] ? '显示' : '隐藏'; ?></td>
							<td><?php echo $one['order']; ?></td>
							<td class="op">
								<?php echo $one['is_show'] ? '<a href="options.php?action=change_show&question_id=' . $one['question_id'] . '&id='.$one['id'].'&value=0">隐藏</a>' : '<a href="options.php?action=change_show&question_id=' . $one['question_id'] . '&id='.$one['id'].'&value=1">显示</a>'; ?>
								<a href="options.php?action=edit&question_id=<?php echo $one['question_id']; ?>&id=<?php echo $one['id']; ?>">编辑</a>
								<a href="javascript: if(confirm('确认删除？')) window.location.href = 'options.php?action=del&question_id=<?php echo $one['question_id']; ?>&id=<?php echo $one['id']; ?>'">删除</a>
							</td>
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