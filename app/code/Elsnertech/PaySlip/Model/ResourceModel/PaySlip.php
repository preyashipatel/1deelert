<?php

namespace Elsnertech\PaySlip\Model\ResourceModel;

class PaySlip extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('payslip', 'id');   //here "elsnertech_blogimagegrid" is table name and "blogimagegrid_id" is the primary key of custom table
    }
}