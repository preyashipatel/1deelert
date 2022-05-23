<?php
namespace Elsnertech\Flashsale\Model\ResourceModel\Flashsale;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Elsnertech\Flashsale\Model\Flashsale;
use Elsnertech\Flashsale\Model\ResourceModel\Flashsale as FlashsaleResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
   
    /**
     * $_idFieldName variable
     *
     * @var [type]
     */
    protected $_idFieldName = FlashsaleInterface::ID;
    /**
     * Comment of _construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Flashsale::class, FlashsaleResource::class);
    }
}
