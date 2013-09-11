<?php
class m111119_234451_install_v2_0 extends CDbMigration
{
    public function up()
    {
        $script = "
        CREATE TABLE IF NOT EXISTS `institution` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(128) NOT NULL,
              `url` varchar(128) NOT NULL,
              `token` varchar(128) NOT NULL,
              `status` int(1) NOT NULL DEFAULT '0',
              `created` datetime NOT NULL,
              `user_id` INT(11) NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`),
              UNIQUE KEY `url` (`url`),
              UNIQUE KEY `user_id` (`user_id`),
              CONSTRAINT `fk_institution_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        CREATE  TABLE IF NOT EXISTS `user_online` (
          `id` INT NOT NULL AUTO_INCREMENT ,
          `user_id` INT(11) NOT NULL ,
          `session_id` INT(11) NOT NULL ,
          `game_id` INT(11) NOT NULL ,
          `played_game_id` INT(11) NULL ,
          `status` int(1) NOT NULL DEFAULT '0',
          `created` DATETIME NOT NULL ,
           PRIMARY KEY (`id`) ,
           UNIQUE KEY `session_id` (`session_id`,`game_id`),
          INDEX `fk_game_player_user` (`user_id` ASC) ,
          INDEX `fk_game_player_session` (`session_id` ASC) ,
          INDEX `fk_game_player_game` (`game_id` ASC) ,
          INDEX `fk_game_player_played_game` (`played_game_id` ASC) ,
          CONSTRAINT `fk_game_player_user` FOREIGN KEY (`user_id` ) REFERENCES `user` (`id` ),
          CONSTRAINT `fk_game_player_session` FOREIGN KEY (`session_id` ) REFERENCES `session` (`id` ),
          CONSTRAINT `fk_game_player_game` FOREIGN KEY (`game_id` ) REFERENCES `game` (`id` ),
          CONSTRAINT `fk_game_player_played_game` FOREIGN KEY (`played_game_id` ) REFERENCES `played_game` (`id` ))
        ENGINE = InnoDB DEFAULT CHARSET=UTF8;

        ALTER TABLE `collection` ADD `institution_id` INT DEFAULT NULL,
            ADD `remote_id` INT DEFAULT NULL ,
            ADD UNIQUE (`institution_id`,`remote_id`),
            ADD CONSTRAINT `fk_institution` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`);
        ALTER TABLE `licence` ADD `institution_id` INT DEFAULT NULL,
            ADD `remote_id` INT DEFAULT NULL ,
            ADD UNIQUE (`institution_id`,`remote_id`),
            ADD CONSTRAINT `fk_licence_institution` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`);
        ALTER TABLE `media` ADD `institution_id` INT DEFAULT NULL,
            ADD `remote_id` INT DEFAULT NULL ,
            ADD UNIQUE (`institution_id`,`remote_id`),
            ADD CONSTRAINT `fk_media_institution` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`);

        CREATE  TABLE IF NOT EXISTS `user_game` (
          `id` INT NOT NULL AUTO_INCREMENT ,
          `user_id_1` INT(11) NOT NULL ,
          `user_id_2` INT(11) NOT NULL ,
          `game_id` INT(11) NOT NULL ,
          `played_game_id` INT(11) NULL ,
           PRIMARY KEY (`id`) ,
          INDEX `fk_user_game_user1` (`user_id_1` ASC) ,
          INDEX `fk_user_game_user2` (`user_id_2` ASC) ,
          INDEX `fk_user_game_game` (`game_id` ASC) ,
          INDEX `fk_user_game_played_game` (`played_game_id` ASC) ,
          CONSTRAINT `fk_user_game_user1` FOREIGN KEY (`user_id_1` ) REFERENCES `user` (`id` ),
          CONSTRAINT `fk_user_game_user2` FOREIGN KEY (`user_id_2` ) REFERENCES `user` (`id` ),
          CONSTRAINT `fk_user_game_game` FOREIGN KEY (`game_id` ) REFERENCES `game` (`id` ),
          CONSTRAINT `fk_user_game_played_game` FOREIGN KEY (`played_game_id` ) REFERENCES `played_game` (`id` ))
        ENGINE = InnoDB DEFAULT CHARSET=UTF8;

         CREATE  TABLE IF NOT EXISTS `user_message` (
          `id` INT NOT NULL AUTO_INCREMENT ,
          `from_user_id` INT(11) NOT NULL ,
          `to_user_id` INT(11) NOT NULL ,
          `game_id` INT(11) NOT NULL ,
          `played_game_id` INT(11) NULL ,
          `message` VARCHAR(255) NOT NULL DEFAULT '' ,
          `type` int(1) NOT NULL DEFAULT '0',
           PRIMARY KEY (`id`) ,
          INDEX `fk_user_message_user1` (`from_user_id` ASC) ,
          INDEX `fk_user_message_user2` (`to_user_id` ASC) ,
          INDEX `fk_user_message_game` (`game_id` ASC) ,
          INDEX `fk_user_message_played_game` (`played_game_id` ASC) ,
          CONSTRAINT `fk_user_message_user1` FOREIGN KEY (`from_user_id` ) REFERENCES `user` (`id` ),
          CONSTRAINT `fk_user_message_user2` FOREIGN KEY (`to_user_id` ) REFERENCES `user` (`id` ),
          CONSTRAINT `fk_user_message_game` FOREIGN KEY (`game_id` ) REFERENCES `game` (`id` ),
          CONSTRAINT `fk_user_message_played_game` FOREIGN KEY (`played_game_id` ) REFERENCES `played_game` (`id` ))
        ENGINE = InnoDB DEFAULT CHARSET=UTF8;
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