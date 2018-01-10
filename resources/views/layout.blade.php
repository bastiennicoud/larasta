<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Larasta</title>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/minimal.css">
    @yield('page_specific_css')
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Larasta</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="/entreprises">Antonio</a></li>
            <li><a href="/evalgrid">Bastien</a></li>
            <li><a href="/wishesMatrix">Benjamin</a></li>
            <li><a href="/listPeople">Davide</a></li>
            <li><a href="/visits">Jean-Yves</a></li>
            <li><a href="#">Julien</a></li>
            <li><a href="/traveltime">Kevin</a></li>
            <li><a href="/reconstages">Nicolas</a></li>
            <li><a href="/contract">Quentin N</a></li>
            <li><a href="#">Quentin R</a></li>
            <li><a href="/synchro">Steven</a></li>
            <li><a href="#">Xavier</a></li>
        </ul>
    </div>
</nav>
@if (!empty($message))
    <div class="alert-info willvanish">{{ $message }}</div>
@endif
<div class="simple-box container-fluid col-md-2 text-center">
    <table class="table table-striped text-left">
        <tr>
            <td><a href="/about"><img alt="Personnes" src="/images/contact.png">Personnes</a></td>
        </tr>
        <tr>
            <td><a href="/entreprises"><img alt="Entreprises" src="/images/company.png">Entreprises</a></td>
        </tr>
        <tr>
            <td><a href="/about"><img alt="Elèves" src="/images/student.png">Elèves</a></td>
        </tr>
        <tr>
            <td><a href="/"><img alt="Places" src="/images/internships.png">Stages</a></td>
        </tr>
        <tr>
            <td><a href="/about"><img alt="News" src="/images/news.png">News</a></td>
        </tr>
        <tr>
            <td><a href="/about"><img alt="Places" src="/images/wishes.png">Souhaits</a></td>
        </tr>
        <tr>
            <td><a href="/about"><img alt="Documents" src="/images/documents.png">Documents</a></td>
        </tr>
        @if (CPNVEnvironment\Environment::currentUser()->getLevel() > 1)
            <tr>
                <td><a href="/about"><img alt="mp" src="/images/MP.png">Admin</a></td>
            </tr>
        @endif
    </table>
    @if (!CPNVEnvironment\Environment::isProd())
        <img id="imgwip" src="/images/wip.png">
    @endif
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