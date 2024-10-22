<x-mail::message>
Новый заказ с сайта!

Имя: {{ $order->name }}

Телефон: {{ $order->phone }}
@isset($order->email)
Email: {{ $order->email }}

@endisset
@isset($order->message)
Сообщение: {{ $order->message }}
@endisset
</x-mail::message>
