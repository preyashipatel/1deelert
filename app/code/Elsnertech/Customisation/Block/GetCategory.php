<?php

namespace Elsnertech\Customisation\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class GetCategory extends \Magento\Framework\View\Element\Template
{
    /**
     * $_categoryCollectionFactory variable
     *
     * @var string
     */
    protected $_categoryCollectionFactory;
   
    /**
     * $_productRepository variable
     *
     * @var string
     */

    protected $_productRepository;
    /**
     * $_registry variable
     *
     * @var string
     */
    protected $_registry;

    /**
     * Description of construct here.
     *
     * @param Context           $context
     * @param CollectionFactory $CollectionFactory
     * @param ProductRepository $productRepository
     * @param Registry          $registry
     * @param int               $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $CollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
            $this->_categoryCollectionFactory = $CollectionFactory;
            $this->_productRepository = $productRepository;
            $this->_registry = $registry;
            parent::__construct($context, $data);
    }
    
    /**
     * Get category collection
     *
     * @param bool $isActive
     * @param bool|int $level
     * @param bool|string $sortBy
     * @param bool|int $pageSize
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection or array
     */
    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        
        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }
                
        // select categories of certain level
        if ($level) {
            $collection->addLevelFilter($level);
        }
        
        // sort categories by some value
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }
        
        // select certain number of categories
        if ($pageSize) {
            $collection->setPageSize($pageSize);
        }
        
        return $collection;
    }
    
     /**
      * Description of getProductById here.
      *
      * @param int           $id
      */
    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }
    
    /**
     * Description of getCurrentProduct here.
     *
     * @param
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
}
