@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.sections.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.sections.fields.course')</th>
                            <td field-key='course'>{{ $section->course->title or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.sections.fields.title')</th>
                            <td field-key='title'>{{ $section->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.sections.fields.descripition')</th>
                            <td field-key='descripition'>{!! $section->descripition !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.sections.fields.image')</th>
                            <td field-key='image'>@if($section->image)<a href="{{ asset(env('UPLOAD_PATH').'/' . $section->image) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $section->image) }}"/></a>@endif</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#lessons" aria-controls="lessons" role="tab" data-toggle="tab">Lessons</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="lessons">
<table class="table table-bordered table-striped {{ count($lessons) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.lessons.fields.course')</th>
                        <th>@lang('quickadmin.lessons.fields.title')</th>
                        <th>@lang('quickadmin.lessons.fields.slug')</th>
                        <th>@lang('quickadmin.lessons.fields.lesson-image')</th>
                        <th>@lang('quickadmin.lessons.fields.short-text')</th>
                        <th>@lang('quickadmin.lessons.fields.full-text')</th>
                        <th>@lang('quickadmin.lessons.fields.position')</th>
                        <th>@lang('quickadmin.lessons.fields.free-lesson')</th>
                        <th>@lang('quickadmin.lessons.fields.published')</th>
                        <th>@lang('quickadmin.lessons.fields.section')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($lessons) > 0)
            @foreach ($lessons as $lesson)
                <tr data-entry-id="{{ $lesson->id }}">
                    <td field-key='course'>{{ $lesson->course->title or '' }}</td>
                                <td field-key='title'>{{ $lesson->title }}</td>
                                <td field-key='slug'>{{ $lesson->slug }}</td>
                                <td field-key='lesson_image'>@if($lesson->lesson_image)<a href="{{ asset(env('UPLOAD_PATH').'/' . $lesson->lesson_image) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $lesson->lesson_image) }}"/></a>@endif</td>
                                <td field-key='short_text'>{!! $lesson->short_text !!}</td>
                                <td field-key='full_text'>{!! $lesson->full_text !!}</td>
                                <td field-key='position'>{{ $lesson->position }}</td>
                                <td field-key='downloadable_files'>@if($lesson->downloadable_files)<a href="{{ asset(env('UPLOAD_PATH').'/' . $lesson->downloadable_files) }}" target="_blank">Download file</a>@endif</td>
                                <td field-key='free_lesson'>{{ Form::checkbox("free_lesson", 1, $lesson->free_lesson == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='published'>{{ Form::checkbox("published", 1, $lesson->published == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='section'>{{ $lesson->section->title or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['lessons.restore', $lesson->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['lessons.perma_del', $lesson->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('view')
                                    <a href="{{ route('lessons.show',[$lesson->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('edit')
                                    <a href="{{ route('lessons.edit',[$lesson->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['lessons.destroy', $lesson->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="16">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.sections.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop
