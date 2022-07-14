<?php

namespace Elsnertech\Flashsale\Block;

use Magento\Framework\App\Action\Action;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\App\ObjectManager;

class Flashsale extends \Magento\Catalog\Block\Product\AbstractProduct implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Catalog\Block\Product\ListProduct
     */
    protected $listProductBlock;

    /**
     * @var \Magento\Review\Model\ReviewFactory
     */
    protected $reviewFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $catalogProductVisibility;
    /**
     * @var $rendererListBlock
     */
    private $rendererListBlock;
    /**
     * @var $layoutFactory
     */
    private $layoutFactory;
    /**
     * Construct
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param  \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param  \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param  \Magento\Catalog\Block\Product\ListProduct $listProductBlock
     * @param  \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param  \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param  \Elsnertech\Flashsale\Model\FlashsaleProduct $flashsaleProductFactory
     * @param  \Elsnertech\Flashsale\Model\FlashsaleFactory $flashsaleFactory
     * @param array $data
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory = null
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Block\Product\ListProduct $listProductBlock,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Elsnertech\Flashsale\Model\FlashsaleProduct $flashsaleProductFactory,
        \Elsnertech\Flashsale\Model\FlashsaleFactory $flashsaleFactory,
        array $data = [],
        \Magento\Framework\View\LayoutFactory $layoutFactory = null
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->storeManager = $storeManager;
        $this->listProductBlock = $listProductBlock;
        $this->reviewFactory = $reviewFactory;
        $this->flashsaleFactory = $flashsaleFactory;
        $this->flashsaleProductFactory = $flashsaleProductFactory;
        $this->catalogProductVisibility = $catalogProductVisibility;
        $this->layoutFactory = $layoutFactory ?: ObjectManager::getInstance()->get(LayoutFactory::class);
        parent::__construct($context, $data);
    }

    /**
     * Get Flashsale Enable Product
     *
     * @return FlashsaleProducts items
     */
    public function getFlashsaleProducts()
    {
        return $this->getProductCollection()->getItems();
    }

    /**
     * Get Flashsale Enable Product Name
     *
     * @return FlashsaleProducts items
     */
    public function getFlashsaleProductsName()
    {
        $flashsaleModel = $this->flashsaleFactory->create()->getCollection();
        if (count($flashsaleModel) != 0) {
            $flashsaleName = $flashsaleModel->getData()[0]['name'];
                    $flashsaleProductModel = $this->flashsaleProductFactory;
            return $flashsaleName;
        } else {
            return $flashsaleName = '';
        }
    }
    /**
     * Get Flashsale Enable Details
     *
     * @return FlashsaleDetails
     */
    public function getFlashsaleDetails()
    {
        $flashsaleModel = $this->flashsaleFactory->create()->getCollection();
        $flashsaleDetails = [];
        if (count($flashsaleModel) != 0) {
            $flashsaleDetails['name'] = $flashsaleModel->getData()[0]['name'];
            $flashsaleDetails['start_date'] = $flashsaleModel->getData()[0]['start_date'];
            $flashsaleDetails['end_date'] = $flashsaleModel->getData()[0]['end_date'];
        }
        return $flashsaleDetails;
    }

    /**
     * Get Product Collection
     *
     * @return Catalog Products Collection
     */
    public function getProductCollection()
    {
        $now = new \DateTime();
        $flashsaleModel = $this->flashsaleFactory->create()->getCollection()
                                ->addFieldToFilter('start_date', ['lteq' => $now->format('Y-m-d H:i:s')])
                                ->addFieldToFilter('end_date', ['gteq' => $now->format('Y-m-d H:i:s')]);
        if (count($flashsaleModel) != 0) {
            $flashsaleId = $flashsaleModel->getData()[0]['id'];
                    $flashsaleProductModel = $this->flashsaleProductFactory;
            $flashsaleProductCollection = $flashsaleProductModel->getCollection()
                                ->addFieldToFilter(
                                    'flashsale_id',
                                    ['eq' => $flashsaleId]
                                )->addFieldToSelect('product_id');
            $oldProducts = $flashsaleProductCollection->getData();
            $flashproducts = [];
            foreach ($oldProducts as $data) {
                foreach ($data as $d) {
                     array_push($flashproducts, $d);
                }
            }
            $collection = $this->productCollectionFactory->create();
            $collection->addMinimalPrice()
                        ->addFinalPrice()
                        ->addTaxPercents()
                        ->addAttributeToSelect('*')
                        ->addUrlRewrite()
                        ->addFieldToFilter('entity_id', ['in' => $flashproducts]);
        } else {
            return $flashsaleModel;
        }
        return $collection;
    }

    /**
     * Get product Image
     *
     * @param int $getProductImage
     * @return Product Image full path
     */
    public function getProductImage($getProductImage)
    {
        $placeholderImageUrl = '';
        $imageHelper = \Magento\Framework\App\ObjectManager::getInstance()->get(\Magento\Catalog\Helper\Image::class);
        $placeholderImageUrl = $imageHelper->getDefaultPlaceholderUrl('image');
        if (empty($getProductImage) || $getProductImage == 'no_selection') {
            return $placeholderImageUrl;
        } else {
            return $this->getMediaBaseUrl() . $getProductImage;
        }
    }

    /**
     * Get media base Url
     *
     * @return Store Media URL
     */
    public function getMediaBaseUrl()
    {
        return $this->storeManager
                    ->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'catalog/product';
    }

    /**
     * Get add to cart post parameters
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return AddToCartPostParams
     */
    public function getAddToCartPostParameters($product)
    {
        return $this->listProductBlock->getAddToCartPostParams($product);
    }

    /**
     * Get Rating Summary
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return Product Review Ratings
     */
    public function getRatingSummary($product)
    {
        $this->reviewFactory->create()->getEntitySummary($product, $this->storeManager->getStore()->getId());
        $ratingSummary = $product->getRatingSummary()->getRatingSummary();
        return $ratingSummary;
    }

    /**
     * Get Reviews count
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return Product Review count
     */
    public function getReviewsCount($product)
    {
        $_reviewCount = $product->getRatingSummary()->getReviewsCount();
        return $_reviewCount;
    }

    /**
     * Get price
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return Product Price with HTML
     */
    public function getPrice(\Magento\Catalog\Model\Product $product)
    {
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');
        if (!$priceRender) {
            $priceRender = $this->getLayout()->createBlock(
                \Magento\Framework\Pricing\Render::class,
                'product.price.render.default',
                ['data' => ['price_render_handle' => 'catalog_product_prices']]
            );
        }

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                [
                    'display_minimal_price'  => true,
                    'use_link_for_as_low_as' => true,
                    'zone' => \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST
                ]
            );
        }

        return $price;
    }

    /**
     * Get Cart param name url encoded
     *
     * @return Store Media URL
     */
    public function getCartParamNameURLEncoded()
    {
        return Action::PARAM_NAME_URL_ENCODED;
    }

     /**
      * For rendering product swatches layout
      */
    protected function getDetailsRendererList()
    {
        if (empty($this->rendererListBlock)) {
            /**
             * Comment
             *
             * @var LayoutInterface $layout
             */
            $layout = $this->layoutFactory->create(['cacheable' => false]);
            $layout->getUpdate()->addHandle('catalog_widget_product_list')->load();
            $layout->generateXml();
            $layout->generateElements();

            $this->rendererListBlock = $layout->getBlock('category.product.type.widget.details.renderers');
        }
        return $this->rendererListBlock;
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
        if ($this->getProductCollection()) {
            $toolbar = $this->getLayout()
                   ->createBlock(
                       \Magento\Catalog\Block\Product\ProductList\Toolbar::class,
                       'product_list_toolbar_grid'
                   )
                ->setTemplate('Magento_Catalog::product/list/toolbar.phtml')
                ->setCollection($this->getProductCollection());

            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'flashProduct.product.pager'
            )->setAvailableLimit([3=>3,6=>6,9=>9])->setShowPerPage(true)->setCollection(
                $this->getProductCollection()
            );
            $this->setChild('pager', $pager);
            $this->setChild('toolbar', $toolbar);
            $this->getProductCollection()->load();
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
     * Comment  of getMode function
     *
     * @return void
     */
    public function getMode()
    {
        return $this->getChildBlock('toolbar')->getCurrentMode();
    }
}
