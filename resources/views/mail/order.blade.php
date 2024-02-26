<x-mail::message>
    Новый заказ с сайта!

    Имя: {{ $mailData['name'] }}

    Телефон: {{ $mailData['phone'] }}

    Email: {{ $mailData['email'] }}

    Сообщение: {{ $mailData['message'] }}
</x-mail::message>
