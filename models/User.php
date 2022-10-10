<?php

/**
 * User.php
 * User: kzoltan
 * Date: 2022-05-18
 * Time: 08:30
 */
namespace app\models;

use app\core\Language;
use app\core\UserModel;

/**
 * Description of User
 * Class User
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\models
 * @version 1.0
 */
class User extends UserModel
{
    //const STATUS_INACTIVE = 0;
    //const STATUS_ACTIVE = 1;
    //const STATUS_DELETED = 2;
    
    public string $first_name = '',
        $last_name = '',
        $email = '',
        $password = '',
        $confirm_password = '';
    public int $status = self::STATUS_INACTIVE;
    
    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name'  => [self::RULE_REQUIRED],
            'email'      => [
                self::RULE_REQUIRED, 
                self::RULE_EMAIL,
                [
                    self::RULE_UNIQUE, 
                    'class' => self::class, 
                    'attribute' => 'email'
                ]
            ],
            'password'          => [
                self::RULE_REQUIRED, 
                [self::RULE_MIN, 'min' => 8], 
                [self::RULE_MAX, 'max' => 24]
            ],
            'confirm_password'  => [
                self::RULE_REQUIRED, 
                [self::RULE_MATCH, 'match' => 'password']
            ],
        ];
    }

    /**
     * Adattábla neve
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * Elsődleges kulcs neve
     * @return string
     */
    public static function primaryKey(): string
    {
        return 'id';
    }
    
    public function attributes(): array
    {
        return ['first_name','last_name','email','password', 'status'];
    }
    
    /**
     * Címkék
     * @return array
     */
    public function labels(): array
    {
        return [
            'first_name' => Language::trans('first_name'),
            'last_name' => Language::trans('last_name'),
            'email' => Language::trans('email'),
            'password' => Language::trans('password'),
            'confirm_password' => Language::trans('confirm_password'),
            'status' => Language::trans('status')
        ];
    }

    /**
     * Felhasználó teljes neve a megjelenítéshez
     * @return string
     */
    public function getDisplayName(): string
    {
        return "$this->first_name $this->last_name";
    }

}
