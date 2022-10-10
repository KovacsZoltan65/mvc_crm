<?php

/**
 * Currency.php
 * User: kzoltan
 * Date: 2022-10-05
 * Time: 09:15
 */

namespace app\models;

use app\core\db\DbModel;

/**
 * Description of Currency
 * Class Company
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\models
 * @version 1.0
 */
class Currency extends DbModel
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function save()
    {
        //
    }
    
    private function insert()
    {
        //
    }
    
    private function update()
    {
        //
    }
    
    //put your code here
    public function attributes(): array
    {
        return [
            'id','lang_hu','lang_orig','country_hu',
            'country_orig','country_short','currency','vat_region',
            'in_select','status'
        ];
    }

    public function rules(): array
    {
        return [
            'lang_hu' => [self::RULE_REQUIRED],
            'lang_orig' => [self::RULE_REQUIRED],
            'country_hu' => [self::RULE_REQUIRED],
            'country_orig' => [self::RULE_REQUIRED],
            'country_short' => [self::RULE_REQUIRED],
            'currency' => [self::RULE_REQUIRED],
            'vat_region' => [self::RULE_REQUIRED],
            'in_select' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [];
    }
    
    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'currencies';
    }

}
