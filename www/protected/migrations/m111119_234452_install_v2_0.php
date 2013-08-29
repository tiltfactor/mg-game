<?php
class m111119_234452_install_v2_0 extends CDbMigration
{
    public function up()
    {
        $this->addColumn('user', 'open_id', 'varchar(500)');

    }

    public function down()
    {
        $this->dropColumn('user', 'open_id');
    }

}
?>