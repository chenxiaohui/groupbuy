<?php include template("header");?>
<link rel="stylesheet" type="text/css" href="/static/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" href="/static/js/page/pagination.css">
<script type="text/javascript" src="/static/js/page/jquery.pagination.js"></script>
<style type="text/css">
<!--
	.jquery-ratings-star {
  width: 24px;
  height: 24px;
  background-image: url('/static/js/ratyImg/empty-star.png');
  background-repeat: no-repeat;
  position: relative;
  float: left;
  margin-right: 2px;
}

.jquery-ratings-full {
  background-image: url('/static/js/ratyImg/full-star.png');
}
//-->
</style>
<script type="text/javascript" src="/static/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
			$(document).ready(function() {
				$(".huadong ul li:first").addClass("selected"); //为第一个SPAN添加当前效果样式
				$(".xiangqing #changtab:not(:first)").hide(); //隐藏其它的id为changtab
				$(".huadong ul li").click(function() {
					$(".huadong li").removeClass("selected"); //去掉所有SPAN的样式
					$(this).addClass("selected");
					$(".xiangqing #changtab").hide();
					$("." + $(this).attr("id")).fadeIn('slow');
				});
			
				$("#xq_l img").each(function(index,Ele) {
					$(Ele).wrap('<a href="'+$(Ele).attr("src")+'" class="fancyimg"></a>');
				});
				$(".fancyimg").fancybox({
						'overlayShow'	: true,
						'opacity'		: true,
						'transitionIn'	: 'elastic',
						'transitionOut'	: 'elastic',
						'overlayColor'	: '#000',
						'overlayOpacity': 0.1
				});
				
				$(function(){
					var comein=true;
					var initPagination = function() {
						var num_entries = <?php echo $commcount; ?>;
						$("#Pagination").pagination(num_entries, {
							num_edge_entries: 1, 
							num_display_entries: 4, 
							callback: pageselectCallback,
							items_per_page:10 ,
							prev_text:"前一页",
							next_text:"后一页"
						});
					}();

					function pageselectCallback(page_index, jq){
						if(comein)
						{
							comein=false;
							return false;
						}
						$(".ping tbody").html('<tr><td></td><td><center><img src="/static/js/page/loading.gif" alt="loading"/></center></td><td></td></tr>');
						$(".ping tbody").load("/ajax/team.php?action=comment&id=<?php echo $team['id']; ?>&page="+(page_index+1)+"&count=<?php echo $commcount; ?>");
						$body.animate({scrollTop: $('#tab2').offset().top}, 500);
						return false;
					}
				});

			});
</script> 
<div class="topnav"><?php echo getTopCityBar($teamcity);; ?></div>
<?php if($team['close_time']){?>
<div id="sysmsg-tip" class="sysmsg-tip-deal-close"><div class="sysmsg-tip-top"></div><div class="sysmsg-tip-content"><div class="deal-close"><div class="focus">抱歉，您来晚了，<br />团购已经结束啦。</div><div id="tip-deal-subscribe-body" class="body"><form id="tip-deal-subscribe-form" method="post" action="/subscribe.php" class="validator"><table><tr><td>不想错过明天的团购？立刻订阅每日最新团购信息：&nbsp;</td><td><input type="text" name="email" class="f-text" value="" require="true" datatype="email" /></td><td>&nbsp;<input class="commit" type="submit" value="订阅" /></td></tr></table></form></div></div><span id="sysmsg-tip-close" class="sysmsg-tip-close">关闭</span></div><div class="sysmsg-tip-bottom"></div></div>
<?php }?>

<?php if($order){?>
<div id="sysmsg-tip" ><div class="sysmsg-tip-top"></div><div class="sysmsg-tip-content">您已经下过订单，但还没有付款。<a href="/order/check.php?id=<?php echo $order['id']; ?>">查看订单并付款</a><span id="sysmsg-tip-close" class="sysmsg-tip-close">关闭</span></div><div class="sysmsg-tip-bottom"></div></div><div id="deal-default"> 
<?php }?>
<div class="two">
        <div class="mainbox">
            <div class="right">
			<?php include template("block_side_search");?>
			<?php include template("block_side_contact");?>
			<?php include template("block_side_others");?>
            </div>    
        </div>
        <div class="left">
        
            
            <ul>
            <li class="numrelative"><div class="tuand_num"></div></li>
            <li class="share">分享到：<a href="javascript:(function(){window.open('http://v.t.qq.com/share/share.php?title='+encodeURIComponent(document.title)+'&amp;url='+encodeURIComponent(location.href)+'&amp;appkey=&amp;site=www.jinpai365.com&amp;pic=','_blank','width=450,height=400');})()">腾迅微博</a><a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&amp;url='+encodeURIComponent(location.href)+'&amp;source=bookmark','_blank','width=450,height=400');})()" title="新浪微博分享">新浪微博</a><a href="javascript:(function(){window.open('http://t.163.com/article/user /checkLogin.do?link=http://news.163.com/&amp;source='+'适合我团购网'+ '&amp;info='+encodeURIComponent(document.title)+' '+encodeURIComponent(location.href),'_blank','width=510,height=300');})()">网易微博</a><a href="javascript:(function(){window.open('http://www.douban.com/recommend/?url='+encodeURIComponent(location.href)+'&amp;title='+encodeURIComponent(document.title)+'','_blank','width=450,height=400');})()">豆瓣</a><a href="javascript:void((function(s,d,e){if(/xiaonei\.com/.test(d.location))return;var%20f='http://share.xiaonei.com/share/buttonshare.do?link=',u=d.location,l=d.title,p=[e(u),'&amp;title=',e(l)].join('');function%20a(){if(!window.open([f,p].join(''),'xnshare',['toolbar=0,status=0,resizable=1,width=626,height=436,left=',(s.width-626)/2,',top=',(s.height-436)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent));">人人</a><a href="javascript:d=document;t=d.selection?(d.selection.type!='None'?d.selection.createRange().text:''):(d.getSelection?d.getSelection():'');void(kaixin=window.open('http://www.kaixin001.com/~repaste/repaste.php?&amp;rurl='+escape(d.location.href)+'&amp;rtitle='+escape(d.title)+'&amp;rcontent='+escape(d.title),'kaixin'));kaixin.focus();">开心网</a></li>
            <li class="con">
                <h1><?php if($team['close_time']==0){?><a class="deal-today-link" href="/team.php?id=<?php echo $team['id']; ?>"><?php echo $team['title']; ?></a><?php } else { ?><?php echo $team['title']; ?><?php }?></h1>
                <div class="detail">
                    <div class="tuand_l">
                    	<?php if(($team['state']=='soldout')){?>
                      <div class="detail_l_ab_soldout close_a"><?php echo moneyit($team['team_price']); ?></div>
                        <?php } else if($team['close_time']) { ?>
                        <div class="detail_l_ab_end close_a"><?php echo moneyit($team['team_price']); ?></div>
                        <?php } else { ?>
                        <div class="detail_l_ab_buy"><a <?php echo $team['begin_time']<time()?'href="/team/buy.php?id='.$team['id'].'"':''; ?> hidefocus="true"><?php echo moneyit($team['team_price']); ?></a></div>
                         <?php }?>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tuand_tab">
                        <tbody><tr class="tr1">
                        <td>原价</td><td>折扣</td><td>节省</td>
                        </tr>
                        <tr class="tr2">
                        <td><span class="through"><?php echo $currency; ?><?php echo moneyit($team['market_price']); ?></span></td><td><span><?php echo team_discount($team); ?>折</span></td><td><span><?php echo $currency; ?><?php echo $discount_price; ?></span></td>
                        </tr>
                        </tbody></table>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tuand_tab1">
                        <tbody><tr class="tr3">
                        <td><font><?php echo $team['now_number']; ?></font>人已购买</td>
                        </tr>
                        <tr class="tr4">
                        <td>
                        <?php if($team['close_time']==0){?>
                        <?php if($team['state']=='none'){?>
                        <span class=goon>团购进行中<br />还差 <strong><?php echo $team['min_number']-$team['now_number']; ?></strong> 人成团</span>
                        <?php } else { ?>
                        <span class="suc">团购已成功<br>可继续购买</span> 
                        <?php }?>
                        <?php } else { ?>
                        <span class=stop>团购已结束<br />感谢参与</span>
                        <?php }?>
                        </td>
                        </tr>
                        </tbody></table>
                        <?php if($team['close_time']){?>
                        
                        <?php } else { ?>
                      <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tuand_tab2" >
                        <tbody>
                        <tr>
                        <td id="d">0</td><td id="h">0</td><td id="m">0</td><td id="s">0</td>
                        </tr>
                        </tbody></table>
                        <script language="JavaScript">
function _fresh()
                        {
							var date= '<?php echo date('Y/m/d', $team['end_time']); ?>';							
	                        var endtime=new Date(date);							
	                        var nowtime = new Date();
	                        var leftsecond=parseInt((endtime.getTime()-nowtime.getTime())/1000);
	                        if(leftsecond<0){leftsecond=0;}
	                        __d=parseInt(leftsecond/3600/24);
	                        __h=parseInt((leftsecond/3600)%24);
	                        __m=parseInt((leftsecond/60)%60);
	                        __s=parseInt(leftsecond%60);
	                        document.getElementById("d").innerHTML=__d;
	                        document.getElementById("h").innerHTML=__h;
	                        document.getElementById("m").innerHTML=__m;
	                        document.getElementById("s").innerHTML=__s;
                        }
                        _fresh()
                        setInterval(_fresh,1000);
						</script>
                        <?php }?>
                    </div>
                    <div class="tuand_r">
                      <div class="img" id="team_images" >
					<?php if($team['image1']||$team['image2']){?>
						<div class="mid">
							<ul>
								<li class="first"><a href="<?php echo team_image($team['image']); ?>" class="fancyimg"><img src="<?php echo team_image($team['image']); ?>"/></a></li>
							<?php if($team['image1']){?>
								<li><a href="<?php echo team_image($team['image']); ?>" class="fancyimg"><img src="<?php echo team_image($team['image1']); ?>"/></a></li>
							<?php }?>
							<?php if($team['image2']){?>
								<li><a href="<?php echo team_image($team['image']); ?>" class="fancyimg"><img src="<?php echo team_image($team['image2']); ?>"/></a></li>
							<?php }?>
							</ul>
						  <div id="img_list">
								<a ref="1" class="active">1</a>
							<?php $imageindex=1;; ?>
							<?php if($team['image1']){?>
								<a ref="<?php echo ++$imageindex; ?>" ><?php echo $imageindex; ?></a>
							<?php }?>
							<?php if($team['image2']){?>
								<a ref="<?php echo ++$imageindex; ?>" ><?php echo $imageindex; ?></a>
							<?php }?>
							 
						</div>
						<?php } else { ?>
							<a href="<?php echo team_image($team['image']); ?>" class="fancyimg"><img src="<?php echo team_image($team['image']); ?>" width="440" height="280" /></a>
						<?php }?>
					
                        </div>
                        <div class="liangdian"></div>
                        <div class="liangdian_con">
                        <?php if(strip_tags($team['summary'])!=$team['summary']){?><?php echo $team['summary']; ?><?php } else { ?><?php echo nl2br(strip_tags($team['summary'])); ?><?php }?>
                        </div>
                    </div>
                </div> 
                <div class="clearboth"></div>          
            </li>
            <li class="huadong">
		<ul><li  id="tab1">产品介绍</li><li id="tab2">评价详情（<em><?php echo $commcount; ?></em>）</li></ul></li>
            <li class="xiangqing">
            <div id="xq_l">
            	<div class="tab1" id="changtab">
            	<div class="xqbg"><div class="xqbg_l1"></div><div class="xqbg_m1">价格详情和付款方式</div><div class="xqbg_r1"></div></div>
                <table cellpadding="0" cellspacing="0" border="0" class="jiage">
                
				<!--价格-->
				<?php if(!empty($team_price )){?>
				<tr><th class="pading">价格有效期</th><th class="ce"><?php if($team['tuanlei']){?>团类<?php }?></th><th class="ce">住宿</th><th class="ce">成人价</th><th class="ce">儿童价</th><th class="ce">点评返金币</th><th class="ce">最高使用金币</th><th>&nbsp;</th></tr>
				<?php if(is_array($team_price)){foreach($team_price AS $key=>$value) { ?>
                <tr><td class="pading">至 <?php echo date('n月j日',$value['end_time']); ?></td><td  class="ce"><?php if($team['tuanlei']){?><?php echo $value['team_lang']; ?><?php }?></td><td  class="ce"><?php echo $value['hotellevel']; ?></td><td class="jg ce"><?php echo $value['adult_price']; ?></td><td class="jg ce"><?php echo $value['child_price']; ?></td><td class="ce"><?php echo $team['credit']; ?></td><td class="ce"><?php echo $team['goldcoin']; ?></td><td><a class="n" <?php echo $team['begin_time']<time()?'href="/team/buy.php?id='.$team['id'].'"':''; ?> hidefocus="true"></a></td></tr>
                <?php }}?>
				<?php }?>

                <!--以下两种情况或者都不出现或者出现其中之一-->
				<?php if(!empty($team['telbook'])){?>
                <tr><td colspan="7" class="te pading-tlb ">本产品 支持 【电话预订座位·团款直接付给导游】，预定电话：<?php echo $team['telbook']; ?><br />备注：此预订方式，不享受点评返金币，请注意！</td><td class="te"><a href="/team/telbook.php?id=<?php echo $team['id']; ?>" class="t"></a></td></tr>
				<?php }?>
				<?php if(intval($team['goldbook'])!=0){?>
                <tr><td colspan="7" class="te pading-tlb ">本产品 支持 【每位成人<?php echo $team['goldbook']; ?>元预定金·余款参团时付给导游】</td><td class="te"><a href="/team/bookgold.php?id=<?php echo $team['id']; ?>" class="t"></a></td></tr>
				<?php }?>
				<!--价格-->

				</table>
                <div class="xqbg"><div class="xqbg_l1"></div><div class="xqbg_m1">特别提示</div><div class="xqbg_r1"></div></div>
                <?php if(trim(strip_tags($team['notice']))){?>
				<?php echo $team['notice']; ?>
				<?php }?>
                <div class="xqbg"><div class="xqbg_l1"></div><div class="xqbg_m1">本单详情</div><div class="xqbg_r1"></div></div>
                <?php if(trim(strip_tags($team['detail']))){?>
                <?php echo $team['detail']; ?>
                <?php }?>
                <div class="xqbg"><div class="xqbg_l1"></div><div class="xqbg_m1">以下问题，可能是您关心的</div><div class="xqbg_r1"></div></div>
                <div class="xq_qalist">     
            
                    <?php echo userask($asks); ?>
                                       
                     <div class="iwantqa"></div>
                     <?php if(is_login()){?>
					 <script type="text/JavaScript">
					function textCounter(field,counter,maxlimit,linecounter) {
						// text width//
						var charcnt = field.value.length;        
						// trim the extra text
						if (charcnt > maxlimit) { 
							field.value = field.value.substring(0, maxlimit);
						}
						else { 
						// progress bar percentage
						var percentage = parseInt(maxlimit - charcnt) ;
						document.getElementById(counter).innerHTML="还可以输入:<font> "+percentage+"</font>字";
						}
					}
					</script>
				<form id="consult-add-form" method="post" action="/ajax/team.php?action=ask&id=<?php echo $team['id']; ?>">
				<input type="hidden" id="parent_id" value="<?php echo $parent_id; ?>"/>
                     <div class="textarea"><textarea style="color:#666666;font-size:12px;height:76px;width:510px;" onkeyup="textCounter(this,'inf',200)" onkeydown="textCounter(this,'inf',200)" onfocus="if(this.value=='请发表您的疑问和建议，谢谢！(请勿违反相关法律)'){this.value='';this.style.color='#333';};textCounter(this,'inf',200)" onblur="if(this.value==''){this.value='请发表您的疑问和建议，谢谢！(请勿违反相关法律)';this.style.color='#999';}" cols="20" rows="2" name="content" id="consult-content">请发表您的疑问和建议，谢谢！(请勿违反相关法律)</textarea></div>
					 <input type="hidden" name="team_id" value="<?php echo $team['id']; ?>" />
						<input type="hidden" name="type" value="ask" />
					
                     <div class="qa_fabu"><div class="sub_up1" name="commit" ></div>温馨提示：请<a href="/account/myask.php" target="_blank">点击这里</a>查看您的问题。<span id="inf"></span><script>textCounter(document.getElementById("consult-content"),"inf",200)</script></div></form>
					 <div id="consult-add-succ" style="display:none"><p>您的问题已成功提交，客服MM很快就会回复的，稍等一会儿<a href="/account/myask.php" target="_blank">点击这里</a>看吧。</p><p><a href="#">返回顶部</a>，或<a id="consult-add-more" href="javascript:void(0);">还有其他问题？</a></p></div>
					 <?php } else { ?>
					请先<a href="/account/login.php?r=<?php echo $currefer; ?>">登录</a>或<a href="/account/signup.php">注册</a>再提问
					<?php }?>
                     <a href="/city.php" class="other_mudi"></a>
                </div>
               
                <!--<div class="xqbg"><div class="xqbg_l1"></div><div class="xqbg_m1">热门标签</div><div class="xqbg_r1"></div></div>-->
                <!--<div class="shihewodianping"><?php echo $team['systemreview']; ?></div>-->
            </div>
             <div class="tab2" id="changtab">
            	<table class="ping">
                	<colgroup><col width="30%" /><col width="40%" /><col width="30%" /></colgroup>
                	<thead><tr><th>点评</th><th>打分</th><th  class="p_left">点评人</th></tr></thead>
                    <tbody>
					 <?php echo usercomment($teamcomments); ?>
                    </tbody>
                </table>
				<br/><center><div id="Pagination" class="pagination"></div></center>
                <div class="pre_login">
                <div class="pre_login_up"><?php if(!is_login()){?><a href="/order/index.php">登录</a> 评价我的旅行</div><?php } else { ?><a href="/order/index.php">评价我的旅行</a></div><?php }?>
                <div class="pre_login_down">温馨提示：为了保证点评的真实有效，只有真实购买的游客，才可以点评！</div>
                </div>
                
            </div>
            </div>
            <div class="xq_r"><div class="shangjiajieshao">商家介绍</div><div class="tigongshang"><h3><?php echo $partner['title']; ?></h3><a href="/partner.php?id=<?php echo $partner['id']; ?>" target="_blank">(查看详细介绍)</a>
            <div class="map"><a href="/partner.php?id=<?php echo $partner['id']; ?>" target="_blank"><IMG src="http://ditu.google.cn/maps/api/staticmap?zoom=12&size=160x180&maptype=roadmap&mobile=true&markers=<?php echo $partner['longlat']; ?>&sensor=false&language=zh_CN" /></a></div>
            <span><strong>地址：</strong><?php echo $partner['address']; ?></span>
             <span><strong>电话：</strong><?php echo $partner['phone']; ?></span>
            </div><div class="bzhjihua_a"><div class="bzhjihua_s"></div></div>			
			<?php echo getGuarantee($team['guarantee_ids']); ?>
			
			<div class="bzhjihua_c"></div>
</div>
            <div style="clear: both;"></div>           
            </li>
            </ul>
            
            
            
        </div>
        <div style="clear: both;"></div>
    </div><!-- bdw end -->

<?php include template("footer");?>
