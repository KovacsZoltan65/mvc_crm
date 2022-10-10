<?php

/**
 * m0002_companies_tl.php
 * User: kzoltan
 * Date: 2022-06-18
 * Time: 14:00
 */

/**
 * Description of m0002_companies_tl
 *
 * @author Selester
 */
class m0002_companies_tl
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        
        $query = "CREATE TABLE mvc_framework.companies_tl (
            tl_id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            mod_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Módosító azonosítója',
            mod_op ENUM('I','U','SD','R','D') DEFAULT NULL COMMENT 'Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete',
            id INT(11) NOT NULL COMMENT 'Rekord azonosító',
            name VARCHAR(255) NOT NULL COMMENT 'cég megnevezése',
            status TINYINT(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            mod_u_id INT(11) NOT NULL COMMENT 'módosító azonosítója',
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
        
        
        
        $db->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        
        $query = "";
        
        $db->exec($query);
    }
}
