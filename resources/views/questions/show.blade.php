@extends('layouts.app')
@include('vendor.ueditor.assets')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-size: 18px; font-weight: bolder;">
                        {{$question->title}}
                        @foreach($question->topics as $topic)
                            <a class="topic" href="#">{{$topic->name}}</a>
                        @endforeach
                    </div>
                    <div class="panel-body content">
                            {!!$question->body!!}
                    </div>
                    <br>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/questions/{{$question->id}}/edit">编辑</a></span>
                            <form action="/questions/{{$question->id}}" method="post" class="delete-form">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                        @endif
                    </div>
                    <div style="display: flex; flex-direction: row; margin: 0 20px;">
                        <span class="glyphicon glyphicon-comment"></span>
                        <comments type="question" model="{{$question->id}}" count="{{$question->comments()->count()}}"></comments>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading followers-panel">
                        <h3>{{$question->followers_count}}</h3>
                        <span>关注问题</span>
                    </div>
                    <div class="panel-body" style="font-size: 12px;">
                        {{--<a href="/question/{{$question->id}}/follow" class="btn btn-primary {{Auth::user()->followed($question->id) ? 'btn-success' : ''}}">--}}
                            {{--{{Auth::user()->followed($question->id) ? '已关注' : '关注问题'}}</a>--}}
                        <question-follow-button question="{{$question->id}}"></question-follow-button>
                        <a href="#editor" class="btn btn-warning pull-right">写回答</a>
                        {{--<a href="#editor" class="btn btn-default pull-right">邀请回答</a>--}}
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" >
                          {{$question->answers_count}}个答案
                    </div>
                    <div class="panel-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left" style="display: flex; flex-direction: column;">
                                    <a href="#">
                                        <img width="40" src="{{$answer->user->avatar}}" alt="{{$answer->user->name}}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/users/{{$answer->user->name}}" style="text-decoration: none; color: darkgray;">
                                            {{$answer->user->name}}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-body">
                                    {!!$answer->body!!}
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-body" style="display: flex; flex-direction: row; margin-bottom: 10px;">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                    <user-vote-button answer="{{$answer->id}}" count="{{$answer->votes_count}}"></user-vote-button>
                                    <span class="glyphicon glyphicon-comment" style="margin-left: 16px;"></span>
                                    <comments type="answer" model="{{$answer->id}}" count="{{$answer->comments()->count()}}"></comments>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        @if(Auth::check())
                        <form action="/questions/{{$question->id}}/answer" method="post" style="margin-top: 20px;">
                            {!! csrf_field() !!}
                            <div class="form-group"{{ $errors->has('body') ? 'has-error' : '' }}>
                                <!-- 编辑器容器 避免转义成HTML格式 -->
                                <script id="container" name="body"  type="text/plain" >
                                    {!! old('body')!!}
                                </script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                       <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-success pull-right" type="submit">提交答案</button>
                        </form>
                        @else
                            <a href="{{url('login')}}" class="btn btn-block btn-success">登录提交答案</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading question-follow">
                        <h5>关于作者</h5>
                    </div>
                    <div class="panel-body">
                       <div class="media">
                               <a href="#">
                                   <img width="54px;" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                               </a>
                           <div class="media-body">
                               <h4 style="margin-left: 20px;">{{$question->user->name}}</h4>
                           <div class="media">
                               <div class="media-body user-statics">
                               <div class="statics-item text-center">
                                   <div class="statics-text">问题</div>
                                   <div class="statics-count">{{$question->user->questions_count}}</div>
                               </div>
                               <div class="statics-item text-center">
                                   <div class="statics-text">回答</div>
                                   <div class="statics-count">{{$question->user->answers_count}}</div>
                               </div>
                               <div class="statics-item text-center">
                                   <div class="statics-text">关注者</div>
                                   <div class="statics-count">{{$question->user->followers_count}}</div>
                               </div>
                               </div>
                           </div>
                           </div>
                       </div>
                        <div class="media">
                            <div class="media-body">
                                <user-follow-button user="{{$question->user_id}}"></user-follow-button>
                                <message-send-button user="{{$question->user_id}}"></message-send-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">

        const ue = UE.getEditor('container',{
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection
