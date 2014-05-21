<?php
/**
 * 配置类，管理配置文件
 */
class Config {
    static private $mInstance = array();
    /**
     * Instance of this singleton class,从xml载入
     *
     * @return ConfigArray
     */
    static public function Instance($type='xml')
    {
        $config_file = $type;
        $type = substr($config_file, -3); //only support ini,xml，获取最后三个字
        switch( $type )
        {
            case 'xml':
                return self::LoadFromXml($config_file);
            case 'ini':
                return self::LoadFromIni($config_file);
            case 'php':
                return self::LoadFromPhp($config_file);
        }
        return null;
    }
	//从xml读入，写入instance['文件名'](默认instance['xml'])的变量里
    static private function LoadFromXml($config_file='xml')
    {
        if ( $config_file=='xml' && defined('SYS_XMLFILE')) {
            $config_file = SYS_XMLFILE;
        }
        else if ( 0 !== strpos($config_file, '/') ) {
            $config_file = DIR_CONFIGURE . '/' . $config_file;
        }

        if ( isset(self::$mInstance[$config_file]) )
            return self::$mInstance[$config_file];

        if ( file_exists($config_file) )
        {
            $instance = simplexml_load_file($config_file);
            self::$mInstance[$config_file] = $instance;
            return $instance;
        }
        return null;
    }
	//从Ini读入，写入instance['文件名'](默认instance['ini'])中
    static private function LoadFromIni($config_file='ini')
    {
        if ( $config_file=='ini' && defined('SYS_INIFILE')) {
            $config_file = SYS_INIFILE;
        }
        else if ( 0 !== strpos($config_file, '/') ) {
            $config_file = DIR_CONFIGURE . '/' . $config_file;
        }

        if ( isset(self::$mInstance[$config_file]) )
            return self::$mInstance[$config_file];

        if ( file_exists($config_file) )
        {
            $instance = parse_ini_file($config_file, true);
            self::$mInstance[$config_file] = $instance;
            return $instance;
        }
        return null;
    }
	//从php读入，写入instance['文件名'](默认instance['php'])中
    static private function LoadFromPhp($config_file='php')
    {
        if ( $config_file=='php' && defined('SYS_PHPFILE')) {
            $config_file = SYS_PHPFILE;//系统配置文件system.php,系统装好都应该这样
        }
        else if ( 0 !== strpos($config_file, '/') ) {
            $config_file = DIR_CONFIGURE . '/' . $config_file;//载入指定的配置文件
        }
		//如果已经初始化，直接返回
        if ( isset(self::$mInstance[$config_file]) )
            return self::$mInstance[$config_file];
		//否则找到文件，载入
        if ( file_exists($config_file) )
        {
			$INI=require($config_file);
            self::$mInstance[$config_file] = $instance = $INI;
            return $instance;
        }
        return null;
    }
	
	/** 合并配置2到配置1，相同项覆盖，没有的并存
	 * @param unknown_type $ini1 
	 * @param unknown_type $ini2
	 */
	static public function MergeINI($ini1, $ini2) {
		settype($ini1, 'array');
		settype($ini2, 'array');
		foreach($ini2 AS $k=>$v) {
			if (!isset($ini1[$k]) || !is_array($v)) {//没有，同时是简单配置
				$ini1[$k] = $v;
			}
			else {
				$ini1[$k] = self::MergeINI($ini1[$k], $v);//合并两个数组配置
			}
		}
		return $ini1;
	}

    static private function ToArray($i)
    {
        if (is_object($i)) {
            $c = $i->children();
            if (!count($c)) {
                $o = (string)$i;
            } else {
                $o = new stdClass();
                foreach ($c as $k => $v) {
                    if (isset($o->$k)) {
                        if (!is_array($o->$k)) 
                            $o->$k = array($o->$k);
                        $o->{$k}[] = self::_dump($v);
                    } else $o->$k = self::_dump($v);
                }
            }
            $i = $o;
        } elseif (is_array($i)) {
            foreach ($i as $k => $v) {
                $i[$k] = self::_dump($v);
            }
        }
        return $i;
    }
}
?>
