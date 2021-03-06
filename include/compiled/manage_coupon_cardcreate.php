<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_coupon('cardcreate'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
					<h2>新建代金券</h2>
				</div>
                <div class="sect">
                    <form id="login-user-form" method="post" class="validator">
					<input type="hidden" name="id" value="<?php echo $card['id']; ?>" />
                        <div class="field">
                            <label>商户ID</label>
                            <input type="text" size="30" name="partner_id" id="card-create-partner" class="number" value="<?php echo abs(intval($card['partner_id'])); ?>" require="true" datatype="number" /><span class="inputtip">商户ID可以在商户菜单中查询复制出来</span>
							<span class="hint">0 表示站内所有商户通用代金券</span>
                        </div>
                        <div class="field">
                            <label>代金券面额</label>
                            <input type="text" size="30" name="money" id="card-create-money" class="number" value="<?php echo $card['money']; ?>" datatype="number" require="true" /><span class="inputtip">面额单位为元CNY（人民币元）</span>
                        </div>
                        <div class="field">
                            <label>生成数量</label>
                            <input type="text" size="30" name="quantity" id="card-create-quantity" class="number" value="<?php echo abs(intval($card['quantity'])); ?>" datatype="number" require="true" /><span class="inputtip">一次最多生成1000张，可重复生成</span>
                        </div>
                        <div class="field">
                            <label>开始日期</label>
                            <input type="text" size="30" name="begin_time" id="card-create-begintine" class="number" value="<?php echo date('Y-m-d', $card['begin_time']); ?>" datatype="date" require="true" />
						</div>
                        <div class="field">
                            <label>结束日期</label>
                            <input type="text" size="30" name="end_time" id="card-create-endtime" class="number" value="<?php echo date('Y-m-d', $card['end_time']); ?>" datatype="date" require="true" />
						</div>
                        <div class="field">
                            <label>行动代号</label>
                            <input type="text" size="30" name="code" id="card-create-code" class="number" value="<?php echo $card['code']; ?>" datatype="require" require="true" /><span class="inputtip">只是一个代号，可用于对代金券，归档、汇总、查询</span>
                        </div>
                        <div class="act">
                            <input type="submit" value="编辑" name="commit" id="partner-submit" class="formbutton"/>
                        </div>
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

<?php include template("manage_footer");?>
