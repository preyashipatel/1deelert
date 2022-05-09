<?php
namespace Elsnertech\Customisation\Helper;
 
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public $_storeManager;

    protected $_currency;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency, 
        Registry $registry
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager=$storeManager;
        $this->_registry = $registry;
        $this->_currency = $currency;
        parent::__construct($context);
    }
    
    public function getConfig($config_path) {
        return $this->_scopeConfig->getValue($config_path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getBaseUrl() {
        return $this->_storeManager->getStore()->getBaseUrl();
    }
    public function getMediaUrl() {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getCurrentProduct() {        
        return $this->_registry->registry('current_product')->getsku();
    } 

    public function getCurrentCategory() {        
        $category = $this->_registry->registry('current_category');
        return $category->getProductCount();
    } 
    public function getCurrentCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    } 
}