<?php
/**
 *
 * @package
 * @author     Nikolay Kondikov<nikolay.kondikov@sirma.bg>
 */
class MediaDTO
{
    /**
     * @var integer
     * @soap
     */
    public $id;
    /**
     * @var string
     * @soap
     */
    public $name;
    /**
     * @var integer
     * @soap
     */
    public $size;
    /**
     * @var string
     * @soap
     */
    public $mimeType;
    /**
     * @var string
     * @soap
     */
    public $batchId;
    /**
     * @var integer
     * @soap
     */
    public $locked;
}
