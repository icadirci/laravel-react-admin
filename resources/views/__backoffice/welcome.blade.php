<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width, shrink-to-fit=no" />
    <meta name="description" content="{{ config('app.description') }}">
    <meta name="theme-color" content="#00AEDF">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:description" content="{{ config('app.description') }}">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:image" content="">

    @if (config('app.env') === 'production')
        <meta name="sw-filepath" content="/service-worker.js">
    @endif

    <meta name="TELESCOPE_ENABLED" content="{{ config('telescope.enabled') }}">

    <!-- Title -->
    <title>{{ config('app.name') }}</title>

    <!-- Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

    <!-- Manifest -->
    <link rel="manifest" href="/manifest.json">

    <!-- Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <!-- Styles -->
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto';
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #initial-content {
            display: none;
            background-color: #0000008a;
        }

        .kanban-board {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 20px;
            width: 100%;
        }

        .kanban-column {
            width: 30%;
            min-height: 300px;
            background: #f4f4f4;
            padding: 10px;
            border-radius: 8px;
            transition: 500ms;
        }

        .kanban-column:hover {
            background: #ccc
        }

        .kanban-task {
            background: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            cursor: grab;
            font-size: :13px;
        }

        /* Modal Stili */
        .modal {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .modal h2 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        /* Input ve Textarea */
        .modal input,
        .modal textarea,
        .modal select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .modal textarea {
            height: 80px;
            resize: none;
        }

        /* Butonlar */
        .modal button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .modal button:first-of-type {
            background: #28a745;
            color: white;
        }

        .modal button:first-of-type:hover {
            background: #218838;
        }

        .modal button:last-of-type {
            background: #dc3545;
            color: white;
        }

        .modal button:last-of-type:hover {
            background: #c82333;
        }

        .button-grp {
            display: flex;
            width: 100%;
            border-top: 1px solid #ccc;
            padding-top: 10px;

        }

        .button-grp button {
            flex: 1;
            margin-right: 10px;
            border: none;
            padding: 10px;
            font-weight: bold;
            border-radius: 5px;
            box-shadow: 0px 0px 15px #ccc;
            cursor: pointer;

        }

        .button-grp button:last-child {
            margin-right: 0px;
        }

        .delete-btn {
            background: #f44336;
            color: #fff;
        }

        .update-btn {
            background: #FF9800;
            color: #fff;
        }
    </style>
</head>

<body>
    <noscript>
        <div class="full-height flex-center">
            <h1 class="noscript-message">
                You need JavaScript enabled to run this app.
            </h1>
        </div>
    </noscript>

    <div id="initial-content" class="full-height flex-center">
        <!--
                Temporary content shown on page load,
                this is a convenient way to make the visitors of the site
                feel that they have reached the site.
            -->
    </div>

    <div id="root">
        <!--
                This is the root node that acts as the wrapper where
                the application will render the elements
            -->
    </div>

    <!-- Scripts -->
    <script>
        document.getElementById('initial-content').style.display = 'block';
    </script>

    <script src="{{ _asset('js/vendor.js') }}" defer></script>
    <script src="{{ _asset('js/backoffice.js') }}" defer></script>
</body>

</html>
