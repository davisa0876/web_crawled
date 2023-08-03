<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Your custom CSS file -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Move the brand/logo to the left side -->
        <a class="navbar-brand" href="/">Crawler Challenger</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Move the menu options to the left side -->
            <ul class="navbar-nav">
                <!-- Dropdown menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/">Home</a>
                        <a class="dropdown-item" href="/web-crawler">Crawler Form</a>
                        <a class="dropdown-item" href="/web-crawler/agencyanalytics">Crawler AgencyAnalytics</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('container')
    </div>

<!-- Include jQuery (Must be before Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Your custom JavaScript file -->
<script src="{{ asset('js/web_crawler.js') }}"></script>
<!-- Custom JavaScript -->
</body>
</html>
