@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.lessons.title')</h3>
    @can('lesson_create')
    <p>
        <a href="{{ route('admin.lessons.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('lesson_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.lessons.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.lessons.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($lessons) > 0 ? 'datatable' : '' }} @can('lesson_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('lesson_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.lessons.fields.course')</th>
                        <th>@lang('quickadmin.lessons.fields.title')</th>
                        <th>@lang('quickadmin.lessons.fields.slug')</th>
                        <th>@lang('quickadmin.lessons.fields.lesson-image')</th>
                        <th>@lang('quickadmin.lessons.fields.short-text')</th>
                        <th>@lang('quickadmin.lessons.fields.full-text')</th>
                        <th>@lang('quickadmin.lessons.fields.position')</th>
                        <th>@lang('quickadmin.lessons.fields.downloadable-files')</th>
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
                                @can('lesson_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='course'>{{ $lesson->course->title or '' }}</td>
                                <td field-key='title'>{{ $lesson->title }}</td>
                                <td field-key='slug'>{{ $lesson->slug }}</td>
                                <td field-key='lesson_image'>@if($lesson->lesson_image)<a href="{{ asset(env('UPLOAD_PATH').'/' . $lesson->lesson_image) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $lesson->lesson_image) }}"/></a>@endif</td>
                                <td field-key='short_text'>{!! $lesson->short_text !!}</td>
                                <td field-key='full_text'>{!! $lesson->full_text !!}</td>
                                <td field-key='position'>{{ $lesson->position }}</td>
                                <td field-key='downloadable_files'> @foreach($lesson->getMedia('downloadable_files') as $media)
                                <p class="form-group">
                                    <a href="{{ $media->getUrl() }}" target="_blank">{{ $media->name }} ({{ $media->size }} KB)</a>
                                </p>
                            @endforeach</td>
                                <td field-key='free_lesson'>{{ Form::checkbox("free_lesson", 1, $lesson->free_lesson == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='published'>{{ Form::checkbox("published", 1, $lesson->published == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='section'>{{ $lesson->section->title or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('lesson_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.lessons.restore', $lesson->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('lesson_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.lessons.perma_del', $lesson->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('lesson_view')
                                    <a href="{{ route('admin.lessons.show',[$lesson->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('lesson_edit')
                                    <a href="{{ route('admin.lessons.edit',[$lesson->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('lesson_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.lessons.destroy', $lesson->id])) !!}
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
@stop

@section('javascript') 
    <script>
        @can('lesson_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.lessons.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection