<?php

/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Elsnertech\CustomAddressAttr\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

/**
 * Class BillingLayoutProcessor
 * @package Elsnertech\CustomAddressAttr\Plugin\Checkout
 */
class BillingLayoutProcessor
{
    /**
     * @param LayoutProcessor $subject
     * @param array $result
     * @return array|mixed
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $result
    ) {

        $paymentForms = $result['components']['checkout']['children']['steps']['children']
        ['billing-step']['children']['payment']['children']
        ['payments-list']['children'];

        $paymentMethodForms = array_keys($paymentForms);

        if (!isset($paymentMethodForms)) {
            return $result;
        }

        foreach ($paymentMethodForms as $paymentMethodForm) {
            $paymentMethodCode = str_replace('-form', '', $paymentMethodForm, $paymentMethodCode);
            $result = $this->filedWithDistric($result, 'distric', $paymentMethodForm, $paymentMethodCode);
            $result = $this->filedWithSubDistric($result, 'sub_distric', $paymentMethodForm, $paymentMethodCode);
        }

        return $result;
    }

    /**
     * Select company or person
     * @param $result
     * @param $fieldName
     * @param $paymentMethodForm
     * @param $paymentMethodCode
     * @return array
     */
    public function filedWithDistric($result, $fieldName, $paymentMethodForm, $paymentMethodCode)
    {

        $field = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'billingAddress' . $paymentMethodCode . '.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'billingAddress' . $paymentMethodCode . '.custom_attributes.' . $fieldName,
            'label' => __('Distric'),
            'provider' => 'checkoutProvider',
            'sortOrder' => 101,
            'validation' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'id' => $fieldName
        ];

        $result
        ['components']
        ['checkout']
        ['children']
        ['steps']
        ['children']
        ['billing-step']
        ['children']
        ['payment']
        ['children']
        ['payments-list']
        ['children']
        [$paymentMethodForm]
        ['children']
        ['form-fields']
        ['children']
        [$fieldName] = $field;

        return $result;
    }

    /**
     * Select company or person
     * @param $result
     * @param $fieldName
     * @param $paymentMethodForm
     * @param $paymentMethodCode
     * @return array
     */
    public function filedWithSubDistric($result, $fieldName, $paymentMethodForm, $paymentMethodCode)
    {

        $field = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'billingAddress' . $paymentMethodCode . '.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'billingAddress' . $paymentMethodCode . '.custom_attributes.' . $fieldName,
            'label' => __('Sub Distric'),
            'provider' => 'checkoutProvider',
            'sortOrder' => 102,
            'validation' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'id' => $fieldName
        ];

        $result
        ['components']
        ['checkout']
        ['children']
        ['steps']
        ['children']
        ['billing-step']
        ['children']
        ['payment']
        ['children']
        ['payments-list']
        ['children']
        [$paymentMethodForm]
        ['children']
        ['form-fields']
        ['children']
        [$fieldName] = $field;

        return $result;
    }

   
}
