<?php include template("header_nohover");?>
<script src="/static/js/datepicker/WdatePicker.js" type="text/javascript"></script>
<form class="ty_main" method="POST">
        <div class="ty_left">
        <div class="ty_left_t2">余款参团时付给导游</div>
        <div class="ty_left_m">预订金支付</div>
        <input type="hidden" id="team_id" value="<?php echo $team['id']; ?>">
        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="ty_left_tab" >
            <tbody><tr>
            <th width="60%" >商品名称</th><th width="10%">预订金</th><th></th><th width="10%">成人数</th><th></th><th width="10%">总计</th>
            </tr>
           	<tr>
           		<td><span id="title"><?php echo $team['title']; ?></span></td>
           		<td class="jg"><span class="money"><?php echo $currency; ?></span><span id="book_price"><?php echo $team['goldbook']; ?></span></td>
            	<td>x</td>
            	<td class="yunsuan">
                 	<input type="text" class="input-text f-input" maxlength="4" name="adult_num" value="<?php echo $order['adult_num']; ?>" id="book_adult_num" />
            	</td>
            	<td>=</td>
            	<td class="zj"><span class="money"><?php echo $currency; ?></span><span id="book_total"><?php echo $order['adult_num']*$team['goldbook']; ?></span></td>
            </tr>            
            </tbody>
        </table>
            <div class="total-price">应付总额：<span class="money"><?php echo $currency; ?></span><strong id="pay_total"><?php echo $order['adult_num'] * $team['goldbook']; ?></strong></div>
        <div class="heng_line"></div>
        <div class="heng"><label>联系人姓名：</label><input type="text" id="lxrxm" name="realname" value="<?php echo $order['realname']; ?>"></div>
        <div class="heng"><label>联系人电话：</label><input type="text" id="lxrdh" name="mobile" value="<?php echo $order['mobile']; ?>"></div>
        <div class="heng_line"></div>
        <div class="heng"><label>参团日期：</label>
        <input type="text" id="ctrq" class="Wdate" onfocus="WdatePicker({minDate:'%y-%M-#{%d+1}'})" name="traveltime" value="<?php echo date('Y-m-d',$order['traveltime']); ?>"></div>
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
        <div class="heng">
	        <label>参团人数：</label>
	        <label class="p">成人=</label><label class="p"><span  id="book_adult_num2"><?php echo $order['adult_num']; ?></span>人</label>
	        <label class="p">儿童=</label><input type="text" id="book_child_num" class="w" name="child_num" value="<?php echo $order['child_num']; ?>"></div>
        <div class="hengl"><label>备注说明：</label><textarea id="beizhu" name="remark" ><?php echo $order['remark']; ?></textarea></div>
        <input type="submit" id="booksubmit" class="telbook" value=""/>
        </form>
        <div class="ty_right">
            <div class="baozh_t">支付保障</div>
            <div class="baozh_c">适合我团购网采用支付宝和网上银行两种方式进行支付，最大程度保证用户的交易安全</div>
        </div>
</div>
<?php include template("footer");?>