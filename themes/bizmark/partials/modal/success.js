export default new class SuccessModal {
    constructor() {
        this.successModal = '#success'
        this.init()
    }
    init() {
        
        if($('.cart-page') != undefined) {
            $(this.successModal).on('hide.bs.modal', function (e) {
                location.href = '/'
            })
        }
        
    }
}