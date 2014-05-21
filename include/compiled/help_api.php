<?php include template("header_nohover");?>
<div class="hy_box">
        <div class="hy_left">
            <div class="hy_left_a">
            <ul>
            <li class="hov">开发api</li>
            </ul>
            </div>
            <div class="hy_left_b">
            <div class="hy_left_b_a"><div class="l">开发接口</div></div>
                <div class="sect"><?php echo $page['value']; ?></div>
                <dl>
                <dt>360接口</dt>
                <dd>URL: <a href="<?php echo $INI['system']['wwwprefix']; ?>/api/360.php"><?php echo $INI['system']['wwwprefix']; ?>/api/360.php</a></dd>
                </dl>
                <dl>
                <dt>赶集接口</dt>
                <dd>URL: <a href="<?php echo $INI['system']['wwwprefix']; ?>/api/ganji.php"><?php echo $INI['system']['wwwprefix']; ?>/api/ganji.php</a></dd>
                </dl>
                                <dl>
                <dt>通用接口</dt>
                <dd>URL: <a href="<?php echo $INI['system']['wwwprefix']; ?>/api/index.php"><?php echo $INI['system']['wwwprefix']; ?>/api/index.php</a></dd>
                </dl>
                                <dl>
                <dt>通知接口</dt>
                <dd>URL: <a href="<?php echo $INI['system']['wwwprefix']; ?>/api/notice.php"><?php echo $INI['system']['wwwprefix']; ?>/api/notice.php</a></dd>
                </dl>
                                <dl>
                <dt>搜狐接口</dt>
                <dd>URL: <a href="<?php echo $INI['system']['wwwprefix']; ?>/api/sohu.php"><?php echo $INI['system']['wwwprefix']; ?>/api/sohu.php</a></dd>
                </dl>
                
  				                                <dl>
                <dt>团800接口</dt>
                <dd>URL: <a href="<?php echo $INI['system']['wwwprefix']; ?>/api/tuan800.php"><?php echo $INI['system']['wwwprefix']; ?>/api/tuan800.php</a></dd>
                </dl>
                                                <dl>
                <dt>团p接口</dt>
                <dd>URL: <a href="<?php echo $INI['system']['wwwprefix']; ?>/api/tuanp.php"><?php echo $INI['system']['wwwprefix']; ?>/api/tuanp.php</a></dd>
                </dl>
                
                                                <dl>
                <dt>UC接口</dt>
                <dd>URL: <a href="<?php echo $INI['system']['wwwprefix']; ?>/api/uc.php"><?php echo $INI['system']['wwwprefix']; ?>/api/uc.php</a></dd>
                </dl>     
                </div>    
            <div class="hy_left_c"></div>
        </div>
        <div class="hy_right">
           <?php include template("block_side_about");?>
        </div>
    </div>

<?php include template("footer");?>
