<?php include template("header");?>
<script type="text/javascript" src="/static/js/jquery.lazyload.js"></script>
<script type="text/javascript">
<!--
	jQuery(document).ready(function($){$("img").lazyload({effect:showeffect,failurelimit:10})});
//-->
</script>
<div class="hy_box">
<div class="hy_left">
			<div id="deal-intro" class="cf">
                <h1 style="padding-left:0;"><?php echo $partner['title']; ?></h1>
                <div class="main">
					<div class="other other-top">
						<p><b>地址</b>：<?php echo $partner['address']; ?></p>
						<p><b>电话</b>：<?php echo $partner['phone']; ?></p>
					</div>					
					<div class="other">
					<?php if($partner['guarantee'] == 'Y'){?>
					<p class="e_icon ensure"><a href="/about/promise.php" target="_blank" title="更低廉的价格，更优质的服务！消费保障计划全面推出！">团员消费保障</a></p>
					<?php }?>
					</div>
					<div class="partner_team_info">
						<p id="partner-btn">
							<span class="h-comment">
								<?php if($comments_num>0){?>
								<?php echo 100*$partner['comment_good']/$comments_num; ?>%
								<?php } else { ?>
								--%
								<?php }?>
							</span>
							<span class="partner-comment-btn">
								<a id="partner-comment-btn" href="/order/index.php?s=pay"><strong>消费点评</strong></a>
							</span>
						</p>
						<div class="partner-dianping">
							<p style="line-height:24px;">
							共 <strong><?php echo $comments_num; ?></strong> 条点评：
							</p>
							<p><img src="/static/css/i/comment-icon-A.gif" alt="" />&nbsp;<span>满意:</span><?php echo $grades['A']; ?></p>
							<p><img src="/static/css/i/comment-icon-P.gif" alt="" />&nbsp;<span>一般:</span><?php echo $grades['P']; ?></p>
							<p><img src="/static/css/i/comment-icon-F.gif" alt="" />&nbsp;<span>失望:</span><?php echo $grades['F']; ?></p>
						</div>
					</div>
				</div>
                <div class="side" style="_padding-left:5px;">
                    <div class="deal-buy-cover-img" id="team_images">					
							<!--  <img src="<?php echo team_image($partner['image']); ?>" width="480" height="270" />	-->
							<?php $ll = $partner['longlat']; ?>
							<?php if(!$ll) $ll = '23.11,113.24'; ?>
							<?php list($longi, $lati) = preg_split('/[,\s]+/',$ll,-1,PREG_SPLIT_NO_EMPTY); ?>
							<div id="map_canvas" style="width:480px; height:270px"></div> 
							<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo $INI['system']['googlemap']; ?>" type="text/javascript"></script>
							<script type="text/javascript">
							function GShowMap() {
								if (GBrowserIsCompatible()) { 
									var map = new GMap2(document.getElementById("map_canvas")); 
									var glatlng = new GLatLng(<?php echo $longi; ?>, <?php echo $lati; ?>);
									var marker = new GMarker(glatlng);
									var html = '<strong><?php echo $partner['title']; ?></strong><p><?php echo $partner['address']; ?></p>';
									var zoomControl = new GSmallZoomControl();
									map.addControl(zoomControl);
									map.addOverlay(marker);
									map.setUIToDefault();
									map.setCenter(glatlng, 12); 
									marker.openInfoWindowHtml(html);

								} 
							}
							setTimeout(GShowMap,100);
							</script>						
					</div>
					<div class="review partner-detil">
							<p><?php echo $partner['other']; ?></p>
					</div>
                </div>
            </div>
            <input type="hidden" name="partner-availablecoupons" value="<?php echo count($coupons); ?>" />
            <input type="hidden" name="partner-id" value="<?php echo $partner['id']; ?>" />
            <div id="recent-deals" class="cf" style="margin-top:15px;">
			<div class="hy_left_a">
				<ul>
				<li class="<?php echo $view == 'comment'?'hov':''; ?>"><a class="" href="/partner.php?id=<?php echo $partner['id']; ?>&view=comment#comments" id="comments">全部点评</a><span></span></li>
				<li class="<?php echo $view == 'team'?'hov':''; ?>"><a class="" href="/partner.php?id=<?php echo $partner['id']; ?>&view=team#teams" id="teams">团购项目</a><span></span></li>
				</ul>
			</div>
			<div id="partner-content" style="margin-left:0px; margin-right:0px;" page="<?php echo $focus; ?>">
				<!--团购-->
				<?php if($view=='team'){?>
				<div class="box">
					<div class="hy_left_b">
						<div class="sect" style="border-top:1px solid #fff">
							<ul class="deals-list">
							<?php if(empty($teams)){?>
							当前商家还未举行过团购活动
							<?php } else { ?>
							<?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
								<li class="<?php echo $index++%2?'alt':''; ?> <?php echo $index<=2?'first':''; ?>">
									<p class="time"><?php echo date('Y年n月j日', $one['begin_time']); ?></p>
									<h4><a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><?php echo mb_strimwidth($one['title'],0,86,'...'); ?></a></h4>
									<div class="pic">
										<div class="<?php echo $one['picclass']; ?>"></div>
										<a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><img alt="<?php echo $one['title']; ?>" original="<?php echo team_image($one['image']); ?>" src="/static/css/i/grey.gif" width="200" height="121" align="middle" /></a>
									</div>
									<div class="info"><p class="total"><strong class="count"><?php echo $one['now_number']; ?></strong>人购买</p><p class="price">原价：<strong class="old"><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['market_price']); ?></strong><br />折扣：<strong class="discount"><?php echo team_discount($one); ?>折</strong><br />现价：<strong><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['team_price']); ?></strong><br />节省：<strong><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['market_price']-$one['team_price']); ?></strong><br /></p></div>
								</li>
							<?php }}?>
							<?php }?>
							</ul>
							<div class="clear"></div>
							<div><?php echo $pagestring; ?></div>
						</div>
					</div>
					<div class="hy_left_c"></div>
				</div>				
				<!--点评-->
				<?php } else { ?>
				<div class="box">
					<div class="hy_left_b">
						<div class="sect" style="border-top:1px solid #fff">
							<div id="partner-comment-box">
							<?php if(empty($comments)){?>
							还没有用户对当前商家做出点评。
							<?php } else { ?>
							<?php if(is_array($comments)){foreach($comments AS $k=>$v) { ?>												
							<div class="partner-comment-box-avatar"><a name="comment-<?php echo $v['id']; ?>"><img src="<?php echo user_image($users[$v['user_id']]['avatar']); ?>" /></a></div>
							<div class="partner-comment-box-cont">
								<ul>
									<li class="comment-name"><a><?php echo $users[$v['user_id']]['username']; ?></a></li>
									<li class="comment-text"><?php echo $v['comment']; ?></li>
									<li class="comment-misc">
										<img src="/static/css/i/comment-icon-<?php echo $v['grade']; ?>.gif" alt="" />&nbsp;
										<?php if($v['grade'] == 'A'){?>
										 满意
										<?php } else if($v['grade'] == 'P') { ?>
										一般
										<?php } else if($v['grade'] == 'F') { ?>
										失望 
										<?php }?>
										<span class="comment-time">&nbsp;[<?php echo date('Y-m-d H:i:s',$v['create_time']); ?>]
										<?php if($manger){?>
										[<a class="ajaxlink" href="/ajax/comment.php?action=recommend&id=<?php echo $v['id']; ?>">推荐</a>]
										<?php }?>
										</span>
									</li>
								</ul>
							</div>
							<?php }}?>
							<?php }?>
							</div>							
							<div class="clear"></div>
							<div><?php echo $pagestring; ?></div>
						</div>
					</div>
					<div class="hy_left_c"></div>
				</div>	
				<?php }?>		
				<?php if(empty($coupons)){?>				
				<div id="partner-tip-bottom">
					点评功能目前只对参与过该商家产品团购的团员开放，谢谢您的支持！<br/>
					<?php if(!$login_user){?>
					您尚未登录，请先 <a href="/account/login.php">登录</a> 或 <a href="/account/signup.php">注册</a> 。
					<?php }?>
				</div>
				<?php }?>
            </div>
		</div>
    </div>
<div class="hy_right" style="margin-top:0px">
<?php include template("block_side_about");?>
</div>
</div>





<?php include template("footer");?>
