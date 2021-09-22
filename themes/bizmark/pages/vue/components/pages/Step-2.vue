<template>
    <div v-if="requestData.paper_names">
        <h2 class="step-title">Выберите тип картона</h2>
        <div class="row">
            <!-- <div class="col-12"><div class="paper-name-hover">{{ paperNameHover }}</div></div> -->
            <div class="col-md-9 box-wrapper">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-item" v-for="(item, index) in requestData.paper_names" :key="index">
                        <div class="layout-box-card" @click="updatePaperName(item)">
                            <img v-if="item.preview_image" class="img-fluid" :src="item.preview_image">
                            <img v-else class="img-fluid" src="themes/bizmark/assets/images/image-placeholder.png">
                            <div class="item-name">{{ item.name }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 box-back-wrap">
                <div class="layout-box-back"  @click="$router.push('/substep-1')">
                    <div class="item-name">Назад</div>
                </div>
            </div>
        </div>
    </div>
    <div class="empty-tovars" v-else>Извините, к сожалению товара нет в наличии. <button class="btn btn-back" @click="$router.push('/substep-1')">Вернуться назад</button></div>
</template>
<script>
export default {
    props: {
        requestData: Object,
        appData: Object
    },
    methods: {
        updatePaperName(data) {
            this.$emit('update-paper-name', data)
        }
    }
}
</script>