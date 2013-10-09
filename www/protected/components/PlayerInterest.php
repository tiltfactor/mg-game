<?php
Yii::import('zii.widgets.CPortlet');
class PlayerInterest extends CPortlet
{
    /**
     * @var int the user id
     */
    public $user_id;

    /**
     * @var boolean If true list only active games.
     */
    public $active = true;

    public function init()
    {
        $this->title = Yii::t('app', "Player Interests");

        if (is_null($this->user_id))
            $this->user_id = Yii::app()->user->id;

        parent::init(); // it is important to call this method after you've assigned any new values
    }

    protected function renderContent()
    {
        if ($this->user_id) {
            $interests = Yii::app()->db->createCommand()
                ->select('g.id, g.unique_id, gi.interest, gi.created')
                ->from('{{game}} g')
                ->join('{{user_game_interest}} gi', 'gi.game_id=g.id AND gi.user_id=:userID', array(':userID' => $this->user_id))
                ->where(($this->active) ? 'g.active=1' : null)
                ->order('g.id ASC')
                ->queryAll();

            if (is_null($interests))
                $interests = array();

            $this->render('playerInterests', array(
                'interests' => $interests
            ));
        }
    }
}
