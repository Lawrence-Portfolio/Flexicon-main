<template>
    <div class="row">
        <div class="col-lg-6">
            <h2 class="step-title">Параметры упаковки</h2>
            <form class="layout-block settings" @submit.prevent="updateBoxSettings()">
                <div class="form-group" :class="{ invalid: $v.length.$dirty && !$v.length.required }">
                    <div class="form-label">Длина (мм)</div>
                    <input class="form-control" v-model="length" type="number" ref="length" placeholder="Длинна коробки" @keyup="onLength($event)"  @change="onLength($event)">
                    <div v-if="$v.length.$dirty && !$v.length.required" class="invalid-message">Это поле обязательно</div>
                </div>
                <div class="form-group" :class="{ invalid: $v.width.$dirty && !$v.width.required }">
                    <div class="form-label">Ширина (мм)</div>
                    <input class="form-control" v-model="width" type="number" ref="width" placeholder="Ширина коробки" @keyup="onWidth($event)"  @change="onWidth($event)">
                    <div v-if="$v.width.$dirty && !$v.width.required" class="invalid-message">Это поле обязательно</div>
                </div>
                <div class="form-group" :class="{ invalid: $v.height.$dirty && !$v.height.required }">
                    <div class="form-label">Высота (мм)</div>
                    <input class="form-control" v-model="height" type="number" ref="height" placeholder="Высота коробки" @keyup="onHeigth($event)"  @change="onHeigth($event)">
                    <div v-if="$v.height.$dirty && !$v.height.required" class="invalid-message">Это поле обязательно</div>
                </div>
                <div class="form-group radio-group">
                    <span class="radio-wrap" v-for="(item, index) in requestData.print_types" :key="item.id">
                        <input :id="'print-type-' + item.id" class="form-radio-control" type="radio" name="printTypes" v-model="printType" :value="item">
                        <label class="form-radio-label" :for="'print-type-' + item.id">{{ item.name }}</label>
                    </span>
                </div>
                <div class="form-group radio-group">
                    <span class="radio-wrap" v-for="(item, index) in requestData.lamination_types" :key="item.id">
                        <input :id="'lamination-type-' + item.id" class="form-radio-control" type="radio" name="laminationTypes" v-model="laminationType" :value="item">
                        <label class="form-radio-label" :for="'lamination-type-' + item.id">{{ item.name }}</label>
                    </span>
                </div>
                <button class="c-btn submitOptions" type="submit" :disabled="$v.$invalid" :class="{ disabled: $v.$invalid }">Выбрать тираж</button>
            </form>
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
        length: '',
        width: '',
        height: '',
        printType: {},
        laminationType: {}
    }),
    validations: {
        length: {
            required,
            between: between(1, Infinity)
        },
        width: {
            required,
            between: between(1, Infinity)
        },
        height: {
            required,
            between: between(1, Infinity)
        }
    },
    methods: {
        onLength(e) {
            let value = Math.max(0, parseInt(e.target.value) || 0)
            if(value != 0) {
                this.length = value
            } else {
                this.length = ''
            }
        },
        onWidth(e) {
            let value = Math.max(0, parseInt(e.target.value) || 0)
            if(value != 0) {
                this.width = value
            } else {
                this.width = ''
            }
        },
        onHeigth(e) {
            let value = Math.max(0, parseInt(e.target.value) || 0)
            if(value != 0) {
                this.height = value
            } else {
                this.height = ''
            }
        },
        updateBoxSettings() {
            const settings = {
                length: this.length,
                width: this.width,
                height: this.height,
                printType: this.printType,
                laminationType: this.laminationType
            } 
            this.$emit('update-box-settings', settings)
        }
    },
    mounted() {
        this.printType = this.requestData.print_types[0]
        this.laminationType = this.requestData.lamination_types[0]
    }
}
</script>