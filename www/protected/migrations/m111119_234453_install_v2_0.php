<?php
class m111119_234452_install_v2_0 extends CDbMigration
{
    public function up()
    {
        $script = "
DELETE FROM AuthItem;
INSERT INTO AuthItem (name, type, description, bizrule, data) VALUES ('player', 2, 'A player can only record his or her games', NULL, NULL);
INSERT INTO AuthItem (name, type, description, bizrule, data) VALUES ('researcher', 2, 'An researcher has access to several tools in the system', NULL, NULL);
INSERT INTO AuthItem (name, type, description, bizrule, data) VALUES ('institution', 2, 'A institution user has only server access', NULL, NULL);
INSERT INTO AuthItem (name, type, description, bizrule, data) VALUES ('gameadmin', 2, 'The gameadmin can access everything', NULL, NULL);
UPDATE user SET role='researcher' WHERE role LIKE 'editor';
UPDATE user SET role='gameadmin' WHERE role LIKE 'admin';
UPDATE user SET role='gameadmin' WHERE role LIKE 'dbmanager';


DELETE FROM AuthItemChild;
INSERT INTO AuthItemChild (parent, child) VALUES ('researcher', 'player');
INSERT INTO AuthItemChild (parent, child) VALUES ('gameadmin', 'player');
INSERT INTO AuthItemChild (parent, child) VALUES ('gameadmin', 'researcher');
INSERT INTO AuthItemChild (parent, child) VALUES ('gameadmin', 'institution');
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
    }

    public function down()
    {
        $script = "
DELETE FROM AuthItem;
INSERT INTO AuthItem (name, type, description, bizrule, data) VALUES ('player', 2, 'A player can only record his or her games', NULL, NULL);
INSERT INTO AuthItem (name, type, description, bizrule, data) VALUES ('editor', 2, 'An editor has access to several tools in the system', NULL, NULL);
INSERT INTO AuthItem (name, type, description, bizrule, data) VALUES ('dbmanager', 2, 'A db manager has access to nearly all tools', NULL, NULL);
INSERT INTO AuthItem (name, type, description, bizrule, data) VALUES ('admin', 2, 'The admin can access everything', NULL, NULL);

UPDATE user SET role='editor' WHERE role LIKE 'researcher';
UPDATE user SET role='admin' WHERE role LIKE 'gameadmin';


DELETE FROM AuthItemChild;
INSERT INTO AuthItemChild (parent, child) VALUES ('editor', 'player');
INSERT INTO AuthItemChild (parent, child) VALUES ('dbmanager', 'player');
INSERT INTO AuthItemChild (parent, child) VALUES ('dbmanager', 'editor');
INSERT INTO AuthItemChild (parent, child) VALUES ('admin', 'player');
INSERT INTO AuthItemChild (parent, child) VALUES ('admin', 'editor');
INSERT INTO AuthItemChild (parent, child) VALUES ('admin', 'dbmanager');
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

    }
}
?>