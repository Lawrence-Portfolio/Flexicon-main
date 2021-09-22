<template>
    <div>
        <div v-if="requestData.box_names">
            <h2 class="step-title">Выберите тип упаковки</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-item" v-for="(item, index) in requestData.box_names" :key="index">
                    <div class="layout-box-card" @click="updateBoxName(item)">
                        <img v-if="item.preview_image" class="img-fluid" :src="item.preview_image">
                        <img v-else class="img-fluid" src="themes/bizmark/assets/images/image-placeholder.png">
                        <div class="item-name">{{ item.name }}</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-item">
                    <div class="layout-box-card services-order" data-toggle="modal" data-target="#orderModal">
                        <img class="img-fluid" src="themes/bizmark/assets/images/custom-box.png">
                        <div class="item-name">Коробки по эскизам заказчика</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-item">
                    <div class="layout-box-card services-order" data-toggle="modal" data-target="#orderModal">
                        <img class="img-fluid" src="themes/bizmark/assets/images/add-elem.png">
                        <div class="item-name">Дополнительные элементы упаковки</div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="empty-tovars">Извините, к сожалению товара нет в наличии.</div>
    </div>
</template>
<script>
export default {
    props: {
        requestData: Object,
        appData: Object
    },
    methods: {
        updateBoxName(data) {
            this.$emit('update-box-name', data)
        }
    }
}
</script>