<?php
namespace Elsnertech\Customisation\Helper;
 
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public $_storeManager;

    protected $_currency;

    private $_categoryFactory;

    protected $_productCollectionFactory;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency, 
        Registry $registry,
        CategoryFactory $categoryfactory,
        CollectionFactory $productCollectionFactory
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager=$storeManager;
        $this->_registry = $registry;
        $this->_currency = $currency;
        $this->_categoryFactory = $categoryfactory;
        $this->_productCollectionFactory = $productCollectionFactory;
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
        //print_r($category);exit;
        if($category):
            $categoryId = $category->getId();
            $category_product_collection = $this->_categoryFactory->create()->load($categoryId);
            $collection = $this->_productCollectionFactory->create();
            $collection->addAttributeToSelect('*');
            $collection->addFieldToFilter('visibility', 4);
            $collection->addCategoriesFilter(['in' => $categoryId]);
            $collection->addAttributeToFilter('status', Status::STATUS_ENABLED);
            return count($collection);
        else :
            return 0;
        endif;

    } 
    public function getCurrentCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    } 
}