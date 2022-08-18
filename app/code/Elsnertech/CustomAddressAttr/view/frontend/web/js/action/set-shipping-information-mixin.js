define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote, shippingDateValue) {
    'use strict';

    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction, messageContainer) {

            var shippingAddress = quote.shippingAddress();

            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }
             if (shippingAddress.customAttributes.length !== 0) {
                // console.log('shippingAddress');
                // console.log(shippingAddress);
                // console.log(shippingAddress.customAttributes.length)
                // console.log(shippingAddress.customAttributes);
                // console.log(shippingAddress.customAttributes[0].value.value)
                // console.log(shippingAddress.customAttributes[1].value.value)
                var distric = shippingAddress.customAttributes[0].value.value;
                var SubDistric = shippingAddress.customAttributes[1].value.value;
                shippingAddress['customAttributes']['distric'] = distric;
                shippingAddress['customAttributes']['sub_distric'] = SubDistric;
                shippingAddress['extension_attributes']['distric'] = distric;
                shippingAddress['extension_attributes']['sub_distric'] = SubDistric;
                
            }

            

            console.log(shippingAddress);

            return originalAction(messageContainer);
        });
    };
});