<?php

namespace Elsnertech\Homeslider\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Editor extends Field
{
    /**
     * $_wysiwygConfig variable
     *
     * @var [type]
     */
    protected $_wysiwygConfig;

    /**
     * Editor constructor.
     *
     * @param Context $context
     * @param WysiwygConfig $wysiwygConfig
     * @param array $data
     * @codeCoverageIgnore
     */
    public function __construct(
        Context $context,
        WysiwygConfig $wysiwygConfig,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $data);
    }

    /**
     * Comment of _getElementHtml function
     *
     * @param AbstractElement $element
     * @return void
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        // set wysiwyg for element
        $element->setWysiwyg(true);

        // set configuration values
        $element->setConfig($this->_wysiwygConfig->getConfig());

        return parent::_getElementHtml($element);
    }
}
