import Cleave from "cleave.js"
import 'cleave.js/dist/addons/cleave-phone.ru'

export default new class PhoneMask {
    constructor() {
        this.phone = '.phone-mask'
        this.init()
    }
    init() {
        const self = this
        document.querySelectorAll(this.phone).forEach(item => {
            new Cleave(item, {
                phone: true,
                phoneRegionCode: 'ru'
            })
        })
    }
}