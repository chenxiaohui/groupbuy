<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_team($selector); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
				<?php if($selector=='failure'){?>
                    <h2>失败项目</h2>
				<?php } else if($selector=='success') { ?>
                    <h2>成功项目</h2>
				<?php } else { ?>
                    <h2>当前项目</h2>
				<?php }?>
					<ul class="filter">
						<li><?php echo !$team_type ? '全部' : '<a href="?">全部</a>'; ?></li>
						<li><?php echo $team_type=='normal' ? '团购' : '<a href="?team_type=normal">团购</a>'; ?></li>
						<li><?php echo $team_type=='seconds' ? '秒杀' : '<a href="?team_type=seconds">秒杀</a>'; ?></li>
						<li><?php echo $team_type=='goods' ? '商品' : '<a href="?team_type=goods">商品</a>'; ?></li>
					</ul>
				</div>
                <div class="sect" style="padding:0 10px;">
					<form method="get">
						<p style="margin:5px 0;">项目编号：<input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" >
						旅游类型
						<select name="tourtype" class="f-input" style="width:200px;"><?php echo Utility::Option($tourtypes, $tourtype, '------ 请选择类型------'); ?></select>
						价格范围：<input type="text" class="h-input number"  name="tpricelow" value="<?php echo $tpricelow; ?>" /> 
						- <input type="text" class="h-input number" name="tpriceup" value="<?php echo $tpriceup; ?>" />&nbsp;
						</p>
						<p style="margin:5px 0;">
						开始日期：<input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> 
						- <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" />&nbsp;
						结束日期：<input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="pbday" value="<?php echo $pbday; ?>" /> 
						- <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="peday" value="<?php echo $peday; ?>" /></p>						
						<p style="margin:5px 0;"><input type="submit" value="筛选" class="formbutton"  style="padding:1px 6px;"/></p>
					<form>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="40">ID</th><th width="400">项目名称</th><th width="80" nowrap>类别</th><th width="100">日期</th><th width="50">成交</th><th width="60" nowrap>价格</th><th width="140">操作</th></tr>
					<?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
					<?php $oldstate = $one['state']; ?>
					<?php $one['state'] = team_state($one); ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></a></td>
						<td>
							<?php echo $one['team_type']=='normal' ? '[团购]' : ''; ?>
							<?php echo $one['team_type']=='seconds' ? '[秒杀]' : ''; ?>
							<?php echo $one['team_type']=='goods' ? '[商品]' : ''; ?>
							<a class="deal-title" href="/team.php?id=<?php echo $one['id']; ?>" target="_blank"><?php echo $one['title']; ?></a>
						</td>
						<td nowrap><?php echo getBelongCities($one['city_ids']); ?></td>
						<td nowrap><?php echo date('Y-m-d',$one['begin_time']); ?><br/><?php echo date('Y-m-d',$one['end_time']); ?></td>
						<td nowrap><?php echo $one['now_number']; ?>/<?php echo $one['min_number']; ?></td>
						<td nowrap><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['team_price']); ?><br/><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['market_price']); ?></td>
						<td class="op" nowrap><a href="/ajax/manage.php?action=teamdetail&id=<?php echo $one['id']; ?>" class="ajaxlink">详情</a>｜<a href="/manage/team/edit.php?id=<?php echo $one['id']; ?>">编辑</a>｜<a href="/ajax/manage.php?action=teamremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="确定删除本项目吗？" >删除</a><?php if((in_array($one['state'],array('success','soldout')))){?>｜<a href="/manage/team/down.php?id=<?php echo $one['id']; ?>" target="_blank">下载</a><?php }?><?php if($one['delivery']=='express'){?><br /><a href="/manage/team/ajax.php?action=smsexpress&id=<?php echo $one['id']; ?>" class="ajaxlink">短信快递单号</a><?php }?><br /><a href="/manage/team/downlucky.php?id=<?php echo $one['id']; ?>" target="_blank">下载幸运编号</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="7"><?php echo $pagestring; ?></tr>
                    </table>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
