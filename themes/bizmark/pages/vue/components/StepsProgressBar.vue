<template>
    <div v-if="winWidth > 992" class="layout-steps-nav">
        <div class="steps-nav-wrap">
            <div class="step-nav-item-wrap" :class="{ active: !appData.substep1 }">
                <div class="step-nav-item">
                    <div v-if="!appData.substep1" class="step-nav-number">1</div>
                    <div v-else class="step-nav-number"><i class="fas fa-check"></i></div>

                    <div v-if="!appData.step1" class="step-nav-name">Выберите тип упаковки</div>
                    <div v-else class="step-nav-item-data">
                        <div class="item-data">
                            <span class="data-name">Тип упаковки:</span>
                            <span class="data-value">{{ appData.boxName.name }}</span>
                        </div>
                        <div v-if="appData.substep1" class="item-data">
                            <span class="data-name">Артикул:</span>
                            <span class="data-value">{{ appData.boxType.code }}</span>
                        </div>
                        <div v-if="appData.substep1" class="change-step-data" @click="$router.push('/')">Изменить</div>
                    </div>
                </div>
            </div>
            <div class="step-nav-item-wrap" :class="{ active: appData.substep1 && !appData.substep2 && !appData.step3 && !appData.step4 }">
                <div class="step-nav-item">
                    <div v-if="!appData.step2 || !appData.substep2" class="step-nav-number">2</div>
                    <div v-else class="step-nav-number"><i class="fas fa-check"></i></div>

                    <div v-if="!appData.step2 " class="step-nav-name">Выберите тип картона</div>
                    <div v-else class="step-nav-item-data">
                        <div class="item-data">
                            <span class="data-name">Тип картона:</span>
                            <span class="data-value">{{ appData.paperName.name }}</span>
                        </div>
                        <div v-if="appData.substep2" class="item-data">
                            <span class="data-name">Артикул:</span>
                            <span class="data-value">{{ appData.paperType.code }}</span>
                        </div>
                        <div v-if="appData.substep2" class="change-step-data" @click="$router.push('/step-2')">Изменить</div>
                    </div>
                </div>
            </div>
            <div class="step-nav-item-wrap" :class="{ active: appData.substep1 && appData.substep2 && !appData.step3 && !appData.step4 }">
                <div class="step-nav-item">
                    <div v-if="!appData.step3" class="step-nav-number">3</div>
                    <div v-else class="step-nav-number"><i class="fas fa-check"></i></div>

                    <div v-if="!appData.step3" class="step-nav-name">Параметры упаковки</div>
                    <div v-else class="step-nav-item-data">
                        <div class="item-data">
                            <span class="data-size">
                                <span class="data-name">Д:</span>
                                <span class="data-value">{{ appData.length }} мм</span>;
                            </span>
                            <span class="data-size">
                                <span class="data-name">Ш:</span>
                                <span class="data-value">{{ appData.width }} мм</span>;
                            </span>
                            <span class="data-size">
                                <span class="data-name">В:</span>
                                <span class="data-value">{{ appData.height }} мм</span>;
                            </span>
                        </div>
                        <div class="item-data">
                            <span class="data-name">Принт:</span>
                            <span class="data-value"> {{ appData.printType.name }}</span>
                        </div>
                        <div class="item-data">
                            <!-- <span class="data-name">Ламинация:</span> -->
                            <span class="data-value"> {{ appData.laminationType.name }}</span>
                        </div>
                        <div class="change-step-data" @click="$router.push('/step-3')">Изменить</div>
                    </div>
                </div>
            </div>
            <div class="step-nav-item-wrap" :class="{ active: appData.substep1 && appData.substep2 && appData.step3 && !appData.step4 }">
                <div class="step-nav-item">
                    <div v-if="!appData.step4" class="step-nav-number">4</div>
                    <div v-else class="step-nav-number"><i class="fas fa-check"></i></div>

                    <div v-if="!appData.step4" class="step-nav-name">Тираж</div>
                    <div v-else class="step-nav-item-data">
                        <div class="item-data">
                            <span class="data-name">Тираж:</span>
                            <span class="data-value">{{ appData.boxCount }} шт</span>
                        </div>
                        <div class="item-data">
                            <span class="data-name">Цена за 1 шт. :</span>
                            <span class="data-value">{{ appData.priceOneBox }} <i class="fas fa-ruble-sign"></i></span>
                        </div>
                        <div class="item-data">
                            <span class="data-name">Цена тиража:</span>
                            <span class="data-value">{{ appData.price }} <i class="fas fa-ruble-sign"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="loading-line">
            <div class="progress-line" :style="{ width: appData.progressLine + '%'}"></div>
        </div>
    </div>
    <div v-else class="layout-steps-nav">
        <div class="steps-nav-wrap">
            <div class="step-nav-item-wrap" :class="{ active: !appData.substep1 }">
                <div class="step-nav-item">
                    <div v-if="!appData.substep1" class="step-nav-number">1</div>
                    <div v-else class="step-nav-number"><i class="fas fa-check"></i></div>

                    <div v-if="!appData.step1" class="step-nav-name">Выберите тип упаковки</div>
                    <div v-else class="step-nav-item-data">
                        <div class="item-data">
                            <span class="data-name">Тип упаковки:</span>
                            <span class="data-value">{{ appData.boxName.name }}</span>
                        </div>
                        <div v-if="appData.substep1" class="item-data">
                            <span class="data-name">Артикул:</span>
                            <span class="data-value">{{ appData.boxType.code }}</span>
                        </div>
                        <div v-if="appData.substep1" class="change-step-data" @click="$router.push('/')">Изменить</div>
                    </div>
                </div>
            </div>
            <div v-if="appData.substep1" class="step-nav-item-wrap" :class="{ active: appData.substep1 && !appData.substep2 && !appData.step3 && !appData.step4 }">
                <div class="step-nav-item">
                    <div v-if="!appData.step2 || !appData.substep2" class="step-nav-number">2</div>
                    <div v-else class="step-nav-number"><i class="fas fa-check"></i></div>

                    <div v-if="!appData.step2 " class="step-nav-name">Выберите тип картона</div>
                    <div v-else class="step-nav-item-data">
                        <div class="item-data">
                            <span class="data-name">Тип картона:</span>
                            <span class="data-value">{{ appData.paperName.name }}</span>
                        </div>
                        <div v-if="appData.substep2" class="item-data">
                            <span class="data-name">Артикул:</span>
                            <span class="data-value">{{ appData.paperType.code }}</span>
                        </div>
                        <div v-if="appData.substep2" class="change-step-data" @click="$router.push('/step-2')">Изменить</div>
                    </div>
                </div>
            </div>
            <div v-if="appData.substep2" class="step-nav-item-wrap" :class="{ active: appData.substep1 && appData.substep2 && !appData.step3 && !appData.step4 }">
                <div class="step-nav-item">
                    <div v-if="!appData.step3" class="step-nav-number">3</div>
                    <div v-else class="step-nav-number"><i class="fas fa-check"></i></div>

                    <div v-if="!appData.step3" class="step-nav-name">Параметры упаковки</div>
                    <div v-else class="step-nav-item-data">
                        <div class="item-data">
                            <span class="data-size">
                                <span class="data-name">Д:</span>
                                <span class="data-value">{{ appData.length }} мм</span>;
                            </span>
                            <span class="data-size">
                                <span class="data-name">Ш:</span>
                                <span class="data-value">{{ appData.width }} мм</span>;
                            </span>
                            <span class="data-size">
                                <span class="data-name">В:</span>
                                <span class="data-value">{{ appData.height }} мм</span>;
                            </span>
                        </div>
                        <div class="item-data">
                            <span class="data-name">Принт:</span>
                            <span class="data-value"> {{ appData.printType.name }}</span>
                        </div>
                        <div class="item-data">
                            <!-- <span class="data-name">Ламинация:</span> -->
                            <span class="data-value"> {{ appData.laminationType.name }}</span>
                        </div>
                        <div class="change-step-data" @click="$router.push('/step-3')">Изменить</div>
                    </div>
                </div>
            </div>
            <div v-if="appData.step3" class="step-nav-item-wrap" :class="{ active: appData.substep1 && appData.substep2 && appData.step3 && !appData.step4 }">
                <div class="step-nav-item">
                    <div v-if="!appData.step4" class="step-nav-number">4</div>
                    <div v-else class="step-nav-number"><i class="fas fa-check"></i></div>

                    <div v-if="!appData.step4" class="step-nav-name">Тираж</div>
                    <div v-else class="step-nav-item-data">
                        <div class="item-data">
                            <span class="data-name">Тираж:</span>
                            <span class="data-value">{{ appData.boxCount }} шт</span>
                        </div>
                        <div class="item-data">
                            <span class="data-name">Цена за 1 шт. :</span>
                            <span class="data-value">{{ appData.priceOneBox }} <i class="fas fa-ruble-sign"></i></span>
                        </div>
                        <div class="item-data">
                            <span class="data-name">Цена тиража:</span>
                            <span class="data-value">{{ appData.price }} <i class="fas fa-ruble-sign"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="loading-line">
            <div class="progress-line" :style="{ width: appData.progressLine + '%'}"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        appData: Object,
        requestData: Object,
        winWidth: Number
    }
}
</script>

<style lang="scss">
    @import '../../../build/scss/variables';
    
    .steps-nav-wrap {
        display: flex;
        justify-content: space-between;
        margin: 0 -10px;
    }
    
    .step-nav-item-wrap {
        padding: 0 10px;
    }
    // .step-nav-item-wrap.active .step-nav-item {
    //      align-items: center;
    // }
    .step-nav-item {
        display: flex;
        align-items: flex-start;
        .step-nav-number {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            border-radius: 50%;
            min-width: 27px;
            height: 27px;
            background-color: $dark_green;
            font-weight: 700;
            font-size: 15px;
        }
        .step-nav-name {
            margin-left: 10px;
        }
    }
    .step-nav-item-wrap.active {
        .step-nav-number {
            background-color: $light_green;
        }
    }
    .change-step-data {
        padding: 6px 14px;
        display: inline-block;
        font-size: 14px;
        font-weight: 500;
        color: #fff;
        background-color: $primary_btn;
        border-radius: 20px;
        transition: all .2s ease-in-out;
        margin-top: 10px;
        cursor: pointer;
        &:hover {
            background-color: $active_btn;
        }
    }
    .step-nav-item-data {
        margin-left: 10px;
        .item-data {
            display: flex;
            flex-wrap: wrap;
            font-size: 13px;
            margin-bottom: 5px;
        }
        .data-size {
            display: flex;
            margin-right: 5px;
            &:last-child {
                margin-right: 0;
            }
        }
        .data-name {
            margin-right: 3px;
        }
        .data-value {
            font-weight: 700;
        }
    }
    .progress-line {
        position: absolute;
        left: 0;
        top: -1px;
        bottom: -1px;
        background: linear-gradient(90.02deg, #3B7A17 42.13%, #7DC950 86.65%);
        transition: all 1s ease-in-out;
        border-radius: 20px;
    }
    .loading-line {
        margin: 40px 0;
        position: relative;
        background-color: #BDC6B9;
        height: 5px;
        border-radius: 20px;
    }
    @media(max-width: 991px) {
        .layout-steps-nav {
            .steps-nav-wrap {
                flex-direction: column;
            }
            .step-nav-item-wrap {
                margin-bottom: 30px;
            }
            .change-step-data {
                margin-top: 10px;
            }
            .loading-line {
                display: none;
            }
        }
        // .mobile-step-wrap {
        //     display: flex;
        //     justify-content: space-between;

        // }
    }
</style>