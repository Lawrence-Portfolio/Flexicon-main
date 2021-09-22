// import plur from 'plur'

export default new class Cart {
    constructor() {
        this.cartData = null
        this.reducer = (accumulator, currentValue) => accumulator + currentValue

        this.cartList = '.cart-list'
        this.cartItem = '.cart-item'

        this.cartItemsCount ='.cart-items-count'

        this.totalPrice = '.total-price'
        this.totalPriceInput = '.total-price-input'

        this.orderForm = '.orderForm'
        this.successModal = '#success'
        this.xhr = null

        this.initCartPositions()
        this.initDate()
    }
    initDate() {
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
        $('[name="orderDate"]').val(`${day}.${mounth(date.getMonth())}.${year}`)
    }
    initCartPositions() {
        if(this.checkTime()) {
            localStorage.removeItem('cart')
        }
        this.cartData = JSON.parse(localStorage.getItem('cart'))

        if(this.cartData != null) {
            $(this.cartList).empty()
            if(this.cartData.items.length > 0) {
                this.cartData.items.forEach((item, index) => {
                    $(this.cartList).append(`
                        <div class="cart-item">
                            <picture>
                                <img class="img-fluid item-icon" width="88px" height="88px" src="${item.boxIcon}" alt="${item.boxName}">
                            </picture>
                            <div class="cart-info-wrap">
                                <div class="cart-name">${item.boxName}</div>
                                <div class="cart-info">
                                    <div class="cart-settings">
                                        <div><span>${item.paperName},</span> <span>Д: ${item.boxSize.length} мм Ш: ${item.boxSize.width} мм В: ${item.boxSize.height} мм,</span></div>
                                        <div>Принт: ${item.printType}</div>
                                        <div>${item.laminationType ? item.laminationType : ''}</div>
                                    </div>
                                    <div class="cart-price">
                                        <div class="cart-box-count">Тираж: ${item.total}</div>
                                        <div class="cart-box-price">Цена: ${item.price} <i class="fal fa-ruble-sign"></i></div>
                                    </div>
                                </div>
                            </div>
                            <button class="remove-cart" type="button" remove-index="${index}"><i class="fal fa-times"></i></button>
                            <input type="hidden" name="cart[${index}][name]" value="${item.boxName}">
                            <input type="hidden" name="cart[${index}][paper_name]" value="${item.paperName}">
                            <input type="hidden" name="cart[${index}][box_size_length]" value="${item.boxSize.length}">
                            <input type="hidden" name="cart[${index}][box_size_width]" value="${item.boxSize.width}">
                            <input type="hidden" name="cart[${index}][box_size_height]" value="${item.boxSize.height}">
                            <input type="hidden" name="cart[${index}][print_type]" value="${item.printType}">
                            <input type="hidden" name="cart[${index}][lamination_type]" value="${item.laminationType}">
                            <input type="hidden" name="cart[${index}][quantity]" value="${item.total}">
                            <input type="hidden" name="cart[${index}][price]" value="${item.value.toFixed(2)}">
                        </div> 
                    `)
                })
                $(this.cartItemsCount).text(`В корзине ${this.cartData.items.length} ${this.plur(this.cartData.items.length, 'товар')}`)
                $(this.totalPrice).html(this.cartData.totalPrice + ' <i class="far fa-ruble-sign"></i>')
                $(this.totalPriceInput).val(this.cartData.totalPriceValue.toFixed(2))
            } else {
               this.cartEmpty()
            }
            this.removeCart() 
        } else {
            this.cartEmpty()
        }
    }
    cartEmpty() {
        $(this.cartItemsCount).text('В корзине 0 товаров')
        $(this.cartList).html('<div class="cart-empty">В корзине нет товаров</>')
        $(this.totalPrice).html('0,00 <i class="far fa-ruble-sign"></i>')
        $(this.totalPriceInput).val('0.00')
    }
    plur(lenght, arg) {
        if(lenght == 1) {
            return arg
        } else if(lenght >= 2 && lenght <= 4) {
            return arg + 'a'
        } else if(lenght >= 5) {
            return arg + 'ов'
        }
    }
    removeCart() {
        const self = this
        $('.remove-cart').on('click', function(){
            let index = parseInt($(this).attr('remove-index'))
            self.cartData.items.splice(index, 1)

            if(self.cartData.items.length > 0) {
                self.cartData.totalPrice = self.moneyFormat(self.cartData.items.map(i => i.value).reduce(self.reducer))
                self.cartData.totalPriceValue = self.cartData.items.map(i => i.value).reduce(self.reducer)
            } else {
                self.cartData.totalPrice = 0
            }
            
            localStorage.setItem('cart', JSON.stringify(self.cartData))
            self.initCartPositions()
        })
    }
    moneyFormat(n) {
        return parseFloat(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1 ").replace('.', ',');
    }
    checkTime() {
        let oldDateTime = parseInt(localStorage.getItem('old-date-time'))
        if(!isNaN(oldDateTime)) {
            let date = new Date()
            let today = new Date(date.getFullYear(), date.getMonth(), date.getDate(), date.getMinutes()).valueOf()
        
            if(oldDateTime < today) {
                return true
            } else {
                return false
            }
        }
    }
}