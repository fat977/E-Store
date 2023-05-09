<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $sections = Section::get();
        return view('admin.management.sections.index',compact('sections'));
    }

    public function create(){
        return view('admin.management.sections.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=> 'required',
        ]);
        $section = $request->all();
        Section::create($section);          
        return redirect()->route('section.index')->with(['success' => 'section created successfully']);
    }

    public function edit($id){
        $section = Section::findOrFail($id);
        return view('admin.management.sections.edit',compact('section'));
    }

    public function update(Request $request, $id){
        $section = Section::findOrFail($id);
        $request->validate([
            'name'=> 'required',
        ]);
        $section->update($request->all());
        return redirect()->route('section.index')->with(['success' => 'section updated successfully']);
    }

    public function destroy($id){
        Section::where('id',$id)->delete();
        return redirect()->back()->with(['success' => 'section deleted successfully']);
    }

    public function updateSectionStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            Section::where('id',$data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
        }
    }
}
