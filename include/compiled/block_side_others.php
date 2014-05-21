<?php 
$others_side_ns = abs(intval($INI['system']['sideteam']));
$others_team_id = abs(intval($team['id']));
$others_city_id = abs(intval($city['id']));
$others_now = time();
if ( abs(intval($INI['system']['sideteam'])) && !$disable_multi){
	$oc = array( 
			"city_ids like '%@$others_city_id@%'",
			'team_type' => 'normal',
			"id <> '$others_team_id'",
			"begin_time < '$others_now'",
			"end_time > '$others_now'",
			);
	$others = DB::LimitQuery('team', array(
				'condition' => $oc,
				'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
				'size' => $others_side_ns,
				));
}
; ?>
<?php if($others){?>
<script type="text/javascript" src="/static/js/jquery.lazyload.js"></script>            
<script type="text/javascript">
<!--
	jQuery(document).ready(function($){$(".others img").lazyload({effect:showeffect,failurelimit:10})});
//-->
</script>
<div class="right_t"><h2><a href="/team/current.php">今日其他团购</a></h2></div>
<div class="right_m">

<div class="tip others">
		<?php $index=0; ?>
		<?php if(is_array($others)){foreach($others AS $one) { ?>
			<h3><a href="/team.php?id=<?php echo $one['id']; ?>"><?php echo $one['title']; ?></a></h3>
			<?php if($one['image']){?><p><a href="/team.php?id=<?php echo $one['id']; ?>"><img src="http://www.shihewo.com/static/css/i/grey.gif" original="<?php echo team_image($one['image'], true); ?>" width="192" height="108" border="0" /></a></p><?php }?>
			<p class="price">团购价: <span><?php echo $currency; ?><?php echo moneyit($one['team_price']); ?></span> <br>原价: <s><?php echo $currency; ?><?php echo moneyit($one['market_price']); ?></s>  <br>折扣: <?php echo team_discount($one); ?>折</p>			
			<div class="others_btn">
				<div class="now_num">已有 <strong><?php echo $one['now_number']; ?></strong> 人购买</div>
				<a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><span>查看详情</span></a>
			</div>
			<div class="clear"></div>
		<div class="hr" ></div>
		<?php }}?>
		</div>
</div>
<div class="right_b"></div>

<?php }?>
