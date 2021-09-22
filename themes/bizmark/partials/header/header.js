export default new class MobileMenu {
    constructor() {
        this.burger = '.burger'
        this.navMenu = '.nav-menu'
        this.init()
    }

    init() {
        let self = this

        $(this.burger).on('click', function() {
            $(self.navMenu).toggleClass('show')
            if($(self.navMenu).hasClass('show')) {
                $('body').css({
                    'overflow': 'hidden'
                })
            } else {
                $('body').css({
                    'overflow': ''
                })
            }
        })
    }
}