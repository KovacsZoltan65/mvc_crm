<?php

/**
 * Company.php
 * User: kzoltan
 * Date: 2022-05-18
 * Time: 08:30
 */

namespace app\models;

use app\core\db\DbModel;

/**
 * Description of Company
 * Class Company
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\models
 * @version 1.0
 */
class Company extends DbModel
{
    public int $id = 0;
    public int $status = 1;
    public string $name = '';
    
    public function __construct()
    {
        //$this->mod_u_id = $_SESSION['user'];
        parent::__construct();
    }
    
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        array_push($attributes, 'mod_u_id');
        $params = array_map(fn($attr) => ":$attr", $attributes);
        
        if( $this->{$this->primaryKey()} == 0 )
        {
            $query = "INSERT INTO $tableName(" . implode(',', $attributes) . ") 
                VALUES(" . implode(',', $params) . ");";
        }
        else
        {
            $set = '';
            $where = '';
            for( $i = 0; $i < count($attributes); $i++ )
            {
                if( $attributes[$i] != $this->primaryKey() )
                {
                    if( strlen($set) != 0 )
                    {
                        $set .= ', ';
                    }
                    $set .= " $attributes[$i] = $params[$i] ";
                }
                else
                {
                    $where = "{$attributes[$i]} = {$params[$i]}";
                }
            }
            $query = "UPDATE companies SET $set WHERE $where;";
        }
        
        $statement = self::prepare($query);
        
        foreach($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
            //print_r( $this->{$attribute} . PHP_EOL );
        }
        
        $statement->execute();
        
        return true;
    }
    
    private function insert()
    {
        //
    }
    
    private function update()
    {
        //
    }
    
    /**
     * 
     * @return array
     */
    public function attributes(): array
    {
        return ['id', 'name', 'status'];
    }

    /**
     * Szabályok
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
        ];
    }

    /**
     * Címkék
     * @return array
     */
    public function labels(): array
    {
        return [
            'name' => 'Name',
        ];
    }
    
    /**
     * Elsődleges kulcs mező neve
     * @return string
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * Tábla neve
     * @return string
     */
    public static function tableName(): string
    {
        return 'companies';
    }

}
