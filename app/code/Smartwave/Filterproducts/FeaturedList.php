<?php

namespace Smartwave\Filterproducts\Block;

class FeaturedList extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * $_catalogProductVisibility variable
     *
     * @var [type]
     */
    protected $_catalogProductVisibility;

    /**
     * $_productCollectionFactory variable
     *
     * @var [type]
     */
    protected $_productCollectionFactory;

    /**
     * $_categoryFactory variable
     *
     * @var [type]
     */
    protected $_categoryFactory;

    /**
     * $urlHelper variable
     *
     * @var [type]
     */
    protected $urlHelper;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Framework\Url\Helper\Data $urlHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->urlHelper = $urlHelper;

        parent::__construct($context, $data);
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
        $collection = $this->_productCollectionFactory->create();
        $collection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());

        $collection = $this->_addProductAttributesAndPrices($collection)->addStoreFilter();

        if (!$category_id) {
            $category_id = $this->_storeManager->getStore()->getRootCategoryId();
        }
        $category = $this->_categoryFactory->create()->load($category_id);
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
     * Comment of getAddToCartPostParams function
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return void
     */
    public function getAddToCartPostParams(\Magento\Catalog\Model\Product $product)
    {
        $url = $this->getAddToCartUrl($product);
        return [
            'action' => $url,
            'data' => [
                'product' => $product->getEntityId(),
                \Magento\Framework\App\Action\Action::PARAM_NAME_URL_ENCODED =>
                    $this->urlHelper->getEncodedUrl($url),
            ]
        ];
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
}
