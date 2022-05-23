<?php
namespace Elsnertech\Homeslider\Block\Adminhtml\Form\Field;

class MyFileRenderer extends \Magento\Framework\View\Element\AbstractBlock
{
    /**
     * @inheritdoc
     */
    protected function _toHtml()
    {
        $html = '<input type="file" name="' . $this->getInputName() . '" id="' . $this->getInputId() . '" />';
        return $html;
    }
}
