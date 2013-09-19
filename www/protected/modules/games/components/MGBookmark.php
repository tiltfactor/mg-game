<?php

/**
 *
 */
class MGBookmark extends CComponent
{

    /**
     * @var MGGameModel
     */
    protected $game;
    /**
     * @var string
     */
    protected $apiId;
    /**
     * @var int
     */
    protected $sessionId;

    /**
     * @var int
     */
    protected $userId;


    /**
     * @param string $unique_id
     * @throws CHttpException
     */
    function __construct($unique_id)
    {
        $this->apiId = Yii::app()->fbvStorage->get("api_id", "MG_API");
        $this->sessionId = (int)Yii::app()->session[$this->apiId . '_SESSION_ID'];
        $this->game = GamesModule::loadGameFromDB($unique_id);
        $this->game->fbvLoad();

        if ($this->sessionId > 0) {
            if (Yii::app()->user->isGuest) {
                throw new CHttpException(400, Yii::t('app', 'Authentication required.'));
            }

            $this->userId = (int)Yii::app()->user->id;
        }
    }


    /**
     * @return GameMediaDTO[]
     */
    public function getAll()
    {
        $query = 'user_id =:userId AND game_id=:gameId';

        /**
         * @var UserGameBookmark[] $bookmarks
         */
        $bookmarks = UserGameBookmark::model()->with('media')->findAll($query, array(':userId' => $this->userId, ':gameId' => $this->game->id));
        $result = array();
        if ($bookmarks) {
            foreach ($bookmarks as $bookmark) {
                $mediaDTO = new GameMediaDTO();

                /**
                 * @var Institution $institution
                 */
                $institution = $bookmark->media->getRelated('institution');

                if ($institution) {
                    $path = $institution->url . Yii::app()->fbvStorage->get('settings.app_upload_url');
                } else {
                    $path = Yii::app()->getBaseUrl(true) . Yii::app()->fbvStorage->get('settings.app_upload_url');
                }

                list($mediaType, $type_2) = explode("/", $bookmark->media->mime_type);

                $mediaDTO->id = $bookmark->media->id;
                $mediaDTO->mimeType = $bookmark->media->mime_type;

                if ($mediaType === "image") {
                    $mediaDTO->thumbnail = $path . "/thumbs/" . $bookmark->media->name;
                    $mediaDTO->imageFullSize = $path . "/images/" . $bookmark->media->name;
                } else if ($mediaType === "video") {
                    $mediaDTO->thumbnail = $path . "/videos/" . urlencode(substr($bookmark->media->name, 0, -4) . "jpeg");
                    $mediaDTO->videoWebm = $path . "/videos/" . urlencode($bookmark->media->name);
                    $mediaDTO->videoMp4 = $path . "/videos/" . urlencode(substr($bookmark->media->name, 0, -4) . "mp4");
                } else if ($mediaType === "audio") {
                    $mediaDTO->thumbnail = Yii::app()->getBaseUrl(true) . "/images/audio.png";
                    $mediaDTO->audioMp3 = $path . "/audios/" . urlencode($bookmark->media->name);
                    $mediaDTO->audioOgg = $path . "/audios/" . urlencode(substr($bookmark->media->name, 0, -3) . "ogg");
                }

                array_push($result, $mediaDTO);
            }
        }

        return $result;
    }

    /**
     * @param int $mediaId
     * @param int $playedId
     * @throws CHttpException
     */
    public function add($mediaId, $playedId)
    {
        $model = new UserGameBookmark();
        $model->user_id = $this->userId;
        $model->game_id = $this->game->id;
        $model->media_id = $mediaId;
        $model->played_game_id = $playedId;
        $model->created = date('Y-m-d H:i:s');

        if (!$model->save()) {
            $message = "";
            $errors = $model->getErrors();
            foreach ($errors as $field => $error) {
                $message .= $error[0] . ";";
            }
            throw new CHttpException(500, $message);
        }
    }

    /**
     * @param int $mediaId
     * @throws CHttpException
     */
    public function remove($mediaId)
    {
        $query = 'user_id =:userId AND game_id=:gameId AND media_id=:mediaId';
        $bookmark = UserGameBookmark::model()->find($query, array(':userId' => $this->userId,
            ':gameId' => $this->game->id,
            ':mediaId' => $mediaId));
        if ($bookmark) {
            if (!$bookmark->delete()) {
                $message = "";
                $errors = $bookmark->getErrors();
                foreach ($errors as $field => $error) {
                    $message .= $error[0] . ";";
                }
                throw new CHttpException(500, $message);
            }
        }
    }
}
