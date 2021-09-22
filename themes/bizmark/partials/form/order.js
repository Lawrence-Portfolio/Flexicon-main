export default new class OrderModal {
    constructor() {
        this.openModal = '.services-order'
        this.orderModal = '.order-modal'
        this.orderForm = '.order-form'
        this.successModal = '#success'

        this.requisites = '#requisites'
        this.design = '#design'

        this.fileData = ' .file-data'


        this.cartList = '.cart-list'
        this.cartItemsCount ='.cart-items-count'
        this.totalPrice = '.total-price'
        this.totalPriceInput = '.total-price-input'

        this.successMessageOrder = '.success-message-order'

        this.initOrderForm()
    }
    initOrderForm()
    {
        $(this.orderForm).submit(target => {
            target.preventDefault();

            $.oc.stripeLoadIndicator.show();

            if (this.xhr) {
                this.xhr.abort();
            }

            let _self = this,
                form = $(target.currentTarget),
                button = form.find('button[type="submit"]');

            button.attr('disabled', true);

            this.xhr = form.request('MakeOrder::onOrder', {
                files: true,
                success: function (response) {
                    this.success(response);

                    $(_self.orderModal).modal('hide')

                    _self.cartOrderDate()
                    $(_self.successModal).modal('show')

                    form[0].reset();
                    if(window.location.href == window.location.origin + '/cart') {
                        _self.clearCart()
                    }
                },
                error: () => $.oc.flashMsg({
                    text: 'Произошла ошибка при создании заказа. Попробуйте позднее, или обратитесь к нам по телефону указанному в контактах.',
                    class: 'error',
                    interval: 20
                }),
                complete: () => {
                    $.oc.stripeLoadIndicator.hide()
                    button.attr('disabled', false);
                }
            })
        })
    }
    cartOrderDate() {
        if($(this.successMessageOrder)[0] != undefined) {
            let date = new Date()
            let day = date.getDate()
            let mounth = (mounth) => {
                mounth++
                if(mounth < 10) {
                    return '0' + mounth
                } else {
                    return mounth
                }
            }
            let year = date.getFullYear()

            $(this.successMessageOrder).find('.order-date').text(`${day}.${mounth(date.getMonth())}.${year}`)
        }
    }
    clearCart() {
        $(this.cartList).empty()

        $(this.cartItemsCount).text('В корзине 0 товаров')
        $(this.totalPrice).html('0,00 <i class="far fa-ruble-sign"></i>')
        $(this.totalPriceInput).val(0)
        $(this.cartList).html('<div class="cart-empty">В корзине нет товаров</>')
        localStorage.removeItem('cart')
    }
}




