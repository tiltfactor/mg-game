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

    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $tag_id;

    /**
     * array(1) {
     *      [media_id]=>
     *      array(1) {
     *           ["tag"]=>
     *              array(4) {
     *                   ["tag"]=>""
     *                   ["weight"]=>int(1)
     *                   ["type"]=>string
     *                   ["tag_id"]=>int(0)
     *          }
     *      }
     * }
     * @static
     * @param array $tags
     * @return GameTagDTO[]
     */
    public static function createFromArray($tags)
    {
        $tagsDto = array();
        foreach ($tags as $mediaId => $tag) {
            foreach ($tag as $key => $value) {
                $t = new GameTagDTO();
                $t->mediaId = $mediaId;
                $t->tag = $value['tag'];
                $t->score = $value['score'];
                $t->weight = $value['weight'];
                $t->type = $value['type'];
                $t->mediaId = $value['mediaId'];
                $t->tag_id = $value['tag_id'];
                array_push($tagsDto, $t);
                break;
            }
        }
        return $tagsDto;
    }

    /**
     * @static
     * @param GameTagDTO[] $tags
     * @return array
     */
    public static function convertToArray($tags)
    {
        $tagsArr = array();
        foreach ($tags as $tag) {
            $tagsArr[$tag->mediaId] = array();
            $tagsArr[$tag->mediaId][$tag->tag] = array();
            $tagsArr[$tag->mediaId][$tag->tag]["tag"] = $tag->tag;
            $tagsArr[$tag->mediaId][$tag->tag]["score"] = $tag->score;
            $tagsArr[$tag->mediaId][$tag->tag]["weight"] = $tag->weight;
            $tagsArr[$tag->mediaId][$tag->tag]["type"] = $tag->type;
            $tagsArr[$tag->mediaId][$tag->tag]["mediaId"] = $tag->mediaId;
            $tagsArr[$tag->mediaId][$tag->tag]["tag_id"] = $tag->tag_id;
        }
        return $tagsArr;
    }

    /**
     * @static
     * @param string $json
     * @return GameTagDTO
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

    /**
     * @static
     * @param string $json
     * @return GameTagDTO[]
     */
    static public function createTagsFromJson($json)
    {
        $result = array();
        $tags = json_decode($json);
        if (is_array($tags)) {
            foreach($tags as $tag){
                if (is_object($tag)) {
                    $object = new self();
                    foreach ($tag as $key => $value) {
                        $object->{$key} = $value;
                    }
                    array_push($result,$object);
                }
            }
        }
        return $result;
    }
}
