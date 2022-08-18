var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-billing-address': {
                'Elsnertech_CustomAddressAttr/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/set-shipping-information': {
                'Elsnertech_CustomAddressAttr/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'Elsnertech_CustomAddressAttr/js/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Elsnertech_CustomAddressAttr/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'Elsnertech_CustomAddressAttr/js/action/set-billing-address-mixin': true
            }
        }
    }
};