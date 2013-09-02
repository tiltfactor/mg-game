<?php
/**
 *
 * @package
 */
class GameTagDTO
{
    /**
     * @var string
     */
    public $tag;
    /**
     * set if submitted tag differs from registered tag (3 dogs -> three dogs)
     * @var string
     */
    public $original;
    /**
     * @var integer
     */
    public $score;
    /**
     * @var integer
     */
    public $weight;

    /**
     * @var integer
     */
    public $mediaId;
}
