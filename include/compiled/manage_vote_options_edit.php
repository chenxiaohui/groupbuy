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
                    <h2>“<?php echo $question['title']; ?>”添加选项</h2>
					<ul class="filter">
						<li>
							<a href="options.php?action=list&question_id=<?php echo $question_id; ?>">选项列表</a>
						</li>
						<li>
							<a href="question.php">问题列表</a>
						</li>
					</ul>
				</div>
                <div class="sect">
					<form method="post" action="?action=<?php echo $action=='add' ? 'add_submit' : 'edit_submit'; ?>">
						<div class="field">
                            <label>名称</label>
                            <input type="text" size="30" name="options[name]" class="f-input" value="<?php echo $options['name']; ?>"/>
                            <span class="inputtip">不超过60个字符</span>
                        </div>
						<div class="field">
                            <label>是否换行</label>
                            <input type="radio" name="options[is_br]" value="1" <?php if($options['is_br']){?>checked<?php }?>/>换行
                            <input type="radio" name="options[is_br]" value="0" <?php if(!$options['is_br']){?>checked<?php }?>/>不换行
                        </div>
						<div class="field">
                            <label>是否有输入框</label>
                            <input type="radio" name="options[is_input]" value="1" <?php if($options['is_input']){?>checked<?php }?>/>有
                            <input type="radio" name="options[is_input]" value="0" <?php if(!$options['is_input']){?>checked<?php }?>/>无
                        </div>
						<div class="field">
                            <label>是否显示</label>
                            <input type="radio" name="options[is_show]" value="1" <?php if($options['is_show']){?>checked<?php }?>/>显示
                            <input type="radio" name="options[is_show]" value="0" <?php if(!$options['is_show']){?>checked<?php }?>/>隐藏
                        </div>
						<div class="field">
                            <label>排序</label>
                            <input type="text" size="30" name="options[order]" class="number" value="<?php echo $options['order']; ?>"/>
                        </div>
                        <div class="act">
							<input type="hidden" name="question_id" value="<?php echo $question['id']; ?>"/>
							<input type="hidden" name="options[id]" value="<?php echo $options['id']; ?>"/>
                            <input type="submit" value="<?php if($action=='add'){?>添加<?php } else { ?>修改<?php }?>" name="commit" class="formbutton"/>
                        </div>
					</form>
				</div>
			</div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
