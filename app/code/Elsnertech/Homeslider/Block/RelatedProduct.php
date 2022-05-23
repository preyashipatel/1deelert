<?php

namespace Elsnertech\Homeslider\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Registry;

class RelatedProduct extends \Magento\Catalog\Block\Product\ListProduct
{

    /**
     * $_collection variable
     *
     * @var [type]
     */
    protected $_collection;
    /**
     * $categoryRepository variable
     *
     * @var [type]
     */
    protected $categoryRepository;
    /**
     * $_resource variable
     *
     * @var [type]
     */
    protected $_resource;
    /**
     * $_productRepository variable
     *
     * @var string
     */
    protected $_productRepository;

    /**
     * Comment of construct function
     *
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Data\Helper\PostHelper $postDataHelper
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Registry $registry
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Framework\Url\Helper\Data $urlHelper
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param array $data
     */
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
    /**
     * Comment of getProductCollection function
     *
     * @return void
     */
    public function getProductCollection()
    {
         return $this->registry->registry('current_product');
    }

    /**
     * Comment of getProductBySku function
     *
     * @param [type] $sku
     * @return void
     */
    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }
}
