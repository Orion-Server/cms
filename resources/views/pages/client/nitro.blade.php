<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Nitro Client - {{ getSetting('hotel_name') }}</title>

    @vite(['resources/scss/app.scss'])
</head>
<body class="w-full h-full">
    <main>
        <iframe
            id="nitroclient"
            src="{{ $nitroClientUrl }}?sso={{ $authTicket }}"
            class="w-full h-full overflow-hidden absolute left-0 top-0 border-none m-0 p-0"
        ></iframe>
    </main>

    @vite(['resources/js/client.js'])
</body>
</html>
