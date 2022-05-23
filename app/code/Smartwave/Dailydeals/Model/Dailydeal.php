<?php
namespace Smartwave\Dailydeals\Model;

class Dailydeal extends \Magento\Framework\Model\AbstractModel
{
    public const CACHE_TAG = 'sw_dailydeals_dailydeal';

    /**
     * $_cacheTag variable
     *
     * @var string
     */
    protected $_cacheTag = 'sw_dailydeals_dailydeal';

    /**
     * $_eventPrefix variable
     *
     * @var string
     */
    protected $_eventPrefix = 'sw_dailydeals_dailydeal';
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Smartwave\Dailydeals\Model\ResourceModel\Dailydeal::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get entity default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
