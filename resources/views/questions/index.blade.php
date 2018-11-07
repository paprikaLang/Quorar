@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-6 col-md-offset-4">
                @foreach($questions as $question)
                    <div class="media" style="padding-bottom: 10px;">
                        <div class="media-left">
                            <a href="">
                                <img width="50px;" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">
                                <a href="/questions/{{$question->id}}" style="text-decoration: none; color: black;">
                                    {{$question->title}}
                                </a>
                            </h3>
                            <h5 class="media-bottom" style="color: darkgray;">{{$question->user->name}}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection