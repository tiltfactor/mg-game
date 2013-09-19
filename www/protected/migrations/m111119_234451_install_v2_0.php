<?php
class m111119_234451_install_v2_0 extends CDbMigration
{
    public function up()
    {
        return;
        $script = "
            ALTER TABLE `user_game` ADD `turn_user_id` INT NOT NULL DEFAULT '0';
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