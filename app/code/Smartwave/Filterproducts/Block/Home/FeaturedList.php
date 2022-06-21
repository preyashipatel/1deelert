<?php

namespace Smartwave\Filterproducts\Block\Home;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class FeaturedList extends \Magento\Catalog\Block\Product\ListProduct
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
     * Comment of _getProductCollection function
     *
     * @return void
     */
    protected function _getProductCollection()
    {
        return $this->getProducts();
    }

    /**
     * Comment of getProducts function
     *
     * @return void
     */
    public function getProducts()
    {
        $count = $this->getProductCount();
        $category_id = $this->getData("category_id");
        $collection = clone $this->_collection;
        $collection->clear()
        ->getSelect()
        ->reset(\Magento\Framework\DB\Select::WHERE)
        ->reset(\Magento\Framework\DB\Select::ORDER)
        ->reset(\Magento\Framework\DB\Select::LIMIT_COUNT)
        ->reset(\Magento\Framework\DB\Select::LIMIT_OFFSET)
        ->reset(\Magento\Framework\DB\Select::GROUP);

        if (!$category_id) {
            $category_id = $this->_storeManager->getStore()->getRootCategoryId();
        }
        $category = $this->categoryRepository->get($category_id);
        if (isset($category) && $category) {
            $collection->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('image')
                ->addAttributeToSelect('small_image')
                ->addAttributeToSelect('thumbnail')
                ->addAttributeToSelect($this->_catalogConfig->getProductAttributes())
                ->addUrlRewrite()
                ->addAttributeToFilter('sw_featured', 1, 'left')
                ->addCategoryFilter($category);
        } else {
            $collection->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('image')
                ->addAttributeToSelect('small_image')
                ->addAttributeToSelect('thumbnail')
                ->addAttributeToSelect($this->_catalogConfig->getProductAttributes())
                ->addUrlRewrite()
                ->addAttributeToFilter('sw_featured', 1, 'left');
        }

        $collection->getSelect()
            ->order('rand()')
            ->limit($count);

        return $collection;
    }

    /**
     * Comment of getLoadedProductCollection function
     *
     * @return void
     */
    public function getLoadedProductCollection()
    {
        return $this->getProducts();
    }

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
}
