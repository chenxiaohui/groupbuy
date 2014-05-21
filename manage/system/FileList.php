<?php
/* 
*   递归获取指定路径下的所有文件或匹配指定正则的文件（不包括“.”和“..”），结果以数组形式返回 
*   @param  string  $dir 
*   @param  string  [$pattern] 
*   @return array 
*/  
function list_file($dir,$pattern="")  
{  
    $arr=array();  
    $dir_handle=opendir($dir);  
    if($dir_handle)  
    {  
        // 这里必须严格比较，因为返回的文件名可能是“0”  
        while(($file=readdir($dir_handle))!==false)  
        {  
            if($file==='.' || $file==='..')  
            {  
                continue;  
            }  
            $tmp=realpath($dir.'/'.$file);  
            if(is_dir($tmp))  
            {  
                $retArr=list_file($tmp,$pattern);  
                if(!empty($retArr))  
                {  
                    $arr[]=$retArr;  
                }  
            }  
            else  
            {  
                if($pattern==="" || preg_match($pattern,$tmp))  
                {  
                    $arr[]=$tmp;  
                }  
            }  
        }  
        closedir($dir_handle);  
    }  
    return $arr;  
}  
