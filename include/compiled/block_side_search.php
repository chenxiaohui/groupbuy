<div class="right_t"><h2>团购搜索</h2></div>
<div class="right_m"><form action="/search.php"><div class="search_bar" onmouseout="this.className='search_bar'" onmouseover="this.className='search_bar_hover'"><input type="text" value="<?php echo isset($mydata)?$mydata:'请输入关键词搜索'; ?>" id="keywords" class="w1" name="keywords" onblur="if(this.value=='') this.value='<?php echo isset($mydata)?$mydata:'请输入关键词搜索'; ?>';" onfocus="if(this.value=='<?php echo isset($mydata)?$mydata:'请输入关键词搜索'; ?>') this.value='';"><input type="submit" value="" class="w2"></div></form></div>
<div class="right_b"></div>