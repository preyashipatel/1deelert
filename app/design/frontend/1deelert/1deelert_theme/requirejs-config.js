var config = {
config: {
        mixins: {
            'mage/collapsible': {
                'js/mage/collapsible-mixin': true
            }
        }
    },
paths: {
        slick: 'js/slick'
    },
shim: {
    slick: {
        deps: ['jquery']
    }
},
map: {
        '*': {
            'Mirasvit_LayeredNavigation/js/lib/nprogress':'Mirasvit_LayeredNavigation/js/lib/nprogress'
        }
    },
deps:[
    'js/1deelert'
]
};