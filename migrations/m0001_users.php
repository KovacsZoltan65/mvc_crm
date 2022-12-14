<?php

/**
 * m0001_users.php
 * User: kzoltan
 * Date: 2022-05-19
 * Time: 07:20
 */

class m0001_users
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        
        // ============================================================
        // USERS TÁBLA ELKÉSZÍTÉSE
        // ============================================================
        $query = "CREATE TABLE mvc_framework.users (
            id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            email VARCHAR(50) NOT NULL COMMENT 'email cím',
            password VARCHAR(255) NOT NULL COMMENT 'jelszó',
            first_name VARCHAR(255) NOT NULL COMMENT 'keresztnév',
            last_name VARCHAR(255) DEFAULT NULL COMMENT 'vezetéknév',
            phone_number VARCHAR(255) DEFAULT NULL COMMENT 'telefonszám',
            time_zone VARCHAR(255) NOT NULL COMMENT 'időzóna',
            lang_id INT(11) NOT NULL COMMENT 'nyelv azonosító',
            news_subscription BIT(1) DEFAULT NULL COMMENT 'Hírlevél',
            status TINYINT(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            mod_u_id INT(11) NOT NULL COMMENT 'módosító azonosítója',
            uuid VARCHAR(36) DEFAULT NULL,
            checksum VARCHAR(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            created_at TIMESTAMP NULL DEFAULT NULL COMMENT 'rekord készült',
            updated_at TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            status_changed_at TIMESTAMP NULL DEFAULT NULL COMMENT 'státusz változás',
            syncronized_at TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            PRIMARY KEY (id)
          )
          ENGINE = INNODB,
          CHARACTER SET utf8,
          COLLATE utf8_general_ci;";
        
        $db->pdo->exec($query);
        
        // ============================================================
        // BEFORE INSERT TRIGGER
        // ============================================================
        // Az új rekord mentése(INSERT művelet) előtt fut le.
        // Létrehozza a készítés (created_at), frissítés (updated_at) dátumát,
        // a globális azonosítót (uuid),
        // és az ellenörző összeget (checksum).
        // Ezek technikai mezők, a felhasználónak nem kell vele foglalkozni.
        $query = "CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.users_BEFORE_INSERT BEFORE INSERT ON mvc_framework.users
            FOR EACH ROW
            BEGIN
              SET NEW.created_at = UTC_TIMESTAMP();
              SET NEW.updated_at = UTC_TIMESTAMP();
              SET NEW.uuid = UUID();
              SET NEW.checksum = md5(
                concat(
                    NEW.email, NEW.password, NEW.first_name, NEW.last_name, NEW.status
                )
              );
            END";
        $db->pdo->exec($query);
        
        // ============================================================
        // AFTER INSERT TRIGGER
        // ============================================================
        // Az új rekord mentése(INSERT művelet) után fut le.
        // Létrehozza az új rekord másolatát a történelmi (tl) táblában.
        // Kiegészítve a rekord azonosítóval (tl_id autoincrement),
        // a létrehozó felhasználó azonosítójával (mod_u_id),
        // az aktuális utc idővel és a módosítási opcióval (1 = I).
        $query = "CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.users_AFTER_INSERT AFTER INSERT ON mvc_framework.users 
            FOR EACH ROW
            BEGIN
                INSERT INTO users_tl SELECT NEW.mod_u_id, UTC_TIMESTAMP(), 1, u.* FROM user u WHERE u.u_id = NEW.id;
            END";
        $db->pdo->exec($query);
        
        // ============================================================
        // BEFORE UPDATE TRIGGER
        // ============================================================
        // A rekord módosítása előtt fut le.
        // Ha a státusz változik, akkor a változás dátumát is menteni kell.
        // Létrehozza az új ellenörző összeget.
        // Ha a régi és az új ellenörző összeg nem egyforma, akkor a rekord megváltozott.
        // Változáskor be kell állítani a módosítás dátumát.
        $query = "CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.users_BEFORE_UPDATE
                BEFORE UPDATE
                ON users
                FOR EACH ROW
            BEGIN

              IF ( OLD.status <> NEW.status ) THEN
                SET NEW.status_changed_at = UTC_TIMESTAMP();
              END IF;

              SET @new_checksum = MD5(
                CONCAT(
                  NEW.email, 
                  NEW.password, 
                  NEW.first_name, 
                  NEW.last_name, 
                  NEW.status
                )
              );

              IF ( OLD.checksum <> @new_checksum ) THEN
                SET NEW.updated_at = UTC_TIMESTAMP();
                SET NEW.checksum = @new_checksum;
              END IF;

            END";
        $db->pdo->exec($query);
        
        // ============================================================
        // AFTER UPDATE TRIGGER
        // ============================================================
        // A rekord módosítása (UPDATE művelet) után fut le.
        // Létrehozza az módosított rekord másolatát a történelmi (tl) táblában.
        // Kiegészítve a rekord azonosítóval (tl_id autoincrement),
        // a létrehozó felhasználó azonosítójával (mod_u_id),
        // az aktuális utc idővel és a módosítási opcióval (2 = U).
        $query = "CREATE DEFINER=`root`@`localhost` TRIGGER users_AFTER_UPDATE
                AFTER UPDATE
                ON users
                FOR EACH ROW
            BEGIN

              IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                set @mod_op = 2;
                # ha törölték a rekordot, akkor ...
                IF OLD.status = 1 AND NEW.status = 0 THEN
                  # A módosítási opciót 3-ra (SD delete) állítom
                  set @mod_op = 3;
                ELSEIF OLD.status = 0 AND NEW.status = 1 THEN
                  # A módosítási opciót 4-re (R restore) állítom
                  set @mod_op = 4;
                END IF;

                INSERT INTO users_tl SELECT NULL, UTC_TIMESTAMP(), @mod_op, u.* FROM users u WHERE u.id = NEW.id;

              END IF;
            END";
        $db->pdo->exec($query);
        
        // ==============
        // DELETE TRIGGER
        // ==============
        $query = "CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.users_BEFORE_DELETE
                BEFORE DELETE
                ON mvc_framework.users
                FOR EACH ROW
            BEGIN
              IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                INSERT INTO users_tl SELECT NULL, UTC_TIMESTAMP(), 5, u.* FROM users u WHERE u.id = OLD.id;
              END IF;
            END";
        $db->pdo->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        
        // ============================================================
        // TÁBLA ELDOBÁSA
        // ============================================================
        $query = "DROP TABLE mvc_framrwork.users;";
        $db->pdo->exec($query);
        
        // ============================================================
        // BEFORE INSERT TRIGGER ELDOBÁSA
        // ============================================================
        $query = "DROP TRIGGER mvc_framework.users_BEFORE_INSERT;";
        $db->pdo->exec($query);
        
        // ============================================================
        // AFTER INSERT TRIGGER ELDOBÁSA
        // ============================================================
        $query = "DROP TRIGGER mvc_framework.users_AFTER_INSERT;";
        $db->pdo->exec($query);
        
        // ============================================================
        // BEFORE UPDATE TRIGGER ELDOBÁSA
        // ============================================================
        $query = "DROP TRIGGER mvc_framework.users_BEFORE_UPDATE;";
        $db->pdo->exec($query);
        
        // ============================================================
        // AFTER UPDATE TRIGGER ELDOBÁSA
        // ============================================================
        $query = "DROP TRIGGER mvc_framework.users_AFTER_UPDATE;";
        $db->pdo->exec($query);
        
        // ============================================================
        // DELETE TRIGGER ELDOBÁSA
        // ============================================================
        $query = "DROP TRIGGER mvc_framework.users_BEFORE_DELETE;";
        $db->pdo->exec($query);
    }
}