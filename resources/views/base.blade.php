<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MultiSafepay Payments</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.2/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <meta name="theme-color" content="#004A71">
    <link rel="icon" href="favicon.svg" type="image/svg+xml">
    <link rel="alternate icon" href="favicon.ico">
    <link rel="mask-icon" href="favicon-mask.svg" color="red">

    <style>
        .bg-multisafepay {
            --tw-bg-opacity: 1;
            background-color: rgba(0, 74, 113, var(--tw-bg-opacity)) !important;
        }
        .text-multisafepay {
            --tw-text-opacity: 1;
            color: rgba(0, 74, 113, var(--tw-text-opacity));
        }
    </style>
</head>
<body class="bg-gray-50">
<header class="bg-multisafepay p-1 flex justify-center align-center items-center shadow sticky top-0">
    <div class="w-6/12 flex justify-center align-center items-center">
        <img class="h-12 p-2" src="/images/msp-logo-white.svg"/>
    </div>
</header>
<main>
    @section('content')
    @show
</main>
<footer></footer>
</body>
</html>
