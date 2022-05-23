<?php

namespace Elsnertech\Homeslider\Model;

use Elsnertech\Homeslider\Api\Data\HomesliderInterface;

class Homeslider extends \Magento\Framework\Model\AbstractModel implements HomesliderInterface
{
    
    public const CACHE_TAG = 'homeslider';

    /**
     * $_cacheTag variable
     *
     * @var string
     */
    protected $_cacheTag = 'homeslider';

    /**
     * $_eventPrefix variable
     *
     * @var string
     */
    protected $_eventPrefix = 'homeslider';
    
    /**
     * Comment of _construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Elsnertech\Homeslider\Model\ResourceModel\Homeslider::class);
    }
    /**
     * Comment of getId function
     *
     * @return void
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }
    /**
     * Comment of setId function
     *
     * @param [type] $id
     * @return void
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
    /**
     * Comment of getImageText function
     *
     * @return void
     */
    public function getImageText()
    {
        return $this->getData(self::IMAGE_TEXT);
    }
    /**
     * Comment of setImageText function
     *
     * @param [type] $imageText
     * @return void
     */
    public function setImageText($imageText)
    {
        return $this->setData(self::IMAGE_TEXT, $imageText);
    }
    /**
     * Comment of getImage function
     *
     * @return void
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }
    /**
     * Comment of setImage function
     *
     * @param [type] $image
     * @return void
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
    /**
     * Comment of getLink function
     *
     * @return void
     */
    public function getLink()
    {
        return $this->getData(self::IMAGE, $image);
    }
    /**
     * Comment of setLink function
     *
     * @param [type] $link
     * @return void
     */
    public function setLink($link)
    {
        return $this->setData(self::I_LINK, $link);
    }
}
