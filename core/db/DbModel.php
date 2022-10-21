<?php

/**
 * DbModel.php
 * User: kzoltan
 * Date: 2022-06-21
 * Time: 14:30
 */

namespace app\core\db;

use app\core\Application;
use app\core\Model;
use PDO;
use PDOStatement;

/**
 * Description of DbModel
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\db
 * @version 1.0
 */
abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    const INT_TRUE = 1,
        INT_FALSE = 0;

    /**
     * Adatok mentése
     * @return boolean
     */
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $query = "INSERT INTO $tableName(" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ");";

        $statement = self::prepare($query);

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();

        return true;
    }

    public function delete()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $query = "";
    }

    /**
     * Egy rekord lekérése az adatbázisból az átadott paraméterek alapján.
     * @param array $where Lekéréshez szükséges paraméterek
     * @return type
     */
    public static function findOne(array $where)   // ['email' => 'person@company.com', 'first_name' => 'FirstName']
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql;");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function find(array $where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql;");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function getAll(): array
    {
        $tableName = static::tableName();
        $sql = "SELECT * FROM $tableName;";

        $statement = self::prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    /**
     * Adatbáziskérés előkészítése
     * @param string $sql Lekérdezés
     * @return type
     */
    public static function prepare(string $sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function getStatusName(): string
    {
        $status_name = '';
        if ($this->status === 0) {
            $status_name = self::STATUS_INACTIVE;
        } elseif ($this->status === 1) {
            $status_name = self::STATUS_ACTIVE;
        } elseif ($this->status === 2) {
            $status_name = self::STATUS_DELETED;
        }

        return $status_name;
    }

    public function __construct()
    {
        parent::__construct();
    }
}
