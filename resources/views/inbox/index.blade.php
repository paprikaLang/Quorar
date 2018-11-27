@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">私信列表</div>

                    <div class="panel-body">
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
                            <div class="media-body {{ $messageGroup->first()->unreadClass() ? 'unread' : '' }}" style="padding: 2px 10px;">
                                <h4 class="media-heading">
                                    {{--unique('dialog_id')省略了from1 to6 和 from6 to1的区分--}}
                                    {{--@if(Auth::id() == $key)--}}
                                        {{--to--}}
                                    {{--@else--}}
                                        {{--from--}}
                                    {{--@endif--}}
                                    <a href="#" style="font-size: 18px; color: #ff0000" >
                                        @if(Auth::id() == $key)
                                            {{ $messageGroup->first()->toUser->name }}
                                        @else
                                            {{ $messageGroup->first()->fromUser->name }}
                                        @endif
                                    </a>
                                </h4>
                                <p style="font-size: 12px;">
                                    <a href="/inbox/{{$messageGroup->last()->dialog_id }}" style="color: #888a85;">
                                        {{ $messageGroup->last()->body }}  <span class="pull-right">最新 {{$messageGroup->last()->created_at->format('m-d H:i')}}</span>
                                    </a>
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
