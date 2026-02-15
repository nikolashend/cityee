<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Saada päring / Отправить заявку</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
    <h2 style="color: #7b1f45;">CityEE - Saada päring / Отправить заявку</h2>
    <table style="border-collapse: collapse; width: 100%; max-width: 500px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; width: 150px;">Nimi / Имя:</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['name'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Telefon / Телефон:</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['tel'] }}</td>
        </tr>
        @if(!empty($data['email']))
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Email:</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['email'] }}</td>
        </tr>
        @endif
        @if(!empty($data['comment']))
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Kommentaar / Комментарий:</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['comment'] }}</td>
        </tr>
        @endif
    </table>
    <p style="margin-top: 20px; color: #888; font-size: 12px;">Saadetud veebilehelt cityee.ee</p>
</body>
</html>
