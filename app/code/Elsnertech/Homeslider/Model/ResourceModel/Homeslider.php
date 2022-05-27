<?php

namespace Elsnertech\Homeslider\Model\ResourceModel;

class Homeslider extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * $_idFieldName variable
     *
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * $_date variable
     *
     * @var [type]
     */
    protected $_date;

    /**
     * Commant of __construct function
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param [type] $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }

    /**
     * Comment of  function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('homeslider', 'id');
    }
}
