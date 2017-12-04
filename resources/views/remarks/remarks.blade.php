@extends ('layout')

@section ('content')
    <div class="content">
        <div class="text-center title">
            Remarques
        </div>
        @foreach($remarks as $remark)
            <p>{{ $remark->remarkDate }} {{ $remark->author }} {{ $remark->remarkText }}</p>
        @endforeach
        <div class="text-center links">
            <a href="/">Home</a>
        </div>
        <form method="post" action="/remarks/filter">
            {{ csrf_field() }}
            <input type="text" name="needle" />
            <input type="submit" value="Ok" />
        </form>
    </div>
@stop

@section ('about')
    <p>Me</p>
@stop