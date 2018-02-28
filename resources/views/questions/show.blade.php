@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="width: 800px">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="width: 800px">
                    <div class="panel-heading" >{{$question->title}}</div>
                    <div class="panel-body">
                            {!!$question->body!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection