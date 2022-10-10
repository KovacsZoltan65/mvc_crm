<?php

/**
 * m0003_countries.php
 * User: kzoltan
 * Date: 2022-06-20
 * Time: 13:45
 */

/**
 * Description of m0003_coutries
 *
 * @author kzoltan
 */
class m0003_coutries_tl
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        
        $query = "CREATE TABLE mvc_framework.countries_tl (
            tl_id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            mod_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Módosító azonosítója',
            mod_op ENUM('I','U','SD','R','D') DEFAULT NULL COMMENT 'Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete',
            id INT(11) UNSIGNED NOT NULL COMMENT 'Rekord azonosító',
            lang_hu VARCHAR(50) DEFAULT NULL COMMENT 'nyelv magyarul',
            lang_orig VARCHAR(50) DEFAULT NULL COMMENT 'nyelv eredeti',
            country_hu VARCHAR(50) DEFAULT NULL COMMENT 'ország magyarul',
            country_orig VARCHAR(50) DEFAULT NULL COMMENT 'ország eredeti',
            country_short VARCHAR(4) DEFAULT NULL COMMENT 'ország rövid',
            currency VARCHAR(3) DEFAULT NULL COMMENT 'Pénznem',
            vat_region INT(11) DEFAULT NULL COMMENT '0: Belföld, 1: EU, 3: EU-n kívül',
            in_select INT(1) NOT NULL DEFAULT 1 COMMENT 'Select választóban; 0: nem; 1: igen',
            status TINYINT(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            mod_u_id INT(11) NOT NULL COMMENT 'módosító azonosítója',
            uuid VARCHAR(36) DEFAULT NULL COMMENT 'Globális rekord azonosító',
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
        $db->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        
        $query = "DROP TABLE mvc_framework.countries_tl;";
        $db->pdo->exec($query);
    }
}
