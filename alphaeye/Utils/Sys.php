<?php
namespace Libs\Utils;

class Sys
{
    public static function action($action, $options = [])
    {
        list($a,$c) = explode('.', $action);
        return ['uses'=>'\\Modules\\'.$a.'\\Controllers\\'.$c ,'as'=>isset($options['as'])?$options['as']:'', 'prefix'=>isset($options['prefix'])?$options['prefix']:'', 'relate'=>isset($options['relate'])?$options['relate']:''];
    }
    
}