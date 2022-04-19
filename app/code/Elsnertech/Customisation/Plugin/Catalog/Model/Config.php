<?php

namespace Elsnertech\Customisation\Plugin\Catalog\Model;

class Config
{
    public function afterGetAttributeUsedForSortByArray(
        \Magento\Catalog\Model\Config $catalogConfig,
        $options
    ) {

        unset($options['price']);
        $options['low_to_high'] = 'Price - Low To High';
        $options['high_to_low'] = 'Price - High To Low';
        return $options;

    }

}