<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LimpiarCache{

    private static function initialize()
    {
        if (self::$initialized)
            return;

    }

    public static function clearCache($time){

        /*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        */
        header(
            'Expires: '.gmdate('D, d M Y H:i:s', time()+$time).'GMT');
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Cache-Control: post-check=0, pre-check=0', FALSE);
            header('Pragma: no-cache');
            header('Refresh: '.$time);

        
    }

}

?>