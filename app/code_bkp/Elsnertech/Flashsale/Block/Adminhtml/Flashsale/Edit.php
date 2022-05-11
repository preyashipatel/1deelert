<?php

namespace Elsnertech\Flashsale\Block\Adminhtml\Flashsale;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Registry data
     *
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Custructor method
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Elsnertech_Flashsale';
        $this->_controller = 'adminhtml_flashsale';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Flashsale'));
        $this->buttonList->update('delete', 'label', __('Delete Flashsale'));

        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']],
                ]
            ],
            -100
        );
    }

    /**
     * Get edit form container header text
     *
     * @return Phrase
     */
    public function getHeaderText()
    {
        if ($this->coreRegistry->registry('flashsale')->getId()) {
            return __("Edit Flashsale '%1'", $this->escapeHtml($this->coreRegistry->registry('flashsale')->getName()));
        } else {
            return __('New Flashsale');
        }
    }
}
