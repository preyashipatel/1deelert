<?php

namespace Elsnertech\Flashsale\Model\ResourceModel;

/**
 * Area resource
 */
class FlashsaleProduct extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('flashsale_product', 'id');
    }
}
