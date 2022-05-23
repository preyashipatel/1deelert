<?php

namespace Elsnertech\Homeslider\Block\Adminhtml\Homeslider\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * $systemStore variable
     *
     * @var [type]
     */
    protected $systemStore;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Elsnertech\Homeslider\Model\Status $options
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Elsnertech\Homeslider\Model\Status $options,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Comment of _prepareForm function
     *
     * @return void
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form',
                            'enctype' => 'multipart/form-data',
                            'action' => $this->getData('action'),
                            'method' => 'post'
                        ]
            ]
        );
          $form->setHtmlIdPrefix('ElsnertechHomeslider_');

        if ($model->getId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Banner'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Banner'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'image_text',
            'editor',
            [
                'name' => 'image_text',
                'label' => __('Image Text'),
                'id' => 'image_text',
                'title' => __('Image Text'),
                'class' => 'required-entry',
                'wysiwyg' => true,
                'config' => $this->_wysiwygConfig->getConfig(),
                'required' => true
            ]
        );

        $fieldset->addField(
            'link',
            'text',
            [
                'name' => 'link',
                'label' => __('Link'),
                'id' => 'image_text',
                'title' => __('Link'),
                'class' => 'required-entry',
                'required' => true
            ]
        );
        $fieldset->addType('required_image', \Elsnertech\Homeslider\Block\Adminhtml\Helper\Image\Required::class);
        if ($model->getId()) {
            $fieldset->addField(
                'image',
                'image',
                [
                       'name' => 'image',
                       'label' => __('Image'),
                       'id' => 'image',
                       'title' => __('Image'),
                       'class' => 'required-entry required-file',
                       'required' => true
                   ]
            );
        } else {
            $fieldset->addField(
                'image',
                'required_image',
                [
                   'name' => 'image',
                   'label' => __('Image'),
                   'id' => 'image',
                   'title' => __('Image'),
                   'class' => 'required-entry required-file',
                   'required' => true
                ]
            )->setAfterElementHtml('
            <script>
                require([
                     "jquery",
                ], function($){
                    $(document).ready(function () {
                        if($("#ElsnertechHomeslider_image1").attr("value")){
                            $("#ElsnertechHomeslider_image1").removeClass("required-file");
                        }else{
                            $("#ElsnertechHomeslider_image1").addClass("required-file");
                        }
                        $( "#ElsnertechHomeslider_image1" ).attr( "accept",
                        "image/x-png,image/gif,image/jpeg,image/jpg,image/png" );
                    });
                  });
           </script>
        ');
        }
        $fieldset->addField(
            'store_id',
            'select',
            [
                'label' => __('Store View'),
                'title' => __('Store View'),
                'name' => 'store_id',
                'value' => $model->getStoreId(),
                'values' => $this->systemStore->getStoreValuesForForm(false, true)
            ]
        );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
