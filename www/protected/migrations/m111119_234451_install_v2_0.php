<?php
class m111119_234451_install_v2_0 extends CDbMigration
{
    public function up()
    {
        $script = "
        CREATE TABLE IF NOT EXISTS `institution` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(128) NOT NULL,
              `email` varchar(128) NOT NULL,
              `password` varchar(128) NOT NULL,
              `url` varchar(128) NOT NULL,
              `token` varchar(128) NOT NULL,
              `status` int(1) NOT NULL DEFAULT '0',
              `created` datetime NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`),
              UNIQUE KEY `email` (`email`),
              UNIQUE KEY `url` (`url`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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