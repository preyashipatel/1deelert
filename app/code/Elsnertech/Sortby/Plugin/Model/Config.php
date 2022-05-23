<?php

namespace Elsnertech\Sortby\Plugin\Model;

use Magento\Store\Model\StoreManagerInterface;

class Config
{
    /**
     * $_storeManager variable
     *
     * @var [type]
     */
    protected $_storeManager;

    /**
     * Comment of __construct function
     *
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    /**
     * Comment of afterGetAttributeUsedForSortByArray function
     *
     * @param \Magento\Catalog\Model\Config $catalogConfig
     * @param [type] $options
     * @return void
     */
    public function afterGetAttributeUsedForSortByArray(\Magento\Catalog\Model\Config $catalogConfig, $options)
    {
        $customOption['newest_product'] = __('Newest Product');
        $options = array_merge($customOption, $options);
        return $options;
    }
}
