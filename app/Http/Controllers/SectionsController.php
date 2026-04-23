<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
class SectionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // 1. صلاحية العرض
            new Middleware('permission:الاقسام', only: ['index','show']),  ////

            // 2. صلاحية الإضافة
            new Middleware('permission:اضافة قسم', only: ['create', 'store']), ////

            // 3. صلاحية التعديل
            new Middleware('permission:تعديل قسم', only: ['edit', 'update']),

            // 4. صلاحية الحذف
            new Middleware('permission:حذف قسم', only: ['destroy']),   ////

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();

        return view('sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'section_name' => ['required', 'string', 'max:255', 'unique:sections,section_name'],
                'description'  => ['nullable', 'string', 'max:1000'],
            ],
            [
                'section_name.required' => 'اسم القسم مطلوب',
                'section_name.unique'   => 'اسم القسم مستخدم من قبل',
                'section_name.max'      => 'اسم القسم لا يمكن أن يتجاوز 255 حرف',
                'description.max'       => 'الوصف لا يمكن أن يتجاوز 1000 حرف',
            ]
        );


        // $sections = new sections;
        // $sections->section_name = $request->section_name;
        // $sections->description = $request->description;
        // $sections->created_by = auth()->user()->name;
        // $sections->save();

        $sections = sections::create([
            'section_name' => $validated['section_name'],
            'description'  => $validated['description'] ?? null,
            'created_by'   => auth()->user()->name,   // اسم اليوزر الحالي
        ]);

        // $sections = sections::create([
        //     'section_name' => $validated->section_name,
        //     'description' => $validated->description,
        //     'created_by' => auth()->user()->name,
        // ]);

        //return redirect(route('sections.index'));
        //session()->flash('success', 'نجاح');
        return redirect(route('sections.index'))->with('success', 'تم إضافة القسم بنجاح');
    }


    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $section)
    {
        // dd($sections -> section_name);
        // $sections = sections::findOrFail($id);
        // $sections = sections::find($id);
        // if (is_null($sections)) {
        //     return redirect()->route('sections.index');
        // };

        return view('sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sections $section)
    {
        $validated = $request->validate(
            [
                'section_name' => ['required', 'string', 'max:255', 'unique:sections,section_name,' . $section->id],
                'description'  => ['nullable', 'string', 'max:1000'],
            ],
            [
                'section_name.required' => 'اسم القسم مطلوب',
                'section_name.unique'   => 'اسم القسم مستخدم من قبل',
                'section_name.max'      => 'اسم القسم لا يمكن أن يتجاوز 255 حرف',
                'description.max'       => 'الوصف لا يمكن أن يتجاوز 1000 حرف',
            ]
        );

        //           $flight->name = $request->name;
        //         $flight->save();
        $section = sections::find($section->id);
        // $flight->name = 'Paris to London';
        // $flight->save();

        $section->section_name = $request->section_name;
        $section->description = $request->description;
        $section->created_by = auth()->user()->name;

        $section->save();
        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sections $section)
    {

        $section = sections::find($section->id);

        $section->delete();

        return redirect()->route('sections.index')->with('delete', 'تم حذف البتاع بنجاح !');
    }
}
