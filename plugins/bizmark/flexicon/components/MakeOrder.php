<?php namespace BizMark\Flexicon\Components;

use Input, Flash, Mail;
use Cms\Classes\ComponentBase;

use BizMark\Flexicon\Models\Order;
use BizMark\Flexicon\Models\Settings;
use October\Rain\Exception\AjaxException;

class MakeOrder extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'MakeOrder Component',
            'description' => 'No description provided yet...'
        ];
    }

//    public function init()
//    {
//        $requisitesUploader = $this->addComponent(
//            'Responsiv\Uploader\Components\FileUploader',
//            'requisitesUploader',
//            [
//                'placeholderText' => 'Прикрепить реквизиты компании <i class="fas fa-upload"></i>',
//                'deferredBinding' => true
//            ]
//        );
//        $designUploader = $this->addComponent(
//            'Responsiv\Uploader\Components\FileUploader',
//            'designUploader',
//            [
//                'placeholderText' => 'Прикрепить файл дизайна <i class="fas fa-upload"></i>',
//                'deferredBinding' => true
//            ]
//        );
//
//        $requisitesUploader->bindModel('requisites', new Order());
//        $designUploader->bindModel('design', new Order());
//    }

    public function onOrder()
    {
        $data = Input::all();

        try {
            $order = new Order;
            $order->type = e(array_get($data, 'type'));
            $order->organization = e(array_get($data, 'organization'));
            $order->full_name = e(array_get($data, 'full_name'));
            $order->email = e(array_get($data, 'email'));
            $order->phone = e(array_get($data, 'phone'));
            $order->comment = e(array_get($data, 'comment'));

            if (array_has($data, 'cart') && array_has($data, 'total_price')) {
                $order->cart = array_get($data, 'cart');
                $order->total_price = array_get($data, 'total_price');
            }

            trace_log(array_get($data, '_session_key'));

            $order->save(null, array_get($data, '_session_key'));

            $mailData = [
                'number' => $order->number,
                'created_at' => $order->created_at->timezone('Europe/Moscow')->format('Y-m-d H:i:s'),
                'organization' => $order->organization,
                'full_name' => $order->full_name,
                'email' => $order->email,
                'phone' => $order->phone,
                'comment' => $order->comment,
                'cart' => $order->cart
            ];

            if (!empty($order->total_price)) {
                $mailData['total_price'] = $order->total_price;
            }

            try {
                Mail::send('bizmark.flexicon::mail.order', $mailData, function($message) use ($order){
                    $message->to(Settings::get('email'), 'Администратор');
                    if (!empty($order->requisites)) {
                        foreach ($order->requisites as $file) {
                            $message->attach(storage_path('app/'.$file->getDiskPath()));
                        }
                    }
                    if (!empty($order->designs)) {
                        foreach ($order->designs as $file) {
                            $message->attach(storage_path('app/'.$file->getDiskPath()));
                        }
                    }
                });
            } catch (\Exception $ex) {
                trace_log($ex);
            }

            try {
                Mail::send('bizmark.flexicon::mail.order', $mailData, function($message) use ($order){
                    $message->to($order->email, $order->full_name);
                    if (!empty($order->requisites)) {
                        foreach ($order->requisites as $file) {
                            $message->attach(storage_path('app/'.$file->getDiskPath()));
                        }
                    }
                    if (!empty($order->designs)) {
                        foreach ($order->designs as $file) {
                            $message->attach(storage_path('app/'.$file->getDiskPath()));
                        }
                    }
                });
            } catch (\Exception $ex) {
                trace_log($ex);
            }

            // if (!empty($order->cart)) {
            //     return [
            //         '#successWrap' => $this->renderPartial('modal/success-body', [
            //             'order' => $order,
            //             'message' => 'Спасибо за Ваш заказ! Мы свяжемся с вами в ближайшее время!'
            //         ])
            //     ];
            // }

            return [
                '#successWrap' => $this->renderPartial('modal/success-body', [
                    'order' => $order,
                    'message' => 'Спасибо за Ваш заказ! Мы свяжемся с вами в ближайшее время!'
                ])
            ];

        } catch (\Exception $ex) {
            trace_log($ex);
            throw new AjaxException(['X_OCTOBER_ERROR_MESSAGE' => 'Произошла ошибка']);
        }
    }
}
