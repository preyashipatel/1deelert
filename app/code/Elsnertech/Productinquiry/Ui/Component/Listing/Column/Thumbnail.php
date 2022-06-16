<?php

namespace Elsnertech\Productinquiry\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;  
use Magento\Framework\View\Element\UiComponent\ContextInterface; 

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column 
{
    /**
     * Undocumented function
     *
     * @param ContextInterface $context
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context,$uiComponentFactory, $components, $data);
        $this->imageHelper = $imageHelper;
        $this->productRepository = $productRepository;
    }

    /**
     * Undocumented function
     *
     * @param array $dataSource
     * @return void
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $product = new \Magento\Framework\DataObject($item);
                $_product = $this->productRepository->get($product['productsku']);
                $imagewidth=200;
                $imageheight=200;
                $image_url = $this->imageHelper->init($_product, 'small_image')->setImageFile($_product->getSmallImage())->resize($imagewidth, $imageheight)->getUrl();
                $item[$fieldName . '_src'] = $image_url;
            }
        }
        return $dataSource;
    }
}
