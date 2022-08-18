<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Elsnertech\CustomAddressAttr\Plugin\Magento\Quote\Model;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class ShippingAddressManagementPlugin
 * @package Elsnertech\CustomAddressAttr\Plugin\Magento\Quote\Model
 */
class ShippingAddressManagementPlugin
{

    /**
     * @param $subject
     * @param $cartId
     * @param $address
     * @throws CouldNotSaveException
     */
    public function beforeAssign(
        $subject,
        $cartId,
        $address
    ) {
        $extAttributes = $address->getExtensionAttributes();
        if ($extAttributes) {
            try {
                $distric = $extAttributes->getDistric();
                $subDistric = $extAttributes->getSubDistric();
                $address->setDistric($distric);
                $address->setSubDistric($subDistric);
            } catch (\Exception $e) {
                throw new CouldNotSaveException(
                    __('One custom field could not be added to the address.'),
                    $e
                );
            }
        }
    }
}
