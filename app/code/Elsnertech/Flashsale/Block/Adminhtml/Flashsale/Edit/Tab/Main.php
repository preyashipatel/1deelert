<?php

namespace Elsnertech\Flashsale\Block\Adminhtml\Flashsale\Edit\Tab;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Elsnertech\Flashsale\Model\Flashsale;
use Elsnertech\Flashsale\Model\Flashsale\Source\Status;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

class Main extends Generic implements TabInterface
{

    /**
     * Comment of __construct function
     *
     * @param Context $context
     * @param Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Elsnertech\Flashsale\Model\FlashsaleProduct $flashsaleProductFactory
     * @param FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Elsnertech\Flashsale\Model\FlashsaleProduct $flashsaleProductFactory,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_storeManager = $storeManager;
        $this->flashsaleProductFactory = $flashsaleProductFactory;
        $this->setData('active', true);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model Flashsale */
        $model = $this->_coreRegistry->registry('flashsale');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('flashsale_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Flashsale Information')]);

        if ($model->getId()) {
            $fieldset->addField(FlashsaleInterface::ID, 'hidden', ['name' => FlashsaleInterface::ID]);
        }

        $fieldset->addField(
            'product_val',
            'hidden',
            [
                'name' => 'product_val',
            ]
        );

         $fieldset->addField(
             'productArray',
             'hidden',
             [
                'name' => json_encode($this->_getSelectedProducts()),
             ]
         );
        $fieldset->addField(
            'product_selected_value',
            'hidden',
            [
                'name' => 'product_selected_value',
            ]
        );

        $fieldset->addField(
            FlashsaleInterface::NAME,
            'text',
            [
                'name' => FlashsaleInterface::NAME,
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true
            ]
        );
        
        $fieldset->addField(
            FlashsaleInterface::START_DATE,
            'date',
            [
                'name' => FlashsaleInterface::START_DATE,
                'label' => __('Start Date'),
                'title' => __('Start Date'),
                'date_format' => 'dd-MM-yyyy',
                'required' => true
            ]
        );

        $fieldset->addField(
            FlashsaleInterface::END_DATE,
            'date',
            [
                'name' => FlashsaleInterface::END_DATE,
                'label' => __('End Date'),
                'title' => __('End Date'),
                'date_format' => 'dd-MM-yyyy',
                'required' => true
            ]
        );
        
        $fieldset->addField(
            FlashsaleInterface::STATUS,
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => FlashsaleInterface::STATUS,
                'required' => true,
                'options' => $model->getAvailableStatuses()
            ]
        );

        if (!$model->getId()) {
            $model->setData(FlashsaleInterface::STATUS, Status::ENABLED);
        }

        $this->_eventManager->dispatch('adminhtml_Flashsale_edit_tab_main_prepare_form', ['form' => $form]);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return Phrase
     */
    public function getTabLabel()
    {
        return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return Phrase
     */
    public function getTabTitle()
    {
        return __('General');
    }

    /**
     * @inheritdoc
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isHidden()
    {
        return false;
    }
    /**
     * Comment of _getSelectedProducts function
     *
     * @return void
     */
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
}
