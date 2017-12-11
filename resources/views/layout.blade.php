<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Larasta</title>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>

@if (!empty($message))
    <div class="alert-info willvanish">{{ $message }}</div>
@endif

<div class="container-fluid text-center">
    @yield ('content')
</div>
</body>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/js/appjs.js"></script>

@yield('page_specific_js')
</html>