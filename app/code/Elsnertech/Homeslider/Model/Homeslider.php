<?php

namespace Elsnertech\Homeslider\Model;

use Elsnertech\Homeslider\Api\Data\HomesliderInterface;

class Homeslider extends \Magento\Framework\Model\AbstractModel implements HomesliderInterface
{
    
    const CACHE_TAG = 'homeslider';

    protected $_cacheTag = 'homeslider';

    protected $_eventPrefix = 'homeslider';

    protected function _construct()
    {
        $this->_init('Elsnertech\Homeslider\Model\ResourceModel\Homeslider');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function getImageText()
    {
        return $this->getData(self::Image_Text);
    }
    
    public function setImageText($imageText)
    {
        return $this->setData(self::Image_Text, $imageText);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
	public function getLink()
    {
        return $this->getData(self::IMAGE, $image);
    }
	public function setLink($link)
    {
        return $this->setData(self::I_LINK, $link);
    }
}
