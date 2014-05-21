<!--小花2010-->
<?php 
$others_side_ns = abs(intval($INI['system']['sideteam']));
$others_team_id = abs(intval($team['id']));
$others_city_id = abs(intval($city['id']));
$others_now = time();
if ( abs(intval($INI['system']['sideteam'])) ) {
	$oc = array( 
			'city_id' => array($others_city_id, 0), 
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
<!--{if $others}-->
<script src="../static/js/oxmei.js"></script>

<style>

	*{margin:0;padding:0;list-style:none}

	.nvAd98{width:1000px;height:195px;background:url(../static/css/i/topad_bg.jpg) no-repeat;margin:20px auto 0;position:relative;overflow:hidden;z-index:1}

	.nvAd98 s{position:absolute;right:20px;top:16px;display:block;width:17px;height:17px;text-decoration:none;cursor:pointer;z-index:99}

	.adMore{position:absolute;right:14px;bottom:10px;}

	.adMore img{border:0}

	.ygBox98{height:120px;position:absolute;top:22px;left:30px}

	.ygBox98 .run{float:left;width:890px;overflow:hidden}

	.ygBox98 .run div{width:50000px;overflow:hidden}

	.ygBox98 .run dl{float:left;text-align:center;padding:0 10px 0 0}

	.ygBox98 .run div dl dt a img{width:286px;height:130px;border:1px solid #B5B3B2;background:#fff}

	.ygBox98 .run div dl dt a:hover img{border:1px solid #F60}

	.ygBox98 .run dd{width:290px;padding:5px 0;white-space:nowrap;overflow:hidden}

	.ygBox98 .run dd i{display:block;width:145px;height:21px;line-height:21px;background:url(../static/css/i/topad_bg.gif) no-repeat;float:right;_display:inline;font-size:12px;font-style:normal;color:#797979;padding-left:30px}

	.ygBox98 .run dd p{display:block;font-size:12px;float:left;_display:inline;padding-top:1px;color:#C00D0E;font-weight:bold;margin-left:40px;_margin-left:20px;}

	.ygBox98 .run dd i u{text-decoration:none;display:block;float:left;_display:inline;height:21px;line-height:24px}

	.ygBox98 .run dd i .su1{font:18px Verdana;color:#C00D0E;line-height:21px;padding-right:3px}

	.ygBox98 .leftbut{float:left;padding:55px 0 0 0}

	.ygBox98 .rightbut{float:left;padding:55px 0 0 0}

	.ygBox98 .leftbut img,.rightbut img{cursor:pointer}

	.yg927a{position:absolute;top:158px;right:60px;font-size:14px;font-weight:bold}

	.yg927a a{color:#00f;text-decoration:underline}

	.yg927a a:hover{text-decoration:underline}

</style>

<script type="text/javascript">function cls(){var getId = document.getElementById("nvAd98");getId.style.display="none";}</script> 

<div id="nvAd98" class="nvAd98"> <s onclick="javascript:cls();"><img src="../static/css/i/topad_x.jpg" /></s>

 <div class="ygBox98">

 <div class="leftbut"><img src="../static/css/i/topad_a.jpg" id="leftbut1"/></div>

<div class="run" id="run1"> <span id="ybdxgmsn" style="display:none"></span>

<div>

<?php if(is_array($others)){foreach($others AS $one) { ?>

<dl>
<dt><a target="_blank" href="/team.php?id=<?php echo $one['id']; ?>"><img src="<?php echo team_image($one['image'], true); ?>" alt=""></a></dt>
<dd><p id="tuan_status_376">团购进行中</p><i style="display: inline;"><u>目前已出售：</u><u tid="376" class="su1"><?php echo $one['now_number']; ?></u><u>件</u></i></dd>
</dl> 
<?php }}?>
<?php if(is_array($others)){foreach($others AS $one) { ?>

<dl>
<dt><a target="_blank" href="/team.php?id=<?php echo $one['id']; ?>"><img src="<?php echo team_image($one['image'], true); ?>" alt=""></a></dt>
<dd><p id="tuan_status_376">团购进行中</p><i style="display: inline;"><u>目前已出售：</u><u tid="376" class="su1"><?php echo $one['now_number']; ?></u><u>件</u></i></dd>
</dl> 
<?php }}?>
 
</div>

    </div>

    <div class="rightbut"><img src="../static/css/i/topad_b.jpg" id="rightbut1" /></div>

  </div>

</div>

 
<script>Effect.HtmlMove("run1","div/dl","scrollLeft",5,"rightbut1","leftbut1",6000,1);</script>
<?php }?>
<!--end-->

<!--小花2010 -->
