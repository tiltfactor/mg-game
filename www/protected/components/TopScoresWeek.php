<?php
/**
 * Top10Players class file
 *
 * @author Vincent Van Uffelen <novazembla@gmail.com>
 * @link http://www.metadatagames.com/
 * @copyright Copyright &copy; 2008-2012 Tiltfactor
 * @license http://www.metadatagames.com/license/
 * @package MG
 */

/**
 * Top10Players provides a small widget that lists the top 10 players in the system
 *
 * @author Vincent Van Uffelen <novazembla@gmail.com>
 * @since 1.0
 */
Yii::import('zii.widgets.CPortlet');
 
class TopScoresWeek extends CPortlet
{
  public function init() {
      $this->title=Yii::t('app', "Top Scores Since Sunday");

      parent::init();  // it is important to call this method after you've assigned any new values
  }
 
  protected function renderContent() {
    $topscore = GamesModule::getRecentTopPlayers();
    $games = GamesModule::getActiveGames();

//      $this->render('_renderpage', array(
//          'topscore' => $topscore,'games'=>$games
//      ));

      $this->render('topscoresweek', array(
        'topscore' => $topscore,'games'=>$games
      ));

  }
}