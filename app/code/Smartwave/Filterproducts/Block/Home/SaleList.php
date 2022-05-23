<?php

namespace Smartwave\Filterproducts\Block\Home;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class SaleList extends \Magento\Catalog\Block\Product\ListProduct
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
        $now = date('Y-m-d');
        if (isset($category) && $category) {
            $collection->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('image')
                ->addAttributeToSelect('small_image')
                ->addAttributeToSelect('thumbnail')
                ->addAttributeToSelect('special_from_date')
                ->addAttributeToSelect('special_to_date')
                ->addAttributeToFilter('special_price', ['neq' => ''])
                ->addCategoryFilter($category)
                ->addAttributeToFilter(
                    'special_from_date',
                    ['date' => true, 'to' => $this->getEndOfDayDate()],
                    'left'
                )
                ->addAttributeToFilter(
                    'special_to_date',
                    [
                        'or' => [
                            0 => ['date' => true, 'from' => $this->getStartOfDayDate()],
                            1 => ['is' => new \Zend_Db_Expr('null')],
                        ]
                    ],
                    'left'
                )
                ->addAttributeToSort(
                    'news_from_date',
                    'desc'
                )
                ->addStoreFilter($this->getStoreId())
                ->setCurPage(1);
        } else {
            $collection->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('image')
                ->addAttributeToSelect('small_image')
                ->addAttributeToSelect('thumbnail')
                ->addAttributeToFilter('special_price', ['neq' => ''])
                ->addAttributeToSelect('special_from_date')
                ->addAttributeToSelect('special_to_date')
                ->addAttributeToFilter(
                    'special_from_date',
                    ['date' => true, 'to' => $this->getEndOfDayDate()],
                    'left'
                )
                ->addAttributeToFilter(
                    'special_to_date',
                    [
                        'or' => [
                            0 => ['date' => true, 'from' => $this->getStartOfDayDate()],
                            1 => ['is' => new \Zend_Db_Expr('null')],
                        ]
                    ],
                    'left'
                )
                ->addAttributeToSort(
                    'news_from_date',
                    'desc'
                )
                ->addStoreFilter($this->getStoreId())
                ->setCurPage(1);
        }

        $collection->getSelect()
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
            return $limit;
        }
    }

    /**
     * Comment of getStartOfDayDate function
     *
     * @return void
     */
    public function getStartOfDayDate()
    {
        return $this->_localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
    }

    /**
     * Comment of getEndOfDayDate function
     *
     * @return void
     */
    public function getEndOfDayDate()
    {
        return $this->_localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');
    }

    /**
     * Comment of getStoreId function
     *
     * @return void
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }
}
