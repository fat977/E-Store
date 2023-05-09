<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerValidation;
use App\Models\Banner;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    //

    use ImageTrait;

    public function index(){
        $banners = Banner::get();
        return view('admin.management.banners.index',compact('banners'));

    }

    public function create(){

        return view('admin.management.banners.create');

    }

    public function store(BannerValidation $request){

       /*  $request->validate([
            'image'=> 'required|mimes:jpg|unique:banners',
            'type'=>'required'
        ]); */
        $banner= $request->all();
        //if(!empty($request->image)){
            $path= $this->uploadBannerImage($request,'banners');
            $banner['image'] = $path;
        //}
        Banner::create($banner);
        return redirect()->route('banner.index')->with(['success' => 'Banner created successfully']);

    }

    public function edit($id){

        $banner = Banner::findOrFail($id);
        return view('admin.management.banners.edit',compact('banner'));

    }

    public function update(BannerValidation $request,$id){
        $banner = Banner::findOrFail($id);
        /* $request->validate([
            'image'=> 'required|mimes:jpg',
            'type'=>'required'
        ]); */
        $banner_data= $request->all();
        //if(empty($request->image)){
            $path= $this->uploadBannerImage($request,'banners');
            $banner_data['image'] = $path;
        //}
        $banner->update($banner_data);
        return redirect()->route('banner.index')->with(['success' => 'Banner updated successfully']);

    }

    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=='active'){
                $status = 0;
            }else{
                $status=1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }

    }

    public function deleteBanner($id){
        $banner = Banner::where('id',$id)->first();
        Storage::disk('fatma')->delete($banner->image); // Delete attachement with keeping the folder
        $banner->forceDelete();
        $message = "Banner has been deleted successfully";
        return redirect()->back()->with(['success' => $message]);

    }
}
