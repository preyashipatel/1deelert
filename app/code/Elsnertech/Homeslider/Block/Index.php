<?php

namespace Elsnertech\Homeslider\Block;
 
use Magento\Framework\App\Filesystem\DirectoryList;
 
class Index extends \Magento\Framework\View\Element\Template
{
     /**
      * $_filesystem variable
      *
      * @var [type]
      */
     protected $_filesystem;
     /**
      * $_storemanager variable
      *
      * @var [type]
      */
     protected $_storemanager;

     /**
      * Comment of __construct function
      *
      * @param \Magento\Framework\View\Element\Template\Context $context
      * @param \Elsnertech\Homeslider\Model\HomesliderFactory $HomesliderFactory
      * @param \Magento\Store\Model\StoreManagerInterface $storemanager
      */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Elsnertech\Homeslider\Model\HomesliderFactory $HomesliderFactory,
        \Magento\Store\Model\StoreManagerInterface $storemanager
    ) {
         parent::__construct($context);
         $this->_HomesliderFactory = $HomesliderFactory;
         $this->_storemanager = $storemanager;
    }

    /**
     * Comment of getBaseUrl function
     *
     * @return void
     */
    public function getBaseUrl()
    {
        return $this->_storemanager->getStore()
               ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * Comment of getResult function
     *
     * @return void
     */
    public function getResult()
    {
         $Homeslider = $this->_HomesliderFactory->create();
         $collection = $Homeslider->getCollection();
         return $collection;
    }
}
