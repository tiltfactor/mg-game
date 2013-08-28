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

        Yii::app()->fbvStorage->set("installed", true);
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