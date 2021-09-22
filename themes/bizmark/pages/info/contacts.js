//  import map from '../../partials/element/map/contacts'

export default new class Contacts {
    constructor() {
        this.contactForm = '#feedbackForm'
        this.successModal = '#success'

        this.init()
    }
    init() {
        $(this.contactForm).submit(target => {
            target.preventDefault();

            $.oc.stripeLoadIndicator.show();

            if (this.xhr) {
                this.xhr.abort();
            }

            let form = $(target.currentTarget),
                button = form.find('button[type="submit"]');

            button.attr('disabled', true);

            this.xhr = form.request('MakeOrder::onOrder', {
                success: () => {
                    $(this.successModal).modal('show');
                    $(this.contactForm)[0].reset();
                },
                error: () => $.oc.flashMsg({
                    text: 'Произошла ошибка при отправке заявки. Попробуйте позднее, или обратитесь к нам по телефону указанному в контактах.',
                    class: 'error',
                    interval: 20
                }),
                complete: () => {
                    $.oc.stripeLoadIndicator.hide()
                    button.attr('disabled', false);
                }
            })
            ym(72877768, 'reachGoal', 'zayavka_kontakt'); return true;  
        })
    }
}