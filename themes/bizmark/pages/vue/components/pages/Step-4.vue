<template>
    <div class="row">
        <div class="col-12">
            <h2 class="step-title">Введите тираж</h2>
        </div>
        <div class="col-lg-6 layout-block-col">
            <form class="layout-block edition-block" @submit.prevent>
                <div class="form-group" :class="{ invalid: $v.edition.$dirty && !$v.edition.required }">
                    <div class="form-label">Тираж (шт.)</div>
                    <input 
                        v-model="edition"
                        class="form-control"
                        min="10"
                        ref="edition"
                        type="number" 
                        placeholder="Введите тираж"
                    >
                </div>
                <div class="attention">Минимальный размер тиража - 10 шт.</div>
                <div class="button-group">
                </div>
            </form>
        </div>
        <div v-if="appData.step4" class="col-lg-6">
            <div class="layout-block result-block">
                <div class="result-title">Результат</div>
                <div>Цена за 1 шт. : <b>{{ appData.priceOneBox }} <i class="fas fa-ruble-sign"></i></b></div>
                <div>Цена тиража: <b>{{ appData.price }} <i class="fas fa-ruble-sign"></i></b></div>
                <div class="button-group">
                    <button 
                        :disabled="!$v.edition.between || edition == ''" 
                        :class="{ disabled: !$v.edition.between || edition == '' }" 
                        class="c-btn edition-btn" type="button" 
                        @click="addCart"
                    >Добавить в корзину</button>
                    <button v-if="appData.isAddCart" class="c-btn edition-btn" type="button" @click="$router.push('/')">Вернуться к покупкам</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { required, between } from 'vuelidate/lib/validators'

export default {
    props: {
        requestData: Object,
        appData: Object
    },
    data: () => ({
        edition: '',
        editionCoef: 1
    }),
    validations: {
        edition: {
            required,
            between: between(10, Infinity)
        },
    },
    methods: {
        onCalc() {
            if(this.$v.$invalid) {
                this.$v.$touch()
                const result = {
                    boxCount: '',
                    price: 0,
                    priceOneBox: 0
                }
                this.$emit('result', result)
            } else {
                this.calcCoefCountBox() // Коэффициент тиража

                /** Получение данных для расчета */

                const l = this.appData.length / 1000 // Длина коробки
                const w = this.appData.width / 1000 // Ширина коробки
                const h = this.appData.height / 1000 // Высота коробки
                const c = parseInt(this.edition) // Тираж коробок
                const c_coef = this.editionCoef // Коэффициент тиража

                const bt_coef = Number(this.appData.boxType.coefficient) // Коэффициент выбранного типа коробки
                const pt_price = Number(this.appData.paperType.price) // Цена выбранного типа картона
                const prt_coef = Number(this.appData.printType.coefficient) // Коэффициент выбранного принта
                const prt_price = Number(this.appData.printType.price) // Цена выбранного принта
                const lam_coef = Number(this.appData.laminationType.coefficient == 0 ? 1 : this.appData.laminationType.coefficient) // Коэффициент выбранной ламинации

                const cost_c = this.requestData.main.cost_cutting // Цена реза за погонный метр
                const cost_p = this.requestData.main.cost_prepress // Цена за препрес
                const cost_o = this.requestData.main.cost_other // Прочие затраты
                const cost_f = this.requestData.main.cost_fee // НДС

                const m_coef = this.requestData.main.margin // Маржа


                /** Расчет стоимсоти */

                let s_box = (l * w + l * h + w * h) * 2 // Площадь коробки
                let s_box_coef = s_box * bt_coef // Площадь коробки с учетом коэффициент

                // let cut_length = (l + w + h) * 4 // Длина реза (old)
                let cut_length = (l + w + h) * 4 * bt_coef // Длина реза с учетом коэффициента (new)

                let price_one_box = s_box_coef * pt_price // Цена за одну коробку

                // let print_box_price = s_box * prt_price * prt_coef // Цена принта коробки (old)
                let print_box_price = s_box_coef * prt_price * prt_coef // Цена принта коробки  с учетом коэффициента (new)

                let cut_length_price = cost_c * cut_length // Цена резки относительно размеров длинны реза

                let cost_per_box = price_one_box + print_box_price + cut_length_price // Стоимсоть коробки с учетом нанесенного принта и длинны реза

                let prepress_price_count = cost_p / c // Затраты на препресс относительно тиража

                // let outher_cost_price = (cost_per_box + prepress_price_count) * cost_o // Прочие затраты (old)
                let outher_cost_price = cost_o / c // Прочие затраты относительно тиража (new)

                let total_price_one_box = (cost_per_box + prepress_price_count + outher_cost_price) * m_coef * c_coef * cost_f * lam_coef // Финальная цена за коробку (с учетом НДС, маржи и т.д)

                let total_price = c * total_price_one_box // Финальная цена за тираж

                const result = {
                    boxCount: this.edition,
                    price: total_price,
                    priceOneBox: total_price_one_box
                }
                this.$emit('result', result)
            }
        },
        calcCoefCountBox() { 
            if(this.edition >= 10 && this.edition <= 50) {
                this.editionCoef = this.requestData.main.cost_pack_10_50
            } else if (this.edition >= 51 && this.edition <= 100) {
                this.editionCoef = this.requestData.main.cost_pack_51_100
            } else if (this.edition >= 101 && this.edition <= 200) {
                this.editionCoef = this.requestData.main.cost_pack_101_200
            } else if (this.edition >= 201 && this.edition <= 300) {
                this.editionCoef = this.requestData.main.cost_pack_201_300
            } else if (this.edition >= 301 && this.edition <= 500) {
                this.editionCoef = this.requestData.main.cost_pack_301_500
            } else if(this.edition >= 501) {
                this.editionCoef = this.requestData.main.cost_pack_501_more
            }
        },
        addCart() {
            this.edition = ''
            this.$emit('add-cart')
        }
    },
    watch: {
        edition(val) {
            this.onCalc()
        }
    },
    mounted() {
        this.edition = this.appData.boxCount
    }
}
</script>

<style lang="scss">
    .edition-block {
        .form-group {
            margin-bottom: 0;
        }
    }
</style>