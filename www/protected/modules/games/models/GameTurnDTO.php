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
     * Total score
     * @var integer
     */
    public $score;
    /**
     * Total score of opponent
     * @var integer
     */
    public $opponentScore;
    /**
     * turn tags
     * @var GameTagDTO[]
     */
    public $tags;

    /**
     * opponent turn tags
     * @var GameTagDTO[]
     */
    public $opponentTags;
    /**
     * Turn images to show
     * @var GameMediaDTO[]
     */
    public $media;
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
