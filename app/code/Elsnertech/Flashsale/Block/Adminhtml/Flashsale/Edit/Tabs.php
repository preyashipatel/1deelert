<?php

namespace Elsnertech\Flashsale\Block\Adminhtml\Flashsale\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{
    /**
     * Custructor Method
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('Flashsale_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Flashsale Information'));
    }
    /**
     * Comment of _prepareLayout function
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->addTabAfter('product', [
            'label' => __('Products'),
            'url' => $this->getUrl('*/*/products', ['_current' => true]),
            'class' => 'ajax'
        ], 'main');

        return $this;
    }
}
