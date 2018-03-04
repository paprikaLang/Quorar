@extends('layouts.app')
@section('content')
    @include('vendor.ueditor.assets')
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
                                <select name="topics[]" class="js-example-placeholder-multiple form-control" multiple="multiple" >
                                    @foreach($question->topics as $topic)
                                        <option value="{{$topic->id}}" selected="selected">{{$topic->name}}</option>
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
    <!-- 实例化编辑器 -->
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
        $(document).ready(function () {
//            $('.js-example-basic-single').select2();
            function formatTopic (topic) {
                return "<li class='select2-result-repository '>" +
                "<li class='select2-result-repository__meta'>" +
                "<li class='select2-result-repository__title'>" +
                topic.name ? topic.name : "Laravel"   +
                    "</li></li></li>";
            }
            function formatTopicSelection (topic) {
                return topic.name || topic.text;
            }

            $(".js-example-placeholder-multiple").select2({
                tags: true,
                ajax: {
                    url: "/api/topics",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // search term
//                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
//                        params.page = params.page || 1;

                        return {
                            results: data
//                            pagination: {
//                                more: (params.page * 30) < data.total_count
//                            }
                        };
                    },
                    cache: true
                },
                placeholder: '选择相关话题',
                maximumSelectionLength: 2,
                minimumInputLength: 2,
//                allowClear: true,
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                templateResult: formatTopic,
                templateSelection: formatTopicSelection
            });
        })
    </script>
@endsection
@endsection