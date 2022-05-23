<?php

namespace Elsnertech\Homeslider\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class PopularProduct extends \Magento\Catalog\Block\Product\ListProduct
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
     * Comment of __construct function
     *
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Data\Helper\PostHelper $postDataHelper
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
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
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $collection,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->_collection = $collection;
        $this->_resource = $resource;

        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }
    /**
     * Comment of getProductCollection function
     *
     * @param [type] $productIds
     * @return void
     */
    public function getProductCollection($productIds)
    {
        $collection = clone $this->_collection;
        $collection->addAttributeToSelect('*');
        $collection->addUrlRewrite();
        $collection->addFieldToFilter('entity_id', ['in' => $productIds]);
        //echo '<pre>';print_r($collection->getData());
        return $collection;
    }
    /*public function getProducts($productIds) {
        $count = $this->getProductCount();
        $collection = clone $this->_collection;
        $collection->clear()->getSelect()->reset(\Magento\Framework\DB\Select::WHERE)->reset(\Magento\Framework\DB\Select::ORDER)->reset(\Magento\Framework\DB\Select::LIMIT_COUNT)->reset(\Magento\Framework\DB\Select::LIMIT_OFFSET)->reset(\Magento\Framework\DB\Select::GROUP)->reset(\Magento\Framework\DB\Select::COLUMNS)->reset('from');
        $collection->getSelect()->join(['e' => $collection->getTable('catalog_product_entity')],'');
            $collection->addMinimalPrice()
                ->addAttributeToSelect('*')
                ->addFinalPrice()
                ->addTaxPercents()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('image')
                ->addAttributeToSelect('small_image')
                ->addAttributeToSelect('thumbnail')
                ->addAttributeToSelect($this->_catalogConfig->getProductAttributes())
                ->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
                ->addUrlRewrite()
                ->addFieldToFilter('entity_id', array('in' => $productIds));

                echo '<pre>';print_r($collection->getData());
        return $collection;
    }*/

    /**
     * Comment of getProductCount function
     *
     * @return void
     */
    public function getProductCount()
    {
        $limit = $this->getData("product_count");
        if (!$limit) {
            $limit = 10;
        }
        return $limit;
    }

    /**
     * Comment of getCategoryNameById function
     *
     * @param int $id
     * @param [type] $storeId
     * @return void
     */
    public function getCategoryNameById($id, $storeId = null)
    {
        $categoryInstance = $this->categoryRepository->get($id, $storeId);

        return $categoryInstance->getName();
    }
}
