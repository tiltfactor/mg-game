<?php
/**
 *
 * @package
 */
class GameTurnDTO
{
    /**
     * @var integer
     */
    public $turn;
    /**
     * Total score of game turn
     * @var integer
     */
    public $score;
    /**
     * turn tags
     * @var GameTagDTO[]
     */
    public $tags;
    /**
     * Turn images to show
     * @var GameMediaDTO[]
     */
    public $media;
    /**
     * turn licences
     * @var GameLicenceDTO[]
     */
    public $licences;
    /**
     * @var string[]
     */
    public $wordsToAvoid;

    /**
     * @static
     * @param string $json
     * @return GameTurnDTO
     */
    static public function createFromJson($json)
    {
        $json = json_decode($json);
        if (is_object($json)) {
            $object = new self();
            foreach ($json as $key => $value) {
                $object->{$key} = $value;
            }
        }
        return $object;
    }
}
