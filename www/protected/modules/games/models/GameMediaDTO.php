<?php
/**
 *
 * @package
 */
class GameMediaDTO
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var
     */
    public $mimeType;

    /**
     * @var string
     */
    public $imageFullSize;
    /**
     * @var string
     */
    public $imageScaled;
    /**
     * @var string
     */
    public $thumbnail;

    /**
     * @var string
     */
    public $videoWebm;
    /**
     * @var string
     */
    public $videoMp4;

    /**
     * @var string
     */
    public $audioMp3;
    /**
     * @var string
     */
    public $audioOgg;

    /**
     * @var GameLicenceDTO
     */
    public $licence;

    /**
     * @var string
     */
    public $collection;
    /**
     * @var string
     */
    public $institution;
}
