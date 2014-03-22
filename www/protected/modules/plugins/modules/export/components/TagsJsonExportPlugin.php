<?php // -*- tab-width:2; indent-tabs-mode:nil -*-
/**
 *
 * @BEGIN_LICENSE
 *
 * Metadata Games - A FOSS Electronic Game for Archival Data Systems
 * Copyright (C) 2013 Mary Flanagan, Tiltfactor Laboratory
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Affero General Public License
 * as published by the Free Software Foundation, either version 3 of
 * the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @END_LICENSE
 *
 */

Yii::import('ext.CSVExport.CSVExport');

class TagsJsonExportPlugin extends MGExportPlugin
{
    public $enableOnInstall = true;

    function init()
    {
        parent::init();
    }

    /**
     * Adds a checkbox that allows to activate/disactivate the use of the plugin on the
     * export form.
     *
     * @param object $form the GxActiveForm rendering the export form
     * @param object $model the ExportForm instance holding the forms values
     */
    function form(&$form, &$model)
    {
        $this->activeByDefault = true;

        $legend = CHtml::tag("legend", array(),
            Yii::t('app', 'Plugin: Tags MODS-JSON Export'));

        $value = $this->is_active() ? 1 : 0;
        $label = CHtml::label(Yii::t('app', 'Active'),
            'ExportForm_TagsJsonExportPlugin_active');

        $buttons = CHtml::radioButtonList(
            "ExportForm[TagsJsonExportPlugin][active]",
            $value,
            MGHelper::itemAlias("yes-no"),
            array("template" => '<div class="checkbox">{input} {label}</div>',
                "separator" => ""));

        return CHtml::tag("fieldset", array(),
            $legend .
            '<div class="row">' . $label . $buttons .
            '<div class="description">' .
            Yii::t('app',
                "Export image tags to a JSON file with MODS schema.") .
            '</div></div>');
    }

    /**
     * Creates the CSV export file in the temporary folder and add the header row
     * and the statistics for each game in the file.
     *
     * @param object $model the ExportForm instance
     * @param object $command the CDbCommand instance holding all information needed to retrieve the images' data
     * @param string $tmp_folder the full path to the temporary folder
     */
    function preProcess(&$model, &$command, $tmp_folder)
    {
        if (!$this->is_active()) {
            return 0;
        }

        $version = Yii::app()->params['version'];
        $format = Yii::app()->params['tags_csv_format'];
        $date = date("r");
        $system = "some.university.edu/mg/  (TODO: Source the correct value here)";
        // to sukie: this is the place to add other MODS elements, currently I only have extension
        $jsonData = [
            'extension' => [
                'comments' => ["This file contains an export of tag data from an installation of ",
                    "Metadata Games, a metadata tagging system from Tiltfactor Laboratory.",
                    "shortcutFor more information, see http://tiltfactor.org/mg/"],
                'version' => $version,
                'format' => $format,
                'data' => $date,
                'system' => $system,
                'media' => array()
            ]];

        file_put_contents($tmp_folder . $model->filename . '_tags.json',
            json_encode($jsonData, JSON_PRETTY_PRINT));

    }

    /**
     * Retrieves the tags for an image and exports them as a line of the CSV file
     *
     * @param object $model the ExportForm instance
     * @param object $command the CDbCommand instance holding all information needed to retrieve the images' data
     * @param string $tmp_folder the full path to the temporary folder
     * @param int $media_id the id of the image that should be exported
     */
    function process(&$model, &$command, $tmp_folder, $media_id)
    {
        if (!$this->is_active()) {
            return 0;
        }


//        $str_data = file_get_contents($tmp_folder . $model->filename . '_tags.json');
//        $jsonData = json_decode($str_data, true);
//
        $sql = "tu.media_id,";
        $sql = $sql . "COUNT(tu.id) tu_count,";
        $sql = $sql . "MIN(tu.weight) w_min,";
        $sql = $sql . "MAX(tu.weight) w_max,";
        $sql = $sql . "AVG(tu.weight) w_avg,";
        $sql = $sql . "SUM(tu.weight) as w_sum,";
        $sql = $sql . "t.tag,";
        $sql = $sql . "i.name media_name,";
        $sql = $sql . "inst.url,";
        $sql = $sql . "inst.name inst_name";

        $command->selectDistinct($sql);
        $command->where(array('and', $command->where, 'tu.media_id = :mediaID'),
            array(":mediaID" => $media_id, ':weight' => (int)$model->tag_weight_min, ':weightSum' => (int)$model->tag_weight_sum));
        $command->order('tu.media_id, t.tag');

        $info = $command->queryAll();
        $c = count($info);
        $tags = array();

        for ($i = 0; $i < $c; $i++) {
            $tags[] = $info[$i]['tag'];
        }

        $jsonData['extension']['media'][$info[0]['name']]['tag'] = $tags;

        if (!empty($tags)) {
            file_put_contents($tmp_folder . $model->filename . '_tags.json',
                json_encode($jsonData, JSON_PRETTY_PRINT));
        }

    }
}

?>
