<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSectionsRequest;
use App\Http\Requests\Admin\UpdateSectionsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class SectionsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Section.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('section_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('section_delete')) {
                return abort(401);
            }
            $sections = Section::onlyTrashed()->get();
        } else {
            $sections = Section::all();
        }

        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating new Section.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('section_create')) {
            return abort(401);
        }
        
        $courses = \App\Course::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.sections.create', compact('courses'));
    }

    /**
     * Store a newly created Section in storage.
     *
     * @param  \App\Http\Requests\StoreSectionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectionsRequest $request)
    {
        if (! Gate::allows('section_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $section = Section::create($request->all());



        return redirect()->route('admin.sections.index');
    }


    /**
     * Show the form for editing Section.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('section_edit')) {
            return abort(401);
        }
        
        $courses = \App\Course::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $section = Section::findOrFail($id);

        return view('admin.sections.edit', compact('section', 'courses'));
    }

    /**
     * Update Section in storage.
     *
     * @param  \App\Http\Requests\UpdateSectionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSectionsRequest $request, $id)
    {
        if (! Gate::allows('section_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $section = Section::findOrFail($id);
        $section->update($request->all());



        return redirect()->route('admin.sections.index');
    }


    /**
     * Display Section.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('section_view')) {
            return abort(401);
        }
        
        $courses = \App\Course::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');$lessons = \App\Lesson::where('section_id', $id)->get();

        $section = Section::findOrFail($id);

        return view('admin.sections.show', compact('section', 'lessons'));
    }


    /**
     * Remove Section from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('section_delete')) {
            return abort(401);
        }
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('admin.sections.index');
    }

    /**
     * Delete all selected Section at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('section_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Section::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Section from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('section_delete')) {
            return abort(401);
        }
        $section = Section::onlyTrashed()->findOrFail($id);
        $section->restore();

        return redirect()->route('admin.sections.index');
    }

    /**
     * Permanently delete Section from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('section_delete')) {
            return abort(401);
        }
        $section = Section::onlyTrashed()->findOrFail($id);
        $section->forceDelete();

        return redirect()->route('admin.sections.index');
    }
}
