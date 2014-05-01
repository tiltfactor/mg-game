<?php
/**
 * TopScoresWeek class file
 *
 * @author Xinqi Li
 * @copyright Copyright &copy; 2008-2012 Tiltfactor
 * @license http://www.metadatagames.com/license/
 * @package MG
 */

/**
 * TopScoresWeek provides a small widget that lists the top 5 players for each game in the system
 *
 * @author Xinqi
 */
Yii::import('zii.widgets.CPortlet');

class TopScoresWeek extends CPortlet
{
  public function init() {
      $this->title=Yii::t('app', "Top Scores");

      parent::init();  // it is important to call this method after you've assigned any new values
  }

  protected function renderContent() {
    $topscore = GamesModule::getRecentTopPlayers();
    $games = GamesModule::getActiveGames();
      $this->render('topscoresweek', array(
        'topscore' => $topscore,'games'=>$games
      ));

  }
}