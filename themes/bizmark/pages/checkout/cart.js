$(() => {
    "use strict";
    require('../../partials/form/order')
    require('../../partials/element/cart')
    require('../../partials/modal/success')
    $('[data-toggle="popover"]').popover({
        trigger: 'hover focus'
    })
});