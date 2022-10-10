<?php

/**
 * m0001_users_tl.php
 * User: kzoltan
 * Date: 2022-06-14
 * Time: 14:30
 */

class m0001_users_tl
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        
        // ==========================
        // USERS_TL TÁBLA ELKÉSZÍTÉSE
        // ==========================
        $query = "CREATE TABLE mvc_framework.users_tl (
            tl_id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            mod_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Módosító azonosítója',
            mod_op ENUM('I','U','SD','R','D') DEFAULT NULL COMMENT 'Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete',
            id INT(11) NOT NULL COMMENT 'Rekord azonosító',
            email VARCHAR(50) NOT NULL COMMENT 'email cím',
            password VARCHAR(255) NOT NULL COMMENT 'jelszó',
            first_name VARCHAR(255) NOT NULL COMMENT 'keresztnév',
            last_name VARCHAR(255) DEFAULT NULL COMMENT 'vezetéknév',
            phone_number VARCHAR(255) DEFAULT NULL COMMENT 'telefonszám',
            time_zone VARCHAR(255) NOT NULL COMMENT 'időzóna',
            lang_id INT(11) NOT NULL COMMENT 'nyelv azonosító',
            news_subscription BIT(1) DEFAULT NULL COMMENT 'Hírlevél',
            status TINYINT(4) DEFAULT NULL COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            mod_u_id INT(11) DEFAULT NULL COMMENT 'módosító azonosítója',
            uuid VARCHAR(36) DEFAULT NULL,
            checksum VARCHAR(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            created_at TIMESTAMP NULL DEFAULT NULL COMMENT 'rekord készült',
            updated_at TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            status_changed_at TIMESTAMP NULL DEFAULT NULL COMMENT 'státusz változás',
            syncronized_at TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            PRIMARY KEY (tl_id)
          )
          ENGINE = INNODB,
          CHARACTER SET utf8,
          COLLATE utf8_general_ci;";
        $db->pdo->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        $query = "DROP TABLE mvc_framework.users_tl;";
        $db->pdo->exec($query);
    }
}