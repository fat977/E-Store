<?php
namespace App\Traits;
use Illuminate\Http\Request;

trait ImageTrait
{

    public function uploadImage(Request $request ,$folderName){
        $image = $request->file('product_image')->getClientOriginalName();
        $path = $request->file('product_image')->storeAs($folderName,$image,'fatma');
        return $path;
    }

    public function uploadBannerImage(Request $request ,$folderName){
        $image = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs($folderName,$image,'fatma');
        return $path;
    }
}
