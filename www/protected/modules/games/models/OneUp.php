<?php

/**
 */
class OneUp extends MGGameModel
{
    public $name = "OneUp";
    public $arcade_image = "oneup_arcade.png";
    public $description = "Clear your mind and you will hear the voice of the serene tagger within you. Ohm.";
    public $turns = 3;
    public $submissions = 3;

    public function rules() {
        return array(
            array('name, description, arcade_image, active, turns, submissions', 'required'),
            array('name', 'length', 'min'=>1, 'max'=>100),
            array('description', 'length', 'min'=>25, 'max'=>500),
            array('more_info_url','url'),
            array('image_width, image_height', 'numerical', 'min'=>50, 'max'=>1000),
            array('active', 'numerical', 'min'=>0, 'max'=>1),
            array('turns, submissions', 'numerical', 'min'=>1, 'max'=>1000),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('app', 'Name'),
            'arcade_image' => Yii::t('app', 'Game Media Location'),
            'description' => Yii::t('app', 'Description'),
            'image_width' => Yii::t('app', 'Maximum Media Width'),
            'image_height' => Yii::t('app', 'Maximum Media Height'),
            'turns' => Yii::t('app', 'Turns'),
            'submissions' => Yii::t('app', 'Number of submits per turn')
        );
    }

    public function fbvLoad() {
        $game_data = Yii::app()->fbvStorage->get("games." . $this->getGameID(), null);
        if (is_array($game_data)) {
            $this->name = $game_data["name"];
            $this->description = $game_data["description"];
            $this->arcade_image = $game_data["arcade_image"];
            $this->more_info_url = $game_data["more_info_url"];
            $this->turns = (int)$game_data["turns"];
            $this->submissions = (int)$game_data["submissions"];
            $this->image_width = (int)$game_data["image_width"];
            $this->image_height = (int)$game_data["image_height"];
        }
    }

    public function fbvSave() {
        $game_data = array(
            'name' => $this->name,
            'description' => $this->description,
            'arcade_image' => $this->arcade_image,
            'more_info_url' => $this->more_info_url,
            'turns' => $this->turns,
            'submissions' => $this->submissions,
            'image_width' => $this->image_width,
            'image_height' => $this->image_height,
        );

        Yii::app()->fbvStorage->set("games." . $this->getGameID(), $game_data);
    }

    public function getGameID() {
        return __CLASS__;
    }
}
