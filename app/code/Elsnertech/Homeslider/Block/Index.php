<?php

namespace Elsnertech\Homeslider\Block;
 
use Magento\Framework\App\Filesystem\DirectoryList;
 
class Index extends \Magento\Framework\View\Element\Template
{
     protected $_filesystem;
     protected $_storemanager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Elsnertech\Homeslider\Model\HomesliderFactory $HomesliderFactory,
        \Magento\Store\Model\StoreManagerInterface $storemanager
    ) {
         parent::__construct($context);
         $this->_HomesliderFactory = $HomesliderFactory;
         $this->_storemanager = $storemanager;
    }

    public function getBaseUrl()
    {
        return $this->_storemanager->getStore()
               ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getResult()
    {
         $Homeslider = $this->_HomesliderFactory->create();
         $collection = $Homeslider->getCollection();
         return $collection;
    }
}
