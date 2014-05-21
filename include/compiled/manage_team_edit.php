<?php include template("manage_header");?>
<style type="text/css">
div ul li{float:left;width:100px;list-style:none;}
</style>
<script type="text/javascript">
var editor;
$(pageInit);
function pageInit()
{
    var allPlugin={
        yellowbar:{c:'xheIcon yellowbar',t:'黄色长条',s:'ctrl+1',e:function(){
			var str=this.getSelect();
			if(str!="")
			{
			var strsel="<div class=\"xqbg_er\">";
			strsel+=str;
			strsel+="</div>"
			this.pasteHTML(strsel);
			}
        }},
		 bluebar:{c:'xheIcon bluebar',t:'蓝色长条',s:'ctrl+2',e:function(){
           var str=this.getSelect();
			if(str!="")
			{
			var strsel="<div class=\"xqbg_er2\">";
			strsel+=str;
			strsel+="</div>"
			this.pasteHTML(strsel);
			}
        }},
		oneday:{c:'xheIcon oneday',t:'某一天',s:'ctrl+3',e:function(){
           var str=this.getSelect();
			if(str!="")
			{
			var strsel="<div class=\"xqbg_th\"><span>";
			strsel+=str.substr(0,3);
			strsel+="</span>"+str.substr(3)+"</div>"
			this.pasteHTML(strsel);
			}
        }},
		yellowstar:{c:'xheIcon yellow',t:'黄五角星',s:'ctrl+4',e:function(){
           var str=this.getSelect();
			if(str!="")
			{
			var strsel="<ul class=\"tese\">";
			line=str.split("<br />");
			for(i=0;i<line.length;i++)
			{
				strsel+="<li>"+line[i]+"</li>";
			}
			strsel+="</ul>";
			this.pasteHTML(strsel);
			}
        }},
		shuzi:{c:'xheIcon shuzinum',t:'带数字的列表',s:'ctrl+5',e:function(){
			var str=this.getSelect();
			if(str!="")
			{
				var strsel="<ol class=\"baohan\">";
				line=str.split("<br />");
				for(i=0;i<line.length;i++)
				{
					strsel+="<li>"+line[i]+"</li>";
				}
				strsel+="</ol>";
				this.pasteHTML(strsel);	
			}
		}},
		addp:{c:'xheIcon pcss',t:'加p标签',s:'ctrl+6',e:function(){
			var str=this.getSelect();
			if(str!="")
			{
			var strsel="<p>";
			strsel+=str;
			strsel+="</p>"
			this.pasteHTML(strsel);
			}
		}}
    };
    
	
	editor=$('#team-create-detail').xheditor({upLinkUrl:"/upload.php",upLinkExt:"zip,rar,txt",upImgUrl:"/upload.php",upImgExt:"jpg,jpeg,gif,png",upFlashUrl:"/upload.php",upFlashExt:"swf",upMediaUrl:"/upload.php",upMediaExt:"avi",plugins:allPlugin,tools:'GStart,GEnd,Separator,BtnBr,Cut,Copy,Paste,Pastetext,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,Removeformat,Align,List,Outdent,Indent,Link,Unlink,Img,Flash,Media,Emot,Table,Source,Preview,Fullscreen,About,|,addp,yellowbar,bluebar,oneday,shuzi'});
	
	editor=$('#team-create-notice').xheditor({upLinkUrl:"/upload.php",upLinkExt:"zip,rar,txt",upImgUrl:"/upload.php",upImgExt:"jpg,jpeg,gif,png",upFlashUrl:"/upload.php",upFlashExt:"swf",upMediaUrl:"/upload.php",upMediaExt:"avi",plugins:allPlugin,tools:'GStart,GEnd,Separator,BtnBr,Cut,Copy,Paste,Pastetext,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,Removeformat,Align,List,Outdent,Indent,Link,Unlink,Img,Flash,Media,Emot,Table,Source,Preview,Fullscreen,About,|,yellowstar'});


	
}
</script>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_team('team'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
				<?php if($team['id']){?>
					<h2>编辑项目</h2>
					<ul class="filter"><?php echo current_manageteam('edit', $team['id']); ?></ul>
				<?php } else { ?>
					<h2>新建项目</h2>
				<?php }?>
				</div>
                <div class="sect">
				<form id="manage_user_form" method="post" action="/manage/team/edit.php?id=<?php echo $team['id']; ?>" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
					<div class="wholetip clear"><h3>1、基本信息</h3></div>
					<div class="field">
						<label>项目类型</label>
						<select name="team_type" class="f-input" style="width:160px;" onchange="X.team.changetype(this.options[this.options.selectedIndex].value);"><?php echo Utility::Option($option_teamtype, $team['team_type']); ?></select>
						<select name="group_id" class="f-input" style="width:160px;"><?php echo Utility::Option($groups, $team['group_id']); ?></select>
					</div>
					<div >
					<span>应该在导航栏显示的城市分类</span>
					<select name="city_id" class="f-input" style="width:160px;"><?php echo Utility::Option(Utility::OptionArray(getMainCitiesEx(), 'id','name'), $team['city_id'], '全部城市'); ?></select>
					</div>
					<div class="field">
						<label>项目城市</label>
						<br/>
						<div class="field">
						<ul>
							<li><input type="checkbox" id="city_all" name="city_ids[]" value="0" <?php if(in_array(0,$city_ids) ){?>checked<?php }?>/>全部</li>
							<?php if(is_array($allcities)){foreach($allcities AS $index=>$one) { ?>
								<?php if($one['id'] !=ALLCITY){?>
								<li>
									<input type="checkbox" class="city_checkbox" name="city_ids[]" value="<?php echo $one['id']; ?>" <?php if(in_array($one['id'],$city_ids) ){?>checked<?php }?>/><?php echo $one['name']; ?>
								</li>
								<?php }?>
							<?php }}?>
						</ul>
					</div>
					</div>
					<div class="field" id="field_limit">
						<label>限制条件</label>
						<select name="conduser" class="f-input" style="width:160px;"><?php echo Utility::Option($option_cond, $team['conduser']); ?></select>
						<select name="buyonce" class="f-input" style="width:160px;"><?php echo Utility::Option($option_buyonce, $team['buyonce']); ?></select>
					</div>
					<div class="field">
						<label>项目标题</label>
						<input type="text" size="30" name="title" id="team-create-title" class="f-input" value="<?php echo htmlspecialchars($team['title']); ?>" datatype="require" require="true" />
					</div>
					<div class="field">
						<label>市场价</label>
						<input type="text" size="10" name="market_price" id="team-create-market-price" class="number" value="<?php echo moneyit($team['market_price']); ?>" datatype="money" require="true" />
						<span><small>网站价等于价格展示里第一行的成人价格</small></span>
						<!--<input type="text" size="10" name="team_price" id="team-create-team-price" class="number" value="<?php echo moneyit($team['team_price']); ?>" datatype="double" require="true" />-->
						<label>虚拟购买</label>
						<input type="text" size="10" name="pre_number" id="team-create-pre_number" class="number" value="<?php echo moneyit($team['pre_number']); ?>" datatype="number" require="true" />
					</div>
					<div class="field">
						<label>优惠选项</label><input type="button" id = "addDiscount" align = "right" value="增加优惠选项">
						<table id ="discount">
							<tr><td>类型</td><td>价格</td><td>说明</td></tr>
							<?php $index = 0; ?>
							<?php if(is_array($discount)){foreach($discount AS $type=>$value) { ?>		
							<tr>
								<input type = "hidden" id = "discountId<?php echo $index; ?>" name = "discountId<?php echo $index; ?>" value = "<?php echo $value['discountid']; ?>"> </input>
								 <td><input type = "text" id = "discountTag<?php echo $index; ?>"  name = "discountTag<?php echo $index; ?>"  value ="<?php echo $value['discounttag']; ?>"></input></td>
								 <td><input type = "text" id = "discountPrice<?php echo $index; ?>" name = "discountPrice<?php echo $index; ?>"  value = "<?php echo $value['discountprice']; ?>"></input></td>
								 <td><input type = "text" id = "discountDesc<?php echo $index; ?>" name = "discountDesc<?php echo $index; ?>" value= "<?php echo $value['discountdesc']; ?>"></input></td>
								 <td><input type="button" value="删除" class="delDiscount" onclick="DelDiscount()" ></input></td>
							</tr>
							<?php $index++; ?>
							<?php }}?>
						</table>
						<input type="hidden" id="discountIndex" name = "discountIndex" value="<?php echo $index; ?>"></input>
					</div>

					<div class ="field">
						<label>价格展示</label><input type="button" onclick = "AddTeamPrice()" align = "right" value="增加价格展示">
						<input type="checkbox" name="tuanlei" value=1 <?php if($team['tuanlei']){?>checked<?php }?>/>是否显示团类
						<table id ="price">
							<tr><td>有效期至</td><td>团类语种</td><td>住宿等级</td><td>成人价格</td><td>儿童价格</td><td></td></tr>
							<?php $index = 0; ?>
							<?php if(is_array($teamprice)){foreach($teamprice AS $key=>$value) { ?>
							<tr>
								<input type ="hidden" id="teampriceId<?php echo $index; ?>" name="teampriceId<?php echo $index; ?>" value="<?php echo $value['id']; ?>"/>
								<td><input type="text" class="date" id="end_time<?php echo $index; ?>" name="end_time<?php echo $index; ?>" value="<?php echo date('Y-m-d', $value['end_time']); ?>" onClick="WdatePicker()"/> </td>
								<td><input type="text" id="team_lang<?php echo $index; ?>" name="team_lang<?php echo $index; ?>" value="<?php echo $value['team_lang']; ?>"/> </td>
								<td><input type="text" id="hotellevel<?php echo $index; ?>" name="hotellevel<?php echo $index; ?>" value="<?php echo $value['hotellevel']; ?>"/> </td>
								<td><input type="text" id="adult_price<?php echo $index; ?>" name="adult_price<?php echo $index; ?>" value="<?php echo $value['adult_price']; ?>"/> </td>
								<td><input type="text" id="child_price<?php echo $index; ?>" name="child_price<?php echo $index; ?>" value="<?php echo $value['child_price']; ?>"/> </td>
								<td><input type="button" id="delteamprice" onclick="DelTeamPrice()" value="删除价格"/></td>
							</tr>
							<?php $index++; ?>
							<?php }}?>
						</table>
						<input type="hidden" id="teampriceIndex" name="teampriceIndex" value="<?php echo $index; ?>"></input>
					</div>
					
					<div class="field">
					<label>电话预定座位</label>
					<input type="text" size="10" name="telbook" id="team-telbook" class="number" value="<?php echo $team['telbook']; ?>" maxLength="20" />
					如支持电话预订座位请输入电话,否则请留空
					</div>
					<div class="field">
					<label>预定金支付</label>
					<input type="text" size="10" name="goldbook" id="team-goldbook" class="number" value="<?php echo intval($team['goldbook']); ?>" maxLength="6" datatype="money" />
					如支持预定金支付请填入金额,否则请保留0
					</div>
					<div class="field">
						<label>最低数量</label>
						<input type="text" size="10" name="min_number" id="team-create-min-number" class="number" value="<?php echo intval($team['min_number']); ?>" maxLength="6" datatype="number" require="true" />
						<label>最高数量</label>
						<input type="text" size="10" name="max_number" id="team-create-max-number" class="number" value="<?php echo intval($team['max_number']); ?>" maxLength="6" datatype="number" require="true" />
						<label>每人限购</label>
						<input type="text" size="10" name="per_number" id="team-create-per-number" class="number" value="<?php echo intval($team['per_number']); ?>" maxLength="6" datatype="number" require="true" />
						<span class="hint">最低数量必须大于0，最高数量/每人限购：0 表示没最高上限 （产品数|人数 由成团条件决定）</span>
					</div>
					<div class="field">
						<label>开始时间</label>
						<input type="text" size="10" name="begin_time" id="team-create-begin-time" class="date" xd="<?php echo date('Y-m-d', $team['begin_time']); ?>" xt="<?php echo date('H:i:s', $team['begin_time']); ?>" value="<?php echo date('Y-m-d H:i:s', $team['begin_time']); ?>" maxLength="10" onClick="WdatePicker()"/>
						<label>结束时间</label>
						<input type="text" size="10" name="end_time" id="team-create-end-time" class="date" xd="<?php echo date('Y-m-d', $team['end_time']); ?>" xt="<?php echo date('H:i:s', $team['end_time']); ?>" value="<?php echo date('Y-m-d H:i:s', $team['end_time']); ?>" maxLength="10" onClick="WdatePicker()"/>
						<label><?php echo $INI['system']['couponname']; ?>有效期</label>
						<input type="text" size="10" name="expire_time" id="team-create-expire-time" class="number" value="<?php echo date('Y-m-d', $team['expire_time']); ?>" maxLength="10" onClick="WdatePicker()"/>
						<span class="hint">时间格式：hh:ii:ss (例：14:05:58)，日期格式：YYYY-MM-DD （例：2010-06-10）</span>
					</div>
					<div class="field">
						<label>本单简介</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="summary" id="team-create-summary" class="xheditor" datatype="require" require="true"><?php echo htmlspecialchars($team['summary']); ?></textarea></div>
					</div>
					<div class="field">
						<label>特别提示</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="notice" id="team-create-notice" style="width:710px;height:150px;"><?php echo $team['notice']; ?></textarea></div>
						<span class="hint">关于本单项目的有效期及使用说明</span>
					</div>
					<div class="field">
						<label>显示选项</label>
								<input type="checkbox" name="display" value=1 <?php if($team['display'] ){?>checked<?php }?>/>首页显示
								<input type="checkbox" name="excellent" value=1 <?php if($team['excellent'] ){?>checked<?php }?>/>精品
					</div>
					<div class="field">
						<label>排序</label>
						<input type="text" size="10" name="sort_order" id="team-create-sort_order" class="number" value="<?php echo $team['sort_order'] ? $team['sort_order'] : 0; ?>" datatype="number"/><span class="inputtip">请填写数字，数值大到小排序，主推团购应设置较大值</span>
					</div>
					<input type="hidden" name="guarantee" value="Y" />
					<input type="hidden" name="system" value="Y" />
					<div class="wholetip clear"><h3>2、项目信息</h3></div>
					<div class="field">
						<label>商户</label>
						<select name="partner_id" datatype="require" require="require" class="f-input" style="width:200px;"><?php echo Utility::Option($partners, $team['partner_id'], '------ 请选择商户 ------'); ?></select><span class="inputtip">商户为可选项</span>
					</div>
					<div class="field" id="field_card">
						<label>金币使用</label>
						<input type="text" size="10" name="goldcoin" id="team-create-goldcoin" class="number" value="<?php echo moneyit($team['goldcoin']); ?>" require="true" datatype="money" />
						<span class="inputtip">可使用金币最大数目</span>
					</div>
										<div class="field" id="field_card">
						<label>代金券使用</label>
						<input type="text" size="10" name="card" id="team-create-card" class="number" value="<?php echo moneyit($team['card']); ?>" require="true" datatype="money" />
						<span class="inputtip">可使用代金券最大面额</span>
					</div>
					<div class="field" id="field_card">
						<label>邀请返利</label>
						<input type="text" size="10" name="bonus" id="team-create-bonus" class="number" value="<?php echo moneyit($team['bonus']); ?>" require="true" datatype="money" />
						<span class="inputtip">邀请好友参与本单商品购买时的返利金额</span>
					</div>
					<div class="field">
						<label>商品名称</label>
						<input type="text" size="30" name="product" id="team-create-product" class="f-input" value="<?php echo $team['product']; ?>" datatype="require" require="true" />
					</div>
					<div class="field">
						<label>购买必选项</label>
						<input type="text" size="30" name="condbuy" id="team-create-condbuy" class="f-input" value="<?php echo $team['condbuy']; ?>" />
						<span class="hint">(!!!注意：只有跟价格无关的才可以用这个，如果跟价格有关请用优惠选项!!!)<br/>格式如：{黄色}{绿色}{红色}@{大号}{中号}{小号}@{男款}{女款}，分组使用@符号分隔 , 用户购买的必选项</span>
					</div>
					<div class="field">
						<label>商品图片</label>
						<input type="file" size="30" name="upload_image" id="team-create-image" class="f-input" />
						<?php if($team['image']){?><span class="hint"><?php echo team_image($team['image']); ?></span><?php }?>
					</div>
					<div class="field">
						<label>商品图片1</label>
						<input type="file" size="30" name="upload_image1" id="team-create-image1" class="f-input" />
						<?php if($team['image1']){?><span class="hint" id="team_image_1"><?php echo team_image($team['image1']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 1);">删除</a></span><?php }?>
					</div>
					<div class="field">
						<label>商品图片2</label>
						<input type="file" size="30" name="upload_image2" id="team-create-image2" class="f-input" />
						<?php if($team['image2']){?><span class="hint" id="team_image_2"><?php echo team_image($team['image2']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 2);">删除</a></span><?php }?>
					</div>
					<div class="field">
						<label>FLV视频短片</label>
						<input type="text" size="30" name="flv" id="team-create-flv" class="f-input" value="<?php echo $team['flv']; ?>" />
						<span class="hint">形式如：http://.../video.flv</span>
					</div>
					<div class="field">
						<label>本单详情</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="detail" id="team-create-detail" style="width:530px; height:900px" ><?php echo htmlspecialchars($team['detail']); ?></textarea></div>
					</div>
					<div class="field">
						<label>保障条款</label>
							<span style="width:80px;float:left;"><input type="checkbox" id="guarantee_all" name="guarantee_ids[]" value="0" <?php if(in_array(0,$guarantee_ids) ){?>checked<?php }?>/>全部</span>
							<?php if(is_array($allguarantees)){foreach($allguarantees AS $index=>$one) { ?>
								<span style="width:100px;float:left;">
									<input type="checkbox" class="guarantee_checkbox" name="guarantee_ids[]" value="<?php echo $one['id']; ?>" <?php if(in_array($one['id'],$guarantee_ids) ||in_array(0,$guarantee_ids) ){?>checked<?php }?>/><?php echo $one['name']; ?>
								</span>
							<?php }}?>
					</div>
					<div class="field" id="field_userreview">
						<label>相关问答</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="userreview" id="team-create-userreview" class="f-textarea"><?php echo htmlspecialchars($team['userreview']); ?></textarea></div>
						<span class="hint">用回车分隔，第一行写提问，第二行写回答，以此类推，一个提问一个回答</span>
					</div>
					<div class="field">
						<label><!--<?php echo $INI['system']['abbreviation']; ?>-->热门标签</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="systemreview" id="team-create-systemreview" style="width:710px;height:150px;"><?php echo $team['systemreview']; ?></textarea></div>
					</div>
					<div class="wholetip clear"><h3>3、配送信息</h3></div>
					<div class="field">
						<label>递送方式</label>
						<div style="margin-top:5px;" id="express-zone-div">
							<input type="radio" name="delivery" class="delivery" value="coupon" <?php echo $team['delivery']=='coupon'?'checked':''; ?> />&nbsp;<?php echo $INI['system']['couponname']; ?>&nbsp;
							<input type="radio" name="delivery" class="delivery" value='voucher' <?php echo $team['delivery']=='voucher'?'checked':''; ?> />&nbsp;商户券&nbsp;
							<input type="radio" name="delivery" class="delivery" value='express' <?php echo $team['delivery']=='express'?'checked':''; ?> />&nbsp;快递</div>
					</div>
					<div id="express-zone-coupon" style="display:<?php echo $team['delivery']=='coupon'?'block':'none'; ?>;">
						<div class="field">
							<label>消费返利</label>
							<input type="text" size="10" name="credit" id="team-create-credit" class="number" value="<?php echo moneyit($team['credit']); ?>" datatype="money" require="true" />
							<span class="inputtip">消费<?php echo $INI['system']['couponname']; ?>时，获得账户余额返利，单位CNY元</span>
						</div>
					</div>
					<div id="express-zone-pickup" style="display:<?php echo $team['delivery']=='pickup'?'block':'none'; ?>;">
						<div class="field">
							<label>联系电话</label>
							<input type="text" size="10" name="mobile" id="team-create-mobile" class="f-input" value="<?php echo $team['mobile']; ?>" />
						</div>
						<div class="field">
							<label>自取地址</label>
							<input type="text" size="10" name="address" id="team-create-address" class="f-input" value="<?php echo $team['address']; ?>" />
						</div>
					</div>
					<div id="express-zone-express" style="display:<?php echo $team['delivery']=='express'?'block':'none'; ?>;">
						<div class="field">
							<label>快递(<a href="/manage/category/index.php?zone=express" target="_blank">编辑</a>)</label>
							<table style="font-size:14px;width:400px;"><tbody>
								<tr>
									<td width="10%"></td>
									<td width="20%">名称</td>
									<td width=>价格<td>
								</tr>
							<?php if(is_array($express)){foreach($express AS $index=>$one) { ?>
								<tr>
									<td><input type="checkbox" name="express_relate[]" value="<?php echo $one['id']; ?>" <?php echo $one['checked']; ?> class="express_relate"  datatype="require" require="true" /></td>
									<td><?php echo $one['name']; ?></td>
									<td><input name="express_price_<?php echo $one['id']; ?>" value="<?php echo $one['relate_data']; ?>"></td>
								</tr>
							<?php }}?>
							</tbody></table>
						</div>
						<div class="field">
							<!-- <label>快递费用</label>
							<input type="text" size="10" name="fare" id="team-create-fare" class="number" value="<?php echo intval($team['fare']); ?>" maxLength="6" datatype="money" require="true" />
							 -->
							<label>免单数量</label>
							<input type="text" size="10" name="farefree" id="team-create-farefree" class="number" value="<?php echo intval($team['farefree']); ?>" maxLength="6" datatype="integer" require="true" />
							<span class="hint">免单数量：-1表示免运费, 0表示不免运费，1表示，购买1件免运费, 2表示，购买2件免运费 ,以此类推</span>
						</div>
						<div class="field">
							<label>配送说明</label>
							<div style="float:left;"><textarea cols="45" rows="5" name="express" id="team-create-express" class="f-textarea"><?php echo $team['express']; ?></textarea></div>
						</div>
					</div>
					<input type="submit" value="好了，提交" name="commit" id="leader-submit" class="formbutton" style="margin:10px 0 0 120px;"/>
				</form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
<div id="sidebar">
</div>

</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<script type="text/javascript">
window.x_init_hook_teamchangetype = function(){
	X.team.changetype("<?php echo $team['team_type']; ?>");
};
window.x_init_hook_page = function() {
	X.team.imageremovecall = function(v) {
		jQuery('#team_image_'+v).remove();
	};
	jQuery('#addDiscount').click(AddDiscount);
	jQuery('#addTeamprice').click(AddTeamprice);
    jQuery('.delDiscount').click(DelDiscount);
    jQuery('.delTeamprice').click(DelTeamprice);
	X.team.imageremove = function(id, v) {
		return !X.get(WEB_ROOT + '/ajax/misc.php?action=imageremove&id='+id+'&v='+v);
	};
};
$(function(){
	$('#city_all').click(function(){
		if($(this).attr('checked') == true){
			$('.city_checkbox').attr('checked',true);
		}else{
			$('.city_checkbox').attr('checked',false);
		}
	});
	$('.city_checkbox').click(function(){
		if($(this).attr('checked') == false){
			$('#city_all').attr('checked',false);
		}
	});
});
$(function(){
	$('#guarantee_all').click(function(){
		if($(this).attr('checked') == true){
			$('.guarantee_checkbox').attr('checked',true);
		}else{
			$('.guarantee_checkbox').attr('checked',false);
		}
	});
	$('.guarantee_checkbox').click(function(){
		if($(this).attr('checked') == false){
			$('#guarantee_all').attr('checked',false);
		}
	});
});

$(function(){
	$('#leader-submit').click(function(){
		if(teampriceIndex.value==0)
			alert("亲，未添加价格展示哦");
		else {
			manage_user_form.submit();
		}
	});
});

	
function AddDiscount() {
    var index = jQuery("#discountIndex").attr("value");
    var html ="<tr><input type='hidden' value='-1' name='discountId"+index+"'/>"+
    		"<td><input type='text' value='' name='discountTag"+index+
    		"'/></td><td><input type='text' value='' name='discountPrice"+index+
    		"'/></td><td><input type='text' value='' name='discountDesc"+index+
    		"'/></td><td><input type='button'  value='删除'  onclick='DelDiscount()'/></td></tr>";
    jQuery("#discount").append(html);
    index++;
    jQuery("#discountIndex").attr("value", index)
};
function DelDiscount() {
    var target = (event || window.event).target;
    if ( !target) target =(event || window.event).srcElement;
    var grandParent = target.parentNode.parentNode;
    grandParent.cells[0].firstChild.value = "delete";
    grandParent.style.display = "none"
};
function AddTeamPrice(){
	var index = jQuery("#teampriceIndex").attr("value");
	var html = "<tr><input type='hidden' value='-1' name ='teampriceId"+index+"'/>"
			+"<td><input class='date' type='text' onClick='WdatePicker()' class='endtime' name='end_time"+index+"'/></td>"
			+"<td><input type='text' value='中文团' name='team_lang"+index
			+"'/></td><td><input type='text' value='三星级' name='hotellevel"+index
			+"'/></td><td><input type='text' value='0' name='adult_price"+index
			+"'/></td><td><input type='text' value='0' name='child_price"+index
			+"'/></td><td><input type='button' id='delteamprice' onclick='DelTeamPrice()' value='删除价格'/></td></tr>"
    jQuery("#price").append(html);
	index++;
	jQuery('#teampriceIndex').val(index);
}
function DelTeamPrice(){
	var ev = event || window.event;
	var target = ev.target ||ev.srcElement;
	var grandParent = target.parentNode.parentNode;
	grandParent.cells[1].firstChild.value="delete";
	grandParent.style.display ="none";
}

</script>
<?php include template("manage_footer");?>
