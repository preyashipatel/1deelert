<?php
namespace Elsnertech\Flashsale\Block\Adminhtml\Flashsale\Edit\Tab;

use Magento\Catalog\Model\Product\Attribute\Source\Status;

class Products extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;
    private $attachModel;
    private $contactFactory;
    private $registry;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Elsnertech\Flashsale\Model\FlashsaleProduct $flashsaleProductFactory,
        \Elsnertech\Flashsale\Model\ResourceModel\Flashsale $flashsale,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->registry = $registry;
        $this->flashsale = $flashsale;
        $this->flashsaleProductFactory = $flashsaleProductFactory;
        parent::__construct($context, $backendHelper, $data);
    }
    /**
     * _construct
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('products');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('product_id')) {
            $this->setDefaultFilter(['in_product' => 1]);
        }
    }
    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    public function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_product') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
    /**
     * prepare collection
     */
    public function _prepareCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToFilter('status', Status::STATUS_ENABLED);
        $collection->addFieldToFilter('visibility', 4);
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('price');
        $collection->setFlag('has_stock_status_filter', true);
        $collection->joinField('qty',
        'cataloginventory_stock_item',
        'qty',
        'product_id=entity_id',
        '{{table}}.stock_id=1',
        'left'
        )->joinTable('cataloginventory_stock_item', 'product_id=entity_id', array('stock_status' => 'is_in_stock'))
        ->addAttributeToSelect('stock_status')
        ->addFieldToFilter('stock_status', ['eq' => 1]);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * @return $this
     */
    public function _prepareColumns()
    {
        $model = $this->attachModel;
        $this->addColumn(
            'in_product',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_product',
                'align' => 'center',
                'index' => 'entity_id',
                'values' => $this->_getSelectedProducts(),
            ]
        );
        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product ID'),
                'type' => 'number',
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'names',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('Sku'),
                'index' => 'sku',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'index' => 'price',
                'width' => '50px',
            ]
        );
        return parent::_prepareColumns();
    }
    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/products', ['_current' => true]);
    }
    /**
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }
    public function _getSelectedProducts()
    {
        $flashsaleId = $this->getRequest()->getParam('id');

        $flashsaleProductModel = $this->flashsaleProductFactory;
        $flashsaleProductCollection = $flashsaleProductModel->getCollection()
                            ->addFieldToFilter('flashsale_id', ['eq' => $flashsaleId])->addFieldToSelect('product_id');
                                   
        $oldProducts = $flashsaleProductCollection->getData();

        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        // $connection = $resource->getConnection();
        // $select = $connection->select()
        //     ->from(
        //         ['test' => $this->flashsale->getFlashsaleProductTable() ],
        //         ['product_id']
        //     )->where(
        //     'flashsale_id = :flashsale_id'
        //     );

        //   $binds = [':flashsale_id' => (int) $flashsaleId];
        //   $oldProducts = $connection->fetchAll($select, $binds);
        //   $result = array();
        //    foreach ($oldProducts as $i => $k) {
        //     $result[$k['product_id']] = '';
        //    }
         $selected = [];
        foreach ($oldProducts as $i => $k) {
            $selected[] = $k['product_id'];
        }
        if (!is_array($selected)) {
            $selected = [];
        }

        return $selected;
    }
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return true;
    }
}
