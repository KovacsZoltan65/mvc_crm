<?php

/**
 * Form.php
 * User: kzoltan
 * Date: 2022-05-18
 * Time: 13:20
 */

namespace app\core\form;

use app\core\Model;

/**
 * Description of Form
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */
class Form
{
    /**
     * Űrlap kezdete
     * @param type $action
     * @param type $method
     * @return string
     */
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }
    
    /**
     * Űrlap vége
     * @return string
     */
    public static function end()
    {
        echo '</form>';
    }
    
    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}
