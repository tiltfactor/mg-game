<?php
class m111119_234451_install_v2_0 extends CDbMigration
{
    public function up()
    {
        return;
        $script = "
            ALTER TABLE `user_game` ADD `turn_user_id` INT NOT NULL DEFAULT '0';

            DROP TABLE IF EXISTS `user_game_bookmark` ;
            CREATE  TABLE IF NOT EXISTS `user_game_bookmark` (
              `user_id` INT(11) NOT NULL ,
              `game_id` INT(11) NOT NULL ,
              `media_id` INT(11) NOT NULL ,
              `played_game_id` INT(11) NULL ,
              `created` DATETIME NOT NULL ,
               PRIMARY KEY (`user_id`, `game_id`,`media_id`),
              INDEX `fk_user_bookmark_user` (`user_id` ASC) ,
              INDEX `fk_user_bookmark_game` (`game_id` ASC) ,
              INDEX `fk_user_bookmark_played_game` (`played_game_id` ASC) ,
              CONSTRAINT `fk_user_bookmark_user` FOREIGN KEY (`user_id` ) REFERENCES `user` (`id` ),
              CONSTRAINT `fk_user_bookmark_game` FOREIGN KEY (`game_id` ) REFERENCES `game` (`id` ),
              CONSTRAINT `fk_user_bookmark_media` FOREIGN KEY (`media_id` ) REFERENCES `media` (`id` ),
              CONSTRAINT `fk_user_bookmark_played_game` FOREIGN KEY (`played_game_id` ) REFERENCES `played_game` (`id` ))
            ENGINE = InnoDB DEFAULT CHARSET=UTF8;

            DROP TABLE IF EXISTS `user_game_interest` ;
            CREATE  TABLE IF NOT EXISTS `user_game_interest` (
              `id` INT NOT NULL AUTO_INCREMENT ,
              `user_id` INT(11) NOT NULL ,
              `game_id` INT(11) NOT NULL ,
              `interest` VARCHAR(255) NOT NULL,
              `created` DATETIME NOT NULL ,
              PRIMARY KEY (`id`) ,
              INDEX `fk_user_interest_user` (`user_id` ASC) ,
              INDEX `fk_user_interest_game` (`game_id` ASC) ,
              CONSTRAINT `fk_user_interest_user` FOREIGN KEY (`user_id` ) REFERENCES `user` (`id` ),
              CONSTRAINT `fk_user_interest_game` FOREIGN KEY (`game_id` ) REFERENCES `game` (`id` ))
            ENGINE = InnoDB DEFAULT CHARSET=UTF8;

            CREATE  TABLE IF NOT EXISTS `user_game_banned_institution` (
              `user_id` INT(11) NOT NULL ,
              `game_id` INT(11) NOT NULL ,
              `institution_id` INT(11) NOT NULL ,
              `created` DATETIME NOT NULL ,
              PRIMARY KEY (`user_id`,`game_id`,`institution_id`) ,
              INDEX `fk_user_banned_inst_user` (`user_id` ASC) ,
              INDEX `fk_user_banned_inst_game` (`game_id` ASC) ,
              INDEX `fk_user_banned_inst` (`institution_id` ASC) ,
              CONSTRAINT `fk_user_banned_inst_user` FOREIGN KEY (`user_id` ) REFERENCES `user` (`id` ),
              CONSTRAINT `fk_user_banned_inst_game` FOREIGN KEY (`game_id` ) REFERENCES `game` (`id` ),
              CONSTRAINT `fk_user_banned_inst` FOREIGN KEY (`institution_id` ) REFERENCES `institution` (`id` ))
            ENGINE = InnoDB DEFAULT CHARSET=UTF8;

            INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES ('researcher', 'player');

	  ";

        if (trim($script) != "") {
            $statements = explode(";\n", $script);

            if (count($statements) > 0) {
                foreach ($statements as $statement) {
                    if (trim($statement) != "")
                        $this->execute($statement);
                }
            }
        }

        //Yii::app()->fbvStorage->set("installed", true);
    }

    public function down()
    {
        $this->truncateTable('institution');
        $this->dropTable('institution');

    }

    /*
     // Use safeUp/safeDown to do migration with transaction
     public function safeUp()
     {
     }

     public function safeDown()
     {
     }
     */
}