define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (setBillingAddressAction) {
        return wrapper.wrap(setBillingAddressAction, function (originalAction, messageContainer) {

            var billingAddress = quote.billingAddress(),
                withCompany = 1;

            if(billingAddress != undefined) {

                if (billingAddress['extension_attributes'] === undefined) {
                    billingAddress['extension_attributes'] = {};
                }
                //console.log(billingAddress['customAttributes']);
                // console.log(billingAddress);
                if (billingAddress.customAttributes.length !== 0) {
                     console.log(billingAddress.customAttributes[0].value.value)
                    console.log(billingAddress.customAttributes[1].value.value)
                    var distric = billingAddress.customAttributes[0].value.value;
                    var SubDistric = billingAddress.customAttributes[1].value.value;
                    billingAddress['customAttributes']['distric'] = distric;
                    billingAddress['customAttributes']['sub_distric'] = SubDistric;
                    billingAddress['extension_attributes']['distric'] = distric;
                    billingAddress['extension_attributes']['sub_distric'] = SubDistric;
                }
            }

            return originalAction(messageContainer);
        });
    };
});