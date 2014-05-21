<?php include template("header");?>
<script src="/static/js/datepicker/WdatePicker.js" type="text/javascript"></script>
<div class="ty_main">
        <div class="ty_left">
        	 <form action="/team/buy.php?id=<?php echo $team['id']; ?>" method="post" class="validator" onsumbit="return false">
	<input id="deal-per-number" value="<?php echo $team['per_number']; ?>" type="hidden" />
            <div class="ty_left_sign"></div>
            <div class="ty_left_t">1.订单提交<span>2.选择支付方式</span>3.支付成功</div>
            <div class="ty_left_m">订单提交<span id="xiangou">(<?php if($team['farefree'] == -1){?>&nbsp;(本单免运费)
            <?php } else if($team['farefree']>0) { ?>&nbsp;(<span class="currency"><?php echo $team['farefree']; ?></span>件免运费)<?php }?>)</span></div>
            <input type="hidden" id="team_id" value="<?php echo $team['id']; ?>">
            <table cellspacing="0" cellpadding="0" border="0" width="100%" class="ty_left_tab" >
            <tbody>
            <tr>
            	<th width="60%" >商品名称</th>
            	<th width="10%">成人价格</th>
            	<th width="10%">儿童价格</th>
            	<th width="10%">成人数量<span style="font-size:12px;color:red; display:block"><?php if($team['per_number']==0){?>最多9999件<?php } else { ?>每单限购<?php echo $team['per_number']; ?>件<?php }?></span></th>
            	<th width="10%">儿童数量</th>
            	<th width="10%">总价</th>
            </tr>
           	<tr>
           		<td><span id="title"><?php echo $team['title']; ?></span></td>
           		<td class="jg"><span class="money"><?php echo $currency; ?></span><span id="adult_price" name="adult_price"><?php echo $team_price['adult_price']; ?></span></td>
          		<td class="jg"><span class="money"><?php echo $currency; ?></span><span id="child_price" name="child_price"><?php echo $team_price['child_price']; ?></span></td>
            	<td class="yunsuan">
                 	<input type="text" class="input-text f-input" maxlength="4" id="adult_num" name="adult_num" value="<?php echo $order['adult_num']; ?>" id="adult_num" />
            	</td>
            	<td class="yunsuan">
                 	<input type="text" class="input-text f-input" maxlength="4" id="child_num" name="child_num" value="<?php echo $order['child_num']; ?>" id="child_num" />
            	</td>
            	<td class="zj">
            		<span class="money"><?php echo $currency; ?></span>
            		<span id="deal-buy-total"><?php echo team_origin_2($team_price, $order['adult_price'],$order['child_price'], $extrabuy); ?></span>
            	</td>
            </tr>
    		
    		<input type="hidden" id ="per_number" value="<?php echo $team['per_number']; ?>"/>
    		
            <?php if($team['delivery']=='express'){?>
            <tr><td colspan="6" class="ems_bg pad">快递</td></tr>
            <?php if(is_array($express)){foreach($express AS $index=>$one) { ?>
            <tr>
            <td class="pad" colspan="4"><?php echo $one['name']; ?></td>
            <td  class="pad"><input type="radio" class="express-price" name="express_price" value="<?php echo $one['relate_data']; ?>" title="<?php echo $one['id']; ?>" <?php if(!$order['express_id'] && $index == 0 ){?>checked="checked"<?php } else if($order['express_id'] == $one['id'] ) { ?>checked="checked"<?php }?> /></td>
            <td class="pad"><span class="money"><?php echo $currency; ?></span><span><?php echo $one['relate_data']; ?></span></td>
            </tr>
            <?php }}?>
            <tr><td colspan="6" class="pad ems">
                快递费用&nbsp;&nbsp;&nbsp;<span class="money"><?php echo $currency; ?></span><span id="deal-express-total" v="<?php echo $one['relate_data']; ?>"><?php echo $one['relate_data']; ?></span>
                    	<input type="hidden" id="express-id" name="express_id" value="<?php echo $one['express_id']; ?>">               
                </td>
            </tr>
            <?php }?>
            </tbody></table>
            <div class="total-price">应付总额：<span class="money"><?php echo $currency; ?></span><strong id="deal-buy-total-t"><?php echo $order['origin']; ?></strong></div>
         
         
         <div class="heng_line"></div>
        <div class="heng"><label>联系人姓名：</label><input type="text" id="lxrxm" name="realname" value="<?php echo $order['realname']; ?>" datatype="require" require="true"></div>
        <div class="heng"><label>联系人电话：</label><input type="text" id="lxrdh" name="mobile" value="<?php echo $order['mobile']; ?>" datatype="require" require="true"></div>
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
		          
            <?php if($team['delivery']=='express'){?>
			<div class="expresstip" style="display:none"><?php echo nl2br(htmlspecialchars($team['express'])); ?></div>
			<div class="wholetip clear"><h3>快递信息</h3></div>
			<div class="field username">
				<label>收件人</label>
				<input type="text" size="30" name="realname" id="settings-realname" class="f-input" value="<?php echo $login_user['realname']; ?>" require="true" datatype="require" />
				<span class="hint">收件人请与有效证件姓名保持一致，便于收取物品</span>
			</div>
			<div class="field mobile">
				<label>手机号码</label>
				<input type="text" size="30" name="mobile" id="settings-mobile" class="number" value="<?php echo $login_user['mobile']; ?>" require="true" datatype="mobile" maxLength="11" /> <span class="inputtip">手机号码是我们联系您最重要的方式，请准确填写</span>
			</div>
				<div class="field username">
				<label>收件地址</label>
				<input type="text" size="30" name="address" id="settings-address" class="f-input" value="<?php echo $login_user['address']; ?>" require="true" datatype="require" />
				<span class="hint">为了能及时收到物品，请按照格式填写：_省_市_县（区）_</span>
			</div>
			<div class="field mobile">
				<label>邮政编码</label>
				<input type="text" size="30" name="zipcode" id="settings-mobile" class="number" value="<?php echo $login_user['zipcode']; ?>" require="true" datatype="zip" maxLength="6" />
			</div>
			<?php }?>
            
            <div class="wholetip clear"><h3>附加信息</h3></div>
			
			<?php if(is_array($team['condbuy']) && !empty($team['condbuy'][0])){?>
			<div class="field mobile">
				<label>订购选择</label>
				<?php if(is_array($team['condbuy'])){foreach($team['condbuy'] AS $index=>$one) { ?>
				<select name="condbuy[]" class="f-input" style="width:auto;"><?php echo Utility::Option(array_combine($one, $one), 'condbuy'); ?></select> 
				<?php }}?>
			</div>
			<?php }?>
			<div class="field mobile">
				<label>订单附言</label>
				<textarea name="remark" style="width:500px;height:80px;padding:2px;"><?php echo htmlspecialchars($order['remark']); ?></textarea>
			</div>
            <input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
			<div class="form-submit"><input type="button" class="btn" name="buy" id ="buysubmit"/></div>
            
            
        </form>
        </div>
        <div class="ty_right">
            <div class="baozh_t">支付保障</div>
            <div class="baozh_c">适合我团购网采用支付宝和网上银行两种方式进行支付，最大程度保证用户的交易安全</div>
        </div>
        <div class="clear"></div>
    </div>

<script>
/*window.x_init_hook_dealbuy = function(){
	X.team.dealbuy_farefree(<?php echo abs(intval($order['quantity'])); ?>);
	X.team.dealbuy_totalprice();
};*/
</script>
<?php include template("footer");?>
