@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.courses.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.courses.store'], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('teachers', trans('quickadmin.courses.fields.teachers').'', ['class' => 'control-label']) !!}
                    <button type="button" class="btn btn-primary btn-xs" id="selectbtn-teachers">
                        {{ trans('quickadmin.qa_select_all') }}
                    </button>
                    <button type="button" class="btn btn-primary btn-xs" id="deselectbtn-teachers">
                        {{ trans('quickadmin.qa_deselect_all') }}
                    </button>
                    {!! Form::select('teachers[]', $teachers, old('teachers'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'selectall-teachers' ]) !!}
                    <p class="help-block"></p>
                    @if($errors->has('teachers'))
                        <p class="help-block">
                            {{ $errors->first('teachers') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', trans('quickadmin.courses.fields.title').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('slug', trans('quickadmin.courses.fields.slug').'', ['class' => 'control-label']) !!}
                    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('slug'))
                        <p class="help-block">
                            {{ $errors->first('slug') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('descripition', trans('quickadmin.courses.fields.descripition').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('descripition', old('descripition'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('descripition'))
                        <p class="help-block">
                            {{ $errors->first('descripition') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('price', trans('quickadmin.courses.fields.price').'', ['class' => 'control-label']) !!}
                    {!! Form::text('price', old('price'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('price'))
                        <p class="help-block">
                            {{ $errors->first('price') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('course_image', trans('quickadmin.courses.fields.course-image').'', ['class' => 'control-label']) !!}
                    {!! Form::file('course_image', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('course_image_max_size', 2) !!}
                    {!! Form::hidden('course_image_max_width', 4096) !!}
                    {!! Form::hidden('course_image_max_height', 4096) !!}
                    <p class="help-block"></p>
                    @if($errors->has('course_image'))
                        <p class="help-block">
                            {{ $errors->first('course_image') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('start_date', trans('quickadmin.courses.fields.start-date').'', ['class' => 'control-label']) !!}
                    {!! Form::text('start_date', old('start_date'), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('start_date'))
                        <p class="help-block">
                            {{ $errors->first('start_date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('published', trans('quickadmin.courses.fields.published').'', ['class' => 'control-label']) !!}
                    {!! Form::hidden('published', 0) !!}
                    {!! Form::checkbox('published', 1, old('published', false), []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('published'))
                        <p class="help-block">
                            {{ $errors->first('published') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>    <script>
        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm:ss"
        });
    </script>

    <script>
        $("#selectbtn-teachers").click(function(){
            $("#selectall-teachers > option").prop("selected","selected");
            $("#selectall-teachers").trigger("change");
        });
        $("#deselectbtn-teachers").click(function(){
            $("#selectall-teachers > option").prop("selected","");
            $("#selectall-teachers").trigger("change");
        });
    </script>
@stop