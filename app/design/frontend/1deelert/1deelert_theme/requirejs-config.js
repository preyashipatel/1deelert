var config = {
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
            deelert: 'js/1deelert',
            'Mirasvit_LayeredNavigation/js/lib/nprogress':'Mirasvit_LayeredNavigation/js/lib/nprogress'
        }
    }
};