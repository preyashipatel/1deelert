<?php

namespace Elsnertech\Homeslider\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Registry;


class RelatedProduct extends \Magento\Catalog\Block\Product\ListProduct {

    protected $_collection;

    protected $categoryRepository;

    protected $_resource;
    protected $_productRepository;

    public function __construct(
            \Magento\Catalog\Block\Product\Context $context,
            \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
            \Magento\Catalog\Model\Layer\Resolver $layerResolver,
            CategoryRepositoryInterface $categoryRepository,
             Registry $registry,
             \Magento\Catalog\Model\ProductRepository $productRepository,
            \Magento\Framework\Url\Helper\Data $urlHelper,
            \Magento\Catalog\Model\ResourceModel\Product\Collection $collection,
            \Magento\Framework\App\ResourceConnection $resource,
            array $data = []
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->registry = $registry;
        $this->_productRepository = $productRepository;
        $this->_collection = $collection;
        $this->_resource = $resource;

        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }
    public function getProductCollection()
    {
         return $this->registry->registry('current_product');
    }

    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }
    

}
