<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Elsnertech\CustomAddressAttr\Block\Checkout\Address\Fields;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Framework\DataObject\Copy\Config as CopyConfig;

/**
 * Class ShippingLayoutProcessor add the fields to checkout billing address
 * @package Elsnertech\CustomAddressAttr\Block\Checkout\Address\Fields
 */
class ShippingLayoutProcessor implements LayoutProcessorInterface
{
    const DISTRIC = 'district';
    const SUB_DISTRIC = 'sub_district';
    
    /**
     * @var CopyConfig
     */
    private $copyConfig;

    /**
     * Fields constructor.
     * @param CopyConfig $copyConfig
     */
    public function __construct(CopyConfig $copyConfig)
    {
        $this->copyConfig = $copyConfig;
    }

    /**
     * Adding fields to the checkout
     * @param array $result
     * @return array
     */
    public function process($result)
    {

        $result = $this->filedWithDistric($result, 'district');
        $result = $this->filedSubDistric($result, 'sub_district');
        return $result;
    }

    /**
     * Select company or person
     * @param $result
     * @param $fieldName
     * @return mixed
     */
    public function filedWithDistric($result, $fieldName)
    {

        $district = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.district',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'tooltip' => [
                    'description' => 'this is what the field is for',
                ],
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $fieldName,
            'label' => 'District',
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'validation' => [
               'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'value' => '' // value field is used to set a default value of the attribute
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$fieldName] = $district;
        return $jsLayout;
    }

    /**
     * Registry of commerce
     * @param $result
     * @param $fieldName
     * @return mixed
     */
    public function filedSubDistric($result, $fieldName)
    {

        $subDistrict = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.sub_district',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'tooltip' => [
                    'description' => 'this is what the field is for',
                ],
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $fieldName,
            'label' => 'District',
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'validation' => [
               'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'value' => '' // value field is used to set a default value of the attribute
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$fieldName] = $subDistrict;
        return $jsLayout;
    }
}
