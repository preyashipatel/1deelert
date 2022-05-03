<?php
namespace Elsnertech\Flashsale\Model\ResourceModel\FlashsaleProduct;

/**
 * FlashsaleProduct Collection
 *
 * @author Elsnertech
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'id';
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Elsnertech\Flashsale\Model\FlashsaleProduct', 'Elsnertech\Flashsale\Model\ResourceModel\FlashsaleProduct');
    }
}
