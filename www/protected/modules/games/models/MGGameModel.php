<?php

/**
 * The generic model used to be extended by any game models. It provides standard
 * attributes that should be available for all games.
 */
abstract class MGGameModel extends Game
{
    /**
     * @var int
     */
    public $active = 0; //active will never be saved in the games FBVStorage settings it is just a handler for the Game database entry
    /**
     * @var string
     */
    public $arcade_image = "";
    /**
     * @var string
     */
    public $name = "";
    /**
     * @var string
     */
    public $description = "";
    /**
     * @var string
     */
    public $more_info_url = "";
    /**
     * @var int
     */
    public $image_width = 450;
    /**
     * @var int
     */
    public $image_height = 450;
    /**
     * @var int
     */
    public $play_once_and_move_on = 0;
    /**
     * @var string
     */
    public $play_once_and_move_on_url = "";
    /**
     * @var int
     */
    public $partner_wait_threshold = 0;
    /**
     * @var int
     */
    public $turns = 1;
    /**
     * @var int
     */
    public $submissions = 1;
    /**
     * @var int
     */
    public $play_against_computer = 0;
    /**
     * @var array
     */
    public $wordsToAvoid;

    /**
     * @param array $used_medias array of the media(s) which tags shall be retrieved
     */
    public function loadWordsToAvoid($used_medias)
    {
        $this->wordsToAvoid = array();
        $plugins = PluginsModule::getActiveGamePlugins($this->id, "dictionary");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "wordsToAvoid")) {
                    // this method gets all elements by reference. $data["wordstoavoid"] might be changed
                    $plugin->component->wordsToAvoid($this->wordsToAvoid, $used_medias);
                }
            }
        }
    }

    abstract public function fbvLoad();

    abstract public function fbvSave();

    abstract public function getGameID();
}