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
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
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
