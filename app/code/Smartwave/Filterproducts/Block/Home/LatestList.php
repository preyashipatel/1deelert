<?php

namespace Smartwave\Filterproducts\Block\Home;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class LatestList extends \Magento\Catalog\Block\Product\ListProduct
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
                ->addCategoryFilter($category)
                ->addAttributeToSort('created_at', 'desc');
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
                ->addAttributeToSort('created_at', 'desc');
        }

        $collection->getSelect()
                ->order('created_at', 'desc')
                ->limit($count);

        return $collection;
    }
    /**
     * Total number of products in current category.
     *
     * @return int
     */
    public function getTotalNumCount()
    {
        return $this->getProductCount();;
    }

    /**
     * Total number of products in current category.
     *
     * @return int
     */
    public function getTotalNum()
    {
        return $this->getProducts()->getSize();
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

    /**
     * Comment of _prepareLayout function
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('products'));
        if ($this->_getProductCollection()) {
            $toolbar = $this->getLayout()
                   ->createBlock(
                       'Magento\Catalog\Block\Product\ProductList\Toolbar',
                       'product_list_toolbar'
                   )
                ->setTemplate('Magento_Catalog::product/list/toolbar.phtml')
                ->setCollection($this->_getProductCollection());

            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'AllProduct.product.pager'
            )->setAvailableLimit([3=>3,6=>6,9=>9])->setShowPerPage(true)->setCollection(
                $this->_getProductCollection()
            );
            $this->setChild('pager', $pager);
            $this->setChild('toolbar', $toolbar);
            $this->_getProductCollection()->load();
        }
        return $this;
    }
    /**
     * Comment of getPagerHtml function
     *
     * @return void
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    /**
     * Retrieve additional blocks html
     *
     * @return string
     */
    public function getAdditionalHtml()
    {
        return $this->getChildHtml('additional');
    }
    /**
     * Comment of getToolbarHtml function
     *
     * @return void
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }
    /**
     * Comment of getMode function
     *
     * @return void
     */
    public function getMode()
    {
        return $this->getChildBlock('toolbar')->getCurrentMode();
    }
}
