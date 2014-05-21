
	<div class="hy_right_a"></div>
	<div class="hy_right_b">
		<div class="credit">
			<h2>积分规则</h2>
			<p>用户注册：+<?php echo abs(intval($INI['credit']['register'])); ?></p>
			<p>用户登录：+<?php echo abs(intval($INI['credit']['login'])); ?></p>
			<p>参与团购：x<?php echo abs(intval($INI['credit']['buy'])) * 100; ?>%</p>
			<p>邀请好友：+<?php echo abs(intval($INI['credit']['invite'])); ?></p>
			<?php if($INI['credit']['pay']>0){?>
			<p>购买返积比例：<?php echo moneyit($INI['credit']['pay']); ?></p>
			<?php }?>
			<?php if($INI['credit']['charge']>0){?>
			<p>充值返积比例：<?php echo moneyit($INI['credit']['charge']); ?></p>
			<?php }?>
		</div>
	</div>
	<div class="hy_right_c"></div>
