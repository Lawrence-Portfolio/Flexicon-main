<template>
    <div>
        <button class="cart-btn" :class="{ 'show': !isShowCart && cart.items.length != 0 }" @click="isShowCart = !isShowCart">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-items-count">{{ cart.items.length }}</span>
        </button>
        <div class="cart" :class="{ 'show': cart.items.length != 0 && isShowCart}">
            <div class="cart-header">Товаров в корзине  {{ cart.items.length }} шт.</div>
            <div class="cart-body">
                <div class="item-cart" v-for="(item, index) in cart.items" :key="index">
                    <picture>
                        <img width="50px" height="50px" class="img-fluid item-icon" :src="item.boxIcon" :alt="item.boxName">
                    </picture>
                    <div class="item-body">
                        <div class="item-box-info">
                            <div class="item-box item-box-name">{{ item.boxName }}</div>
                            <div class="item-box item-peper-name">{{ item.peperName }}</div>
                            <div class="item-box item-box-size">
                                <span>Д:{{ item.boxSize.length }}</span>
                                <span>Ш:{{ item.boxSize.width }}</span>
                                <span>В:{{ item.boxSize.height }}</span>
                            </div>
                            <div class="item-box item-box-print">Принт: {{ item.printType }}</div>
                            <div class="item-box item-box-print">{{ item.laminationType }}</div>
                        </div>
                        <div class="item-total">
                            <div class="item-count">Тираж:<span>{{ item.total }}</span></div>
                            <div class="item-price">Цена:<span>{{ item.price }} <i class="fal fa-ruble-sign"></i></span></div>
                        </div>
                    </div>
                    <button class="remove-item" @click="removeCart(index)">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="cart-footer">
                <div class="total-price-wrap">
                    <span class="total-wrap-label">Общая сумма:</span>
                    <span class="total-price-value">{{ cart.totalPrice }} <i class="far fa-ruble-sign"></i></span>
                </div>
                <button class="c-btn checkout" @click="submitCheckout">Оформить заказ</button>
            </div>
            <button class="close-cart-bth" @click="isShowCart = false"><i class="fas fa-times"></i></button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        cart: Object,
        winWidth: Number
    },
    data: () => ({
        isShowCart: false
    }),
    methods: {
        removeCart(index) {
            this.$emit('remove-cart', index)
        },
        submitCheckout() {
            this.$emit('submit-checkout')
        }
    },
    watch: {
        cart(val) {
            if(val.length == 0) {
                this.isShowCart = false
            }
        },
        winWidth(val) {
            if(val < 992) {
                this.isShowCart = false
            } else {
                this.isShowCart = true
            }
        }
    },
    mounted() {
        if(this.winWidth < 992) {
            this.isShowCart = false
        } else {
            this.isShowCart = true
        }
    }
}
</script>


<style lang="scss">
    .cart {
        padding: 20px;
        position: fixed;
        top: 90px;
        right: -100%;
        width: 380px;
        background-color: #fff;
        border: 1px solid #BDC6B9;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        transition: all .5s ease-in-out;
        border-radius: 0px 0px 7px 7px;
        overflow: hidden;
        z-index: 500;
        .item-cart {
            display: flex;
            position: relative;
            padding: 20px 0;
            border-top: 1px solid #DCC6A4;
        }
        .item-icon {
            padding: 3px;
            border: 1px solid #dfbd97;
            border-radius: 5px;
        }
        .item-box {
            margin-bottom: 5px;
            &:last-child {
                margin-bottom: 0;
            }
        }
        .cart-header {
            font-weight: 500;
            color: #414141;
            margin: 0 0 15px 40px
        }
        .item-box-info {
            font-size: 12px;
            color: #707070;
            margin-bottom: 20px;
        }
        .item-box-name {
            max-width: 80%;
            font-weight: 700;
            color: #000;
        }
        .item-body {
            margin-left: 10px;
        }
        .item-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
            font-size: 14px;
        }
        .item-count,
        .item-price {
            display: flex;
            flex-wrap: wrap;
            span {
                margin-left: 3px;
            }
        }
        .item-price {
            padding: 2px 7px;
            background-color: #F7F3E8;
        }
        .cart-footer {
            padding: 20px 0 40px;
            margin: 0 -20px -20px;
            text-align: center;
            background-color: #F7F3E8;
            
        }
        .cart-body {
            margin: 0 -20px;
            padding: 0 20px;
            max-height: 400px;
            overflow: auto;
        }
        .checkout {
            padding: 15px 42px;
            font-size: 14px;
            text-transform: uppercase;
        }
        .total-price-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .total-wrap-label {
            font-size: 18px;
            margin-right: 10px;
        }
        .total-price-value {
            font-size: 24px;
            font-weight: 500;
        }
        .remove-item {
            position: absolute;
            right: 0;
            top: 14px;
            width: 30px;
            height: 30px;
            font-size: 20px;
            background-color: transparent;
            border: none;
            padding: 0;
            outline: none;
            transition: all .2s ease-in-out;
            &:hover {
                color: #3B7A17;
            }
        }
    }
    .cart.show {
        right: 0;
    }
    .cart-btn {
        padding: 0;
        width: 50px;
        height: 50px;
        background-color: #F7F3E8;
        position: fixed;
        top: 100px;
        right: -50px;
        border: none;
        outline: none!important;
        border-radius: 50%;
        z-index: 50;
        box-shadow: 0 0 5px -3px;
        transition: all .2s ease-in-out;
        i {
            color: #1D350E;
        }
        .cart-items-count {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            right: 0;
            top: -3px;
            width: 20px;
            height: 20px;
            background-color: #3B7A17;
            color: #fff;
            font-size: 12px;
            font-family: "Roboto", sans-serif;
            border-radius: 50%;
        }
    }
    .cart-btn.show {
        right: 20px;
    }
    .close-cart-bth {
        position: absolute;
        top: 0;
        right: 0;
        padding: 6px 12px;
        border: none;
        background-color: transparent;
        outline: none!important;
    }
    @media(max-width: 991px) {
        .cart-btn {
            right: -70px;
        }
        .cart-btn.show {
            right: 20px;
        }
    }
    @media(max-width: 767px) {
        .cart-btn {
            top: 20px;
            left: -70px;
        }
        .cart-btn.show {
            left: 20px;
        }
    }
    @media(max-width: 575px) {
        .cart {
            top: 0;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            .cart-body {
                height: 100%;
            }
            .total-wrap-label {
                font-size: 16px;
            }
            .total-price-value {
                font-size: 20px;
            }
            .item-icon {
                width: 30px;
            }
        }
    }
</style>