<?php if($INI['system']['mobileurl']){?>
	<div class="right_t"><h2>手机团购</h2></div>
    <div class="right_m">
	
		<div class="mobile">
			<div class="mobile-main">
				<p class="url"><?php echo str_replace('http://','',$INI['system']['mobileurl']); ?></p>
			</div>
			<div class="mobile-tip">温馨提示：手机版本，暂时不支持充值；如果余额不足，请提前充值。<br><a href="/credit/charge.php">点此充值</a>
			</div>
		</div>
	
    </div>
	<div class="right_b"></div>

<?php }?>
