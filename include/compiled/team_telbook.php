<?php include template("header_nohover");?>
<script src="/static/js/datepicker/WdatePicker.js" type="text/javascript"></script>
<form class="ty_main"  method="POST">
        <div class="ty_left">
        <div class="ty_left_t1">填写您的参团信息后，即刻会有客服和您联系</div>
        <div class="ty_left_m">填写预订信息<font>（我们客服会与您联系或直接拨打预订电话 <b>400-0302-100</b>）</font></div>
        <div class="heng"><label>联系人姓名：</label><input type="text" id="lxrxm" name="realname" value=<?php echo $order['realname']; ?>></input></div>
        <div class="heng"><label>联系人电话：</label><input type="text" id="lxrdh" name="mobile" value=<?php echo $order['mobile']; ?>></input></div>
        <div class="heng_line"></div>
        <div class="heng"><label>线路名称：</label><span><?php echo $team['title']; ?></span><input type="hidden" id="team_id" value="<?php echo $team['id']; ?>"></input></div>
        <div class="heng"><label>参团日期：</label>
        <input type="text" id="ctrq" class="Wdate" name="traveltime" onfocus="WdatePicker({minDate:'%y-%M-#{%d+1}'})" value=<?php echo date('Y-m-d',$order['traveltime']); ?>></div>
        <div class="heng"><label>团类语种：</label>
	        <div class="select">
		        <select id="team_lang"  name="team_lang">
		        	<?php if(is_array($pricelist)){foreach($pricelist AS $key=>$value) { ?>     	
		        	<option	value=<?php echo $value; ?> <?php echo $lang_select[$value]; ?>><?php echo $key; ?></option>
		        	<?php }}?>
				</select>
			</div>
		</div>
         <div class="heng"><label>住宿标准：</label>
	        <div class="select">
	        	<select id="hotellevel" name="hotellevel">
	        		<?php if(is_array($hotellevellist)){foreach($hotellevellist AS $key=>$value) { ?>
			        <option value=<?php echo $value; ?> <?php echo $level_select[$key]; ?>> <?php echo $key; ?></option>       
		        	<?php }}?>
				</select>
			</div>
		</div>
		 <input type="hidden" id="team_price_id" name="team_price_id" value="<?php echo $order['team_price_id']; ?>"></input>
        <div class="heng"><label>价&nbsp;&nbsp;格：</label>
	        <label class="p">成人</label><label class="p c" id="adult_price"><?php echo $team_price['adult_price']; ?>元</label>
	        <label class="p">儿童</label><label class="p c" id="child_price"><?php echo $team_price['child_price']; ?>元</label>
        </div>
        <div class="heng"><label>参团人数：</label>
        	<label class="p">成人=</label><input type="text" id="adult_num" name="adult_num" class="w" value=<?php echo $order['adult_num']; ?>>
        	<label class="p">儿童=</label><input type="text" id="child_num" name="child_num" class="w" value=<?php echo $order['child_num']; ?>></div>
        <div class="hengl"><label>备注说明：</label><textarea id="beizhu" name="remark"><?php echo $order['remark']; ?></textarea></div>
        <input type="submit" id="buysubmit" class="telbook" value=""/>
        </div>
        <div class="ty_right">
            <div class="baozh_t">支付保障</div>
            <div class="baozh_c">适合我团购网采用支付宝和网上银行两种方式进行支付，最大程度保证用户的交易安全</div>
        </div>
        <div class="clear"></div>
</form>
<?php include template("footer");?>
