<?php
namespace Smartwave\Dailydeals\Model\ResourceModel\Dailydeal;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * $_idFieldName variable
     *
     * @var string
     */
    protected $_idFieldName = 'dailydeal_id';

    /**
     * $_eventPrefix variable
     *
     * @var string
     */
    protected $_eventPrefix = 'sw_dailydeals_dailydeal_collection';

    /**
     * $_eventObject variable
     *
     * @var string
     */
    protected $_eventObject = 'dailydeal_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Smartwave\Dailydeals\Model\Dailydeal::class,
            \Smartwave\Dailydeals\Model\ResourceModel\Dailydeal::class
        );
    }

    /**
     * Get SQL for get record count.
     *
     * @return \Magento\Framework\DB\Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(\Magento\Framework\DB\Select::GROUP);
        return $countSelect;
    }
    /**
     * Comment of _toOptionArray function
     *
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     */
    protected function _toOptionArray($valueField = 'dailydeal_id', $labelField = 'sw_product_sku', $additional = [])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
}
