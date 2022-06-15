<?php
namespace Elsnertech\Productinquiry\Model;

use Magento\Framework\Model\AbstractModel;

class Inquiry extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\Elsnertech\Productinquiry\Model\ResourceModel\Inquiry::class);
    }
}
