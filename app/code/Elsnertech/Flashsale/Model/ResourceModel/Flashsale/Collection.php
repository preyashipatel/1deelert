<?php
namespace Elsnertech\Flashsale\Model\ResourceModel\Flashsale;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Elsnertech\Flashsale\Model\Flashsale;
use Elsnertech\Flashsale\Model\ResourceModel\Flashsale as FlashsaleResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
   
    protected $_idFieldName = FlashsaleInterface::ID;
    protected function _construct()
    {
        $this->_init(Flashsale::class, FlashsaleResource::class);
    }
}
