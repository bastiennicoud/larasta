{{-- Author: Xavier Carrel --}}
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Larasta</title>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/minimal.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    @yield('page_specific_css')
</head>
<body>
@if (!empty($message))
    <div class="alert-info willvanish">{{ $message }}</div>
@endif
<!-- Verifie si un message flash est present dans la session -->
@if (session('status'))
    <div class="alert-info willvanish">
        {{ session('status') }}
    </div>
@endif
<div id="side-menu" class="simple-box container-fluid col-md-2 text-center">
    <table class="table table-striped text-left larastable">
        <tr>
            <td><a href="/listPeople"><img alt="Personnes" src="/images/contact.png">Personnes</a></td>
        </tr>
        <tr>
            <td><a href="/entreprises"><img alt="Entreprises" src="/images/company.png">Entreprises</a></td>
        </tr>
        <tr>
            <td><a href="/"><img alt="Places" src="/images/internships.png">Stages</a></td>
        </tr>
        <tr>
            <td><a href="/visits"><img alt="Places" src="/images/internships.png">Visites</a></td>
        </tr>
        <tr>
            <td><a href="/about"><img alt="News" src="/images/news.png">News</a></td>
        </tr>
        <tr>
            <td><a href="/wishesMatrix"><img alt="Places" src="/images/wishes.png">Souhaits</a></td>
        </tr>
        <tr>
            <td><a href="/documents"><img alt="Documents" src="/images/documents.png">Documents</a></td>
        </tr>
        @if (CPNVEnvironment\Environment::currentUser()->getLevel() > 1)
            <tr>
                <td><a href="/admin"><img alt="mp" src="/images/MP.png">Admin</a></td>
            </tr>
        @endif
    </table>
    @if (!CPNVEnvironment\Environment::isProd())
        <img id="imgwip" src="/images/wip.png">
    @endif
    <div class="version">v{{ config('app.version') }}</div>
</div>
<div class="container-fluid text-center col-md-10">
    @yield ('content')
</div>
</body>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/js/appjs.js"></script>
@yield('page_specific_js')
</html>