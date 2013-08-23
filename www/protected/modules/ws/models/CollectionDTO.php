<?php
/**
 *
 * @package
 * @author     Nikolay Kondikov<nikolay.kondikov@sirma.bg>
 */
class CollectionDTO
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
    public $locked;
    /**
     * @var string
     * @soap
     */
    public $moreInfo;
    /**
     * @var integer
     * @soap
     */
    public $licenceID;
    /**
     * @var integer
     * @soap
     */
    public $lastAccessInterval;
}
