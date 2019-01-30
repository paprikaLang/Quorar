@extends('layouts.app')
@include('vendor.ueditor.assets')
@section('css')
    <link href="{{ asset('css/selectize.default.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑问题</div>
                    <div class="panel-body">
                        <form action="/questions/{{$question->id}}" method="post">
                            {{method_field('PATCH')}}
                            {!! csrf_field() !!}
                            <div class="form-group"{{ $errors->has('title') ? 'has-error' : '' }}>
                                <label for="title">标题</label>
                                <input type="text" value="{{$question->title}}" name="title" class="form-control" placeholder="标题" id="title">
                                @if ($errors->has('title'))
                                    <span class="has-error">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="topics" class="col-md-3 col-form-label">
                                    标签
                                </label>
                                <select name="topics[]" id="topics" class="form-control" multiple>
                                    @foreach ($allTopics as $topic)
                                        <option @if (in_array($topic, [])) selected @endif value="{{ $topic }}">
                                            {{ $topic }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group"{{ $errors->has('title') ? 'has-error' : '' }}>
                                <label for="title">描述</label>
                                <!-- 编辑器容器 -->
                                <script id="container" name="body"  type="text/plain" >
                                    {{--避免转义成HTML格式--}}
                                    {!! $question->body !!}
                                </script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                       <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-success pull-right" type="submit">提交问题</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@section('js')
    <script src="{{ asset('js/selectize.min.js') }}"></script>
    <script>
        $(function() {
            $("#topics").selectize({
                create: true
            });
        });
    </script>
    <script type="text/javascript">
        var ue = UE.getEditor('container',{
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
@endsection