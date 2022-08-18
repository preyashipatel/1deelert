<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Elsnertech\CustomAddressAttr\Plugin\Magento\Quote\Model;

use Magento\Framework\Exception\CouldNotSaveException;


/**
 * Class BillingAddressManagement
 * @package Elsnertech\CustomAddressAttr\Plugin\Magento\Quote\Model
 */
class BillingAddressManagementPlugin
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
                $destric = $extAttributes->getDistric();
                $address->setDistric($destric);
                $subDistric = $extAttributes->getSubDistric();
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
