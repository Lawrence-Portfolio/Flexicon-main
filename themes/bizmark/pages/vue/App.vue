

<template>
    <loader v-if="loading" :active="loading" :is-full-page="false"></loader>
    
    <div v-else class="calculate-layout">
        <div class="container">
            <h2 class="h1">РАСЧИТАТЬ И ЗАКАЗАТЬ ОНЛАЙН</h2>
            <steps-progress-bar 
                :requestData="requestData" 
                :appData="appData" 
                :winWidth="winWidth">
            </steps-progress-bar>
            <router-view 
                :requestData="requestData"
                :appData="appData"
                @update-box-name="updateBoxName"
                @update-box-type="updateBoxType"
                @update-paper-name="updatePaperName"
                @update-paper-type="updatePaperType"
                @update-box-settings="updateBoxSettings"
                @result="result"
                @add-cart="addCart">
            </router-view>
            <cart 
                :cart="cart" 
                :winWidth="winWidth"
                @remove-cart="removeCart"
                @submit-checkout="submitCheckout">
            </cart>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import loader from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

import stepsProgressBar from './components/StepsProgressBar'
import cart from './components/Cart'

export default {
    components: {
        loader,
        stepsProgressBar,
        cart
    },
    data: () => ({
        urlRequest: document.location.origin + '/api/v1/calculator',
        requestData: {},
        loading: false,
        appData: JSON.parse(sessionStorage.getItem('app-data')) || {
            step1: false,
            step2: false,
            step3: false,
            step4: false,
            substep1: false,
            substep2: false,
            progressLine: 0,

            boxName: {},
            boxType: {},

            paperName: {},
            paperType: {},

            length: 0,
            width: 0,
            height: 0,
            printType: {},
            laminationType: {},

            boxCount: '',
            price: '',
            priceOneBox: '',
            priceValue: 0,

            isAddCart: false
        },
        cart: JSON.parse(localStorage.getItem('cart')) || {
            items: [],
            totalPrice: '0.00',
            totalPriceValue: 0
        },
        reducer: (accumulator, currentValue) => accumulator + currentValue,
        winWidth: 0
    }),
    methods: {
        updateBoxName(data) {
            this.appData.boxName = data
            this.$router.push('/substep-1')
        },
        updateBoxType(data) {
            this.appData.boxType = data
            this.$router.push('/step-2')
        },
        updatePaperName(data) {
            this.appData.paperName = data
            this.$router.push('/substep-2')
        },
        updatePaperType(data) {
            this.appData.paperType = data
            this.$router.push('/step-3')
        },
        updateBoxSettings(data) {
            this.appData.length = data.length
            this.appData.width = data.width
            this.appData.height = data.height
            this.appData.printType = data.printType
            this.appData.laminationType = data.laminationType
            this.$router.push('/step-4')
        },
        result(data) {
            this.appData.boxCount = data.boxCount
            this.appData.priceOneBox = this.moneyFormat(data.priceOneBox)
            this.appData.price = this.moneyFormat(data.price)
            this.appData.priceValue = data.price
            this.appData.step4 = true
        },
        updateProgressLine() {
            let completeSteps = [this.appData.substep1, this.appData.substep2, this.appData.step3, this.appData.step4]
            let completeStepsValue = completeSteps.map(i => i ? 25 : 0)
            this.appData.progressLine = completeStepsValue.reduce((total, amount) => total + amount)
        },
        addCart() {
            let boxIcon = ''
            if(this.appData.boxType.preview_image) {
                boxIcon = this.appData.boxType.preview_image
            } else {
                boxIcon = 'themes/bizmark/assets/images/default-icon.png'
            }
            let itemCart = {
                boxName: `${this.appData.boxName.name} ${this.appData.boxType.code}`,
                paperName: `${this.appData.paperName.name} ${this.appData.paperType.code}`,
                boxIcon,
                boxSize: {
                    length: this.appData.length,
                    width: this.appData.width,
                    height: this.appData.height,
                },
                printType: this.appData.printType.name,
                laminationType: this.appData.laminationType.name,
                total: this.appData.boxCount,
                price: this.appData.price,
                value:  this.appData.priceValue
            }
            this.cart.items.push(itemCart)
            this.calcTotalPrice()
        },
        removeCart(itemIndex) {
            this.cart.items.forEach((elem, i) => {
                if(i == itemIndex) {
                    let item = this.cart.items.indexOf(elem)
                    this.cart.items.splice(item, 1)
                }
            })
            this.calcTotalPrice()
        },
        submitCheckout() {
            this.yandexMetrik()
            sessionStorage.removeItem('app-data')
            location.href = '/cart'
        },
        yandexMetrik() {
            ym(72877768, 'reachGoal', 'zakaz'); return true;
        },
        calcTotalPrice() {
            if(this.cart.items.length !=0 ) {
                this.cart.totalPriceValue = this.cart.items.map(i => i.value).reduce(this.reducer)
                this.cart.totalPrice = this.moneyFormat(this.cart.totalPriceValue)
            }
        },
        findWidth() {
            let self = this
            this.winWidth = window.innerWidth
            window.addEventListener('resize', e => {
                self.winWidth = window.innerWidth
            })
        },
        moneyFormat(n) {
            return parseFloat(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1 ").replace('.', ',');
        },
        lastActionCard() {
            const timeSession = 1 * 60 * 60 * 1000

            let date = new Date()
            let oldDateTime = new Date(date.getFullYear(), date.getMonth(), date.getDate(), date.getMinutes()).valueOf() + timeSession
            localStorage.setItem('old-date-time', oldDateTime)
        },
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
    },
    watch: {
        appData: {
            handler(val) {
                sessionStorage.setItem('app-data', JSON.stringify(val))
            },
            deep: true
        },
        cart: {
            handler(val) {
                if(val.items.length > 0) {
                    this.appData.isAddCart = true
                    this.lastActionCard()
                } else {
                    this.appData.isAddCart = false
                    localStorage.removeItem('old-date-time') // lastActionCard method view
                }
                localStorage.setItem('cart', JSON.stringify(val))
            },
            deep: true
        },
        "$route"(to) {
            if(to.name == 'Step-1') {
                this.appData.step1     = false
                this.appData.substep1  = false
                this.appData.step2     = false
                this.appData.substep2  = false
                this.appData.step3     = false
                this.appData.step4     = false

                this.appData.isAddCart = false
            } else if(to.name == 'Substep-1') {
                this.appData.step1     = true
                this.appData.substep1  = false
                this.appData.step2     = false
                this.appData.substep2  = false
                this.appData.step3     = false
                this.appData.step4     = false
            } else if(to.name == 'Step-2') {
                this.appData.step1     = true
                this.appData.substep1  = true
                this.appData.step2     = false
                this.appData.substep2  = false
                this.appData.step3     = false
                this.appData.step4     = false
            } else if(to.name == 'Substep-2') {
                this.appData.step1     = true
                this.appData.substep1  = true
                this.appData.step2     = true
                this.appData.substep2  = false
                this.appData.step3     = false
                this.appData.step4     = false
            } else if(to.name == 'Step-3') {
                this.appData.step1     = true
                this.appData.substep1  = true
                this.appData.step2     = true
                this.appData.substep2  = true
                this.appData.step3     = false
                this.appData.step4     = false
            } else if(to.name == 'Step-4') {
                this.appData.step1     = true
                this.appData.substep1  = true
                this.appData.step2     = true
                this.appData.substep2  = true
                this.appData.step3     = true
                this.appData.step4     = false
                this.appData.boxCount  = ''
            }
            this.updateProgressLine()
        },
        "appData.step4": function(val) {
            this.updateProgressLine()
        }
    },
    async mounted() {
        this.loading = true
        await axios.get(this.urlRequest).then(response => {
            this.requestData = response.data
            this.requestData.lamination_types = [
                { name: 'Без ламинации', coefficient: 1, id: 0 },
                { name: 'Ламинация глянцевая', coefficient: response.data.main.laminar_margin, id: 1 },
                { name: 'Ламинация матовая', coefficient: response.data.main.laminar_margin, id: 2 }
            ]
            console.log(this.requestData)
        })

        if(!sessionStorage.getItem('app-data')) {
            this.$router.push('/')
        }
        
        if(this.checkTime()) {
            this.cart.items.splice(0, this.cart.items.length)
            this.$router.push('/')
        }

        if(this.$route.name == 'Step-1') {
            this.appData.step1     = false
            this.appData.substep1  = false
            this.appData.step2     = false
            this.appData.substep2  = false
            this.appData.step3     = false
            this.appData.step4     = false

            this.appData.isAddCart = false
        } else if(this.$route.name == 'Substep-1') {
            this.appData.step1     = true
            this.appData.substep1  = false
            this.appData.step2     = false
            this.appData.substep2  = false
            this.appData.step3     = false
            this.appData.step4     = false
        } else if(this.$route.name == 'Step-2') {
            this.appData.step1     = true
            this.appData.substep1  = true
            this.appData.step2     = false
            this.appData.substep2  = false
            this.appData.step3     = false
            this.appData.step4     = false
        } else if(this.$route.name == 'Substep-2') {
            this.appData.step1     = true
            this.appData.substep1  = true
            this.appData.step2     = true
            this.appData.substep2  = false
            this.appData.step3     = false
            this.appData.step4     = false
        } else if(this.$route.name == 'Step-3') {
            this.appData.step1     = true
            this.appData.substep1  = true
            this.appData.step2     = true
            this.appData.substep2  = true
            this.appData.step3     = false
            this.appData.step4     = false
        } else if(this.$route.name == 'Step-4') {
            this.appData.step1     = true
            this.appData.substep1  = true
            this.appData.step2     = true
            this.appData.substep2  = true
            this.appData.step3     = true
            this.appData.step4     = false
            this.appData.boxCount  = ''
        }
        this.updateProgressLine()
        this.loading = false

        this.findWidth()
    }
}
</script>
<style lang="scss">
    @import '../../build/scss/variables';
    .vld-overlay {
        padding-top: 60px;
        position: relative;
        height: 800px;
    }
    .calculate-layout {
        .step-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 2rem;
        }
        .h1 {
            position: relative;
            padding: 40px 0;
            margin: 0;
            &::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 5px;
                background-color: #DFBD97;
                border-radius: 20px;
            }
        }
        .paper-name-hover {
            padding: 13px 0;
            max-width: 272px;
            text-align: center;
            background: #F7F3E8;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .form-label {
            font-size: 16px;
            font-weight: 400;
            text-transform: none;
        }
        .form-group {
            margin-bottom: 30px;
        }
        .attention {
            margin-top: 10px;
            font-size: 14px;
        }
        .result-title {
            margin-bottom: 20px;
        }
    }
    .empty-tovars {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-back {
        padding: 7px 20px;
        border-radius: 20px;
        color: #fff;
        background-color: $primary_btn;
    }
    .layout-step-container {
        .row {
            margin: 0 -10px;
        }
        .col-item {
            padding: 0 10px;
        }
    }
    .col-item {
        margin-bottom: 20px;
    }
    .layout-box-card {
        height: 100%;
        padding: 25px 0;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
        transition: all .2s ease-in-out;
        text-align: center;
        cursor: pointer;
        &:hover {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    }
    .layout-box-back {
        padding: 10px 0;
        cursor: pointer;
        position: sticky;
        top: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
        background-color: #7C5131;
        color: #fff;
        &:hover {
            color: #fff;
            background-color: #6A4C36;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    }
    .layout-block {
        
        padding: 40px;
        background-color: #fff;
        border: 1px solid #EEEEEE;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    }
    .result-block .button-group {
        margin-top: 30px;
    }
    .step-4 .layout-block {
        min-height: 250px;
        height: 100%;
    }
    .item-name {
        padding: 0 30px;
        font-size: 18px;
    }
    .form-title {
        margin-bottom: 30px;
    }
    .material-name {
        font-weight: 500;
    }
    .radio-wrap {
        margin-right: 20px;
        &:last-child {
            margin-right: 0;
        }
    }
    .radio-group {
        flex-wrap: wrap;
        justify-content: flex-start;
    }
    .form-radio-label {
        padding-left: 30px;
        position: relative;
        cursor: pointer;
        &::after, &::before {
            content: '';
            position: absolute;
            border-radius: 50%;
        }
        &::before {
            top: calc(50% - 10.5px);
            left: 0;
            width: 21px;
            height: 21px;
            border: 1px solid #AB8D7D;
        }
        &::after {
            top: calc(50% - 7.5px);
            left: 3px;
            width: 15px;
            height: 15px;
            background-color: $primary_btn;
            opacity: 0;
        }

    }
    .form-radio-control {
        display: none;
    }
    .form-radio-control:checked ~ .form-radio-label::after {
        opacity: 1;
    }


    @media(min-width: 1200px) {
        .calculate-layout {
            .step-4 {
                .w-100 {
                    display: none;
                }
            }
        }
    }

    @media(max-width: 1199px) {
        .layout-block {
            padding: 20px;
        }
        .calculate-layout {
            .form-control {
                max-width: 280px;
            }
        }
        
    }

    @media(max-width: 991px) {
        .empty-tovars {
            flex-direction: column;
            align-items: flex-start;
        }
        .layout-block-col {
            margin-bottom: 30px;
        }
        .btn-back {
            margin-top: 15px;
        }
        .mobile-step-wrap {
            margin-bottom: 30px;
            .step-nav-item .step-nav-number {
                margin-top: -2px;
            }
        }
        .mobile-step-wrap.active {
            .step-nav-number {
                background-color: $light_green;
            }
        }
        .change-step-data {
            margin-top: 0;
        }
    }

    @media(max-width: 767px) {
        .box-back-wrap {
            margin-bottom: 30px;
            order: 1;
        }
        .box-wrapper {
            order: 2;
        }
    } 

    @media(max-width: 575px) {
        .calculate-layout .form-group {
            margin-bottom: 15px;
        }
        .calculate-layout .step-title {
            font-size: 20px;
        }
        .result-block .button-group {
            button {
                display: block;
                margin-bottom: 15px;
                width: 100%;
                &:last-child {
                    margin-bottom: 0;
                }
            }
        }
    }
</style>