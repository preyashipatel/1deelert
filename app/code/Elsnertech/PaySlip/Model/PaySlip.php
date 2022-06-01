<?php

namespace Elsnertech\PaySlip\Model;

use Magento\Framework\Model\AbstractModel;

class PaySlip extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Elsnertech\PaySlip\Model\ResourceModel\PaySlip');
    }
}