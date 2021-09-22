<template>
    <div v-if="true">
        <h2 class="step-title">Выберите артикул картона</h2>
        <div class="row">
            <div class="col-md-9 box-wrapper">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-item" v-for="(item, index) in appData.paperName.paper_types" :key="index">
                        <div class="layout-box-card" @click="updatePaperType(item)">
                            <img v-if="item.preview_image" class="img-fluid" :src="item.preview_image">
                            <img v-else class="img-fluid" src="themes/bizmark/assets/images/image-placeholder.png">
                            <div class="item-name">{{ item.code }} ({{ item.color }})</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 box-back-wrap">
                <div class="layout-box-back" @click="$router.push('/step-2')">
                    <div class="item-name">Назад</div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="empty-tovars">Извините, к сожалению товара нет в наличии. <button class="btn btn-back" @click="$router.push('/step-2')">Вернуться назад</button></div>
</template>
<script>
export default {
    props: {
        requestData: Object,
        appData: Object
    },
    methods: {
        updatePaperType(data){
            this.$emit('update-paper-type', data)
        }
    }
}
</script>