<?php
namespace Elsnertech\Homeslider\Helper;
 
 use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * $_storeManager variable
     *
     * @var [type]
     */
    public $_storeManager;

    /**
     * Comment construct function
     *
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager=$storeManager;
        parent::__construct($context);
    }
    /**
     * Comment getConfig function
     *
     * @param string $config_path
     * @return void
     */
    public function getConfig($config_path)
    {
        return $this->_scopeConfig->getValue($config_path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    /**
     * Comment getBaseUrl function
     *
     * @return void
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }
    /**
     * Comment getMediaUrl function
     *
     * @return void
     */
    public function getMediaUrl()
    {

        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
    /**
     * Comment getStoreId function
     *
     * @return void
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }
}
