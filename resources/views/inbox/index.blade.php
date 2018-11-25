@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">私信列表</div>

                    <div class="panel-body">
                        {{--当前ID:6 -> {1:[{6,1},{6,1}],6:[{1,6},{1,6},{7,6}]}, key {1,6}--}}
                        @foreach($messages as $key => $messageGroup)
                            <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    @if(Auth::id() == $key)
                                        <img src="{{ $messageGroup->first()->toUser->avatar }}" width="40px;" alt="" />
                                    @else
                                        <img src="{{ $messageGroup->first()->fromUser->avatar }}" width="40px;" alt="" />
                                    @endif

                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    @if(Auth::id() == $key)
                                        to
                                    @else
                                        from
                                    @endif
                                    <a href="#" style="font-size: 18px; color: #ff0000" >
                                        @if(Auth::id() == $key)
                                            {{ $messageGroup->first()->toUser->name }}
                                        @else
                                            {{ $messageGroup->first()->fromUser->name }}
                                        @endif
                                    </a>
                                </h4>
                                <p style="font-size: 12px;">
                                    @if(Auth::id() == $key)
                                        <a href="/inbox/to/{{$messageGroup->first()->toUser->id }}" style="color: #888a85;" >
                                            {{ $messageGroup->last()->body }}
                                        </a>
                                    @else
                                        <a href="/inbox/from/{{$messageGroup->first()->fromUser->id }}" style="color: #888a85;">
                                            {{ $messageGroup->last()->body }}
                                        </a>
                                    @endif

                                </p>
                            </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
