<?php

/**
 * Functions.php
 * User: kzoltan
 * Date: 2022-07-05
 * Time: 09:45
 */

namespace app\core;

/**
 * Description of Functions
 *
 * @author kzoltan
 */
class Functions
{
    public function getActualUserId(): int
    {
        return (int)$_SESSION['user'];
    }
    
    public static function is_active_menu(string $menu_name): bool
    {
        return ( trim(basename( filter_input(INPUT_SERVER, 'REQUEST_URI'), '.php' ).PHP_EOL) == $menu_name );
    }
    
    public static function getActiveMenu()
    {
        return trim(basename( filter_input(INPUT_SERVER, 'REQUEST_URI'), '.php' ).PHP_EOL);
    }
    
    public static function getDirectory (string $path):string
    {
        $retval = '';
        //echo '<pre>';
        //var_dump($path);
        
        
        $document_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        //var_dump($document_root);
        $aa = explode('\\', $document_root);
        //var_dump($aa);
        
        $retval = "$aa[0]\\$aa[1]\\$aa[2]\\$aa[3]" . $path;
        //var_dump($retval);
        //echo '</pre>';
        //exit;
        /* 
        $request_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        //$dir = explode('/', filter_input(INPUT_SERVER, 'REQUEST_URI'))[1];
        $aa = explode('\\', $document_root);
        $retval = "$aa[0]\\$aa[1]\\$aa[2]\\$aa[3]" . $path;
        */
        return $retval;
    }
    
    public static function assets(string $path) : string
    {
        $https = filter_input(INPUT_SERVER, 'HTTPS');
        $http_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $php_self = filter_input(INPUT_SERVER, 'PHP_SELF');
        
        $retval = (isset($https) && $https === 'on' ? 
            'https' : 'http'
        ) . '://' . $http_host . dirname($php_self) . $path;
        
        return $retval;
    }
    
}
