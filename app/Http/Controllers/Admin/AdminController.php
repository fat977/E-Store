<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\ValidationRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    //
    public function index(){
        return view('admin.auth.login');
    }
    public function dashboard()
    {
        if(Auth::guard('admin')->check()){
            return view('admin.index');
        }else{
            return redirect('admin/index');
        }       
    }

    public function login(LoginValidation $request){
      
        $data = $request->all();
    
        if(Auth::guard('admin')->attempt(['email' =>$data['email'],'password'=> $data['password']])){

            return redirect('admin/dashboard');
        }
        else{
            return redirect()->back()->with(['error_message' => 'invalid email or password']);
        }
     
    }

    public function updateDetails(Request $request){
        
        if($request->isMethod("post")){
            $request->validate([
                'name'=> 'required',
            ]);
            $data = $request->all();

             Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['name']]); 
            return redirect('admin/update-details')->with(['success' =>'your data is updated successfully']);
          
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray(); 
        return view('admin.settings.update-details',compact('adminDetails'));
    }
  
    public function checkCurrentPassword(Request $request){
        $data = $request->all();
      
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        } else{
            return "false";
        }
    }

    public function updatePassword(Request $request){

        if($request->isMethod("post")){
            $data = $request->all();
            $rules =[
                //'new_password'=> ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[*-]).{6,}$/'],
                'new_password'=> ['required', 'string', 'min:8'],
                'confirm_password'=>['required']
            ];
            $message =[
            
            'new_password.required' => 'We need to know your new password!',
            ];
            $this->validate($request,$rules,$message);
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                if($data['confirm_password']=== $data['new_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'
                    =>bcrypt($data['new_password'])]);

                    return redirect()->back()->with(['success' => 'Your password has been updated successfully']);
                
                 }else{
                return redirect()->back()->with(['error' => 'Your new password and confirmed password does not match']);
                }
            } else{
                return redirect()->back()->with(['error' => 'Your current password is incorrect']);
            } 
        }

        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update-password',compact('adminDetails'));
    }


   /*  public function forgotPasswordView(){
        return view('admin.auth.forgot-password');
    }

    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'email'=>'required|email|max:100|exists:admins',
            ],
            [
                'email.exists'=>'Email does not exist'
            ]);
            if($validator->passes()){
                // generate new password                
                $new_password = Str::random(16);
                // update password
                Admin::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);
                // get user details
                $userDetails = Admin::where('email',$data['email'])->first()->toArray();
                // send email to user 
                $email = $data['email'];
                $messageData =['name'=>$userDetails['name'],'email'=>$data['email'],
                'password'=>$new_password];
                Mail::send('admin.settings.forgot-password',$messageData,function($message)use($email){
                    $message->to($email)->subject('New Password - Stack Developers');
                });
                return response()->json(['type'=>'success','message'=>'New Password sent to registered email']);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);

            }
        }else{
            return view('admin.auth.forgot-password');
        }
       
    } */


    public function logout(){
        Auth::guard('admin')->logout();
        return view ('admin.auth.login');
    }
}
