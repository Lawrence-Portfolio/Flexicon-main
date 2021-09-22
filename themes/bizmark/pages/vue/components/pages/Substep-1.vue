<template>
    <div v-if="Object.keys(appData.boxName).length != 0">
        <h2 class="step-title">Выберите артикул коробки</h2>
        <div v-if="Object.keys(appData.boxName).length != 0" class="row">
            <div class="col-md-9 box-wrapper">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-item" v-for="(item, index) in appData.boxName.box_types" :key="index">
                        <div class="layout-box-card" @click="updateBoxType(item)">
                            <img v-if="item.preview_image" class="img-fluid" :src="item.preview_image">
                            <img v-else class="img-fluid" src="themes/bizmark/assets/images/image-placeholder.png">
                            <div class="item-name">{{ item.code }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 box-back-wrap">
                <div class="layout-box-back" @click="$router.push('/')">
                    <div class="item-name">Назад</div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="empty-tovars">Извините, к сожалению товара нет в наличии. <button class="btn btn-back"  @click="$router.push('/')">Вернуться назад</button></div>
</template>
<script>
export default {
    props: {
        requestData: Object,
        appData: Object
    },
    methods: {
        updateBoxType(data){
            this.$emit('update-box-type', data)
        }
    }
}
</script>