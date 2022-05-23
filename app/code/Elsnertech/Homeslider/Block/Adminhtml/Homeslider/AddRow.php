<?php
    
namespace Elsnertech\Homeslider\Block\Adminhtml\Homeslider;

class AddRow extends \Magento\Backend\Block\Widget\Form\Container
{

    /**
     * $_coreRegistry variable
     *
     * @var [type]
     */
    protected $_coreRegistry = null;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Comment of construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'row_id';
        $this->_blockGroup = 'Elsnertech_Homeslider';
        $this->_controller = 'adminhtml_Homeslider';
        parent::_construct();
        if ($this->_isAllowedAction('Elsnertech_Homeslider::add_row')) {
            $this->buttonList->update('save', 'label', __('Save'));
        } else {
            $this->buttonList->remove('save');
        }
        $this->buttonList->remove('reset');
    }

    /**
     * Comment of getHeaderText function
     *
     * @return void
     */
    public function getHeaderText()
    {
        return __('Add RoW Data');
    }

    /**
     * Comment of _isAllowedAction function
     *
     * @param [type] $resourceId
     * @return void
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Comment of getFormActionUrl function
     *
     * @return void
     */
    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }

        return $this->getUrl('*/*/save');
    }
}
