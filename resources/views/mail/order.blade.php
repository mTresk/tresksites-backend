<x-mail::message>
    Новый заказ с сайта!

    Имя: {{ $order->name }}

    Телефон: {{ $order->phone }}

    Email: {{ $order->email }}

    Сообщение: {{ $order->message }}
</x-mail::message>
