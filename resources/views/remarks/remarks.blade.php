@extends ('layout')

@section ('content')
    <div class="content">
        <div class="text-center title">
            Remarques
        </div>
        @foreach($remarks as $remark)
            <p>{{ $remark->getTimestamp() }} {{ $remark->getPerson() }} {{ $remark->getText() }}</p>
        @endforeach
        <div class="text-center links">
            <a href="/">Home</a>
        </div>
    </div>
@stop

@section ('about')
    <p>Me</p>
@stop