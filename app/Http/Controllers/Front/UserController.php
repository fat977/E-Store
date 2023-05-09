<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterValidation;
use App\Mail\ForgotPassword;
use App\Mail\Verify;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NewRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function loginRegister(){
        $countries = Country::where('status',1)->get()->toArray();
        return view('front.users.login_register',compact('countries'));
    }

    public function userRegister(Request $request){
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;

        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:100',
            'mobile'=>'required|numeric|digits:10',
            'email'=>'required|email|max:100|unique:users',
            'password'=>'required|min:6',
        ],
        [
            'accept.required'=>'please accept our terms & conditions'
        ]);

        if($validator->passes()){
            $user = new User;
            $user->name = $data['name'];
            $user->mobile = $data['mobile'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->country = $data['country'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->pincode = $data['pincode'];
            $user->status =0;
            $user->save();

            $name = $data['name'];
            $code = base64_encode($data['email']);
            Mail::to($data['email'])->send(new Verify($name,$code));

           /*  $admin = Admin::where('email','fatma@gmail.com')->get();
            $user = User::latest()->first();
            Notification::send($admin,new NewRegister($user)); */

            $redirectTo = url('user/login-register');
            return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'please confirm
            your email to activate your account']);

            

        }else{
            return response()->json(['type'=>'error','errors'=>$validator->messages()]);

        }
    }

    public function userConfirm($code){
        $email=base64_decode($code);
        $userAccount = User::where('email',$email)->count();
        if($userAccount>0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status==1){
                return redirect('user/login-register')->with(['error_message'=>
                'Your account is already activated . You can login now']);
            }else{
            User::where('email',$email)->update(['status'=>1]);
            //send welcome email
               /*  $messageData =['name'=>$userDetails->name,'mobile'=>$userDetails->mobile,'email'=>$email];
                Mail::send('emails.register',$messageData,function($message)use($email){
                    $message->to($email)->subject('Welcome to stack developers');
                }); */
                return redirect('user/login-register')->with(['success_message'=>
                'Your account is activated . You can login now']);

            }

        }
    }

    public function userLogin(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'email'=>'required|email|max:100|exists:users',
                'password'=>'required|min:6',
            ]);

            if($validator->passes()){
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive','message'=>'Your account is inactive']);
                    }

                    // update user cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
                    $redirectTo = url('cart/cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }else{
                    return response()->json(['type'=>'incorrect','message'=>'Invalid email or password']);
                }
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);

            }
        }
    }

    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'name'=>'required|string|max:100',
                'address'=>'required|string|max:100',
                'city'=>'required|string|max:100',
                'state'=>'required|string|max:100',
                'country'=>'required|string|max:100',
                'mobile'=>'required|numeric|digits:10',
                'pincode'=>'required|numeric|digits:10',
            ]);
            if($validator->passes()){
                User::where('id',Auth::user()->id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'],'city'=>$data['city'],
                'state'=>$data['state'],'country'=>$data['country'],'pincode'=>$data['pincode'],'address'=>$data['address']]);

                return response()->json(['type'=>'success','message'=>'Your Contact details updated successfully']);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);

            }

        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.user_account',compact('countries'));
        }

    }

    public function userUpdatePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'current_password'=>'required',
                'new_password'=>'required|min:6',
                'confirm_password'=>'required|min:6|same:new_password',
               
            ]);
            if($validator->passes()){
               $current_password = $data['current_password'];
               $checkPassword = User::where('id',Auth::user()->id)->first();
               if(Hash::check($current_password,$checkPassword->password)){
                //update user current password
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt($data['new_password']);
                $user->save();
                return response()->json(['type'=>'success','message'=>'Your password has been updated successfully']);
               }else{
                 return response()->json(['type'=>'incorrect','message'=>'Your current password is not correct ']);
               }
               return response()->json(['type'=>'success','message'=>'Your contact details has been updated successfully']);

            }else{

                return response()->json(['type'=>'error','errors'=>$validator->messages()]);

            }

        }else{
            //$countries = Country::where('status',1)->get()->toArray();
            return view('front.users.user_account');
        }
    }

    public function checkCurrentPassword(Request $request){
        $data = $request->all();
        $checkPassword = User::where('id',Auth::user()->id)->first();
        if(Hash::check($data['current_password'],$checkPassword->password)){
            return "true";
        } else{
            return "false";
        }
    }

    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'email'=>'required|email|max:100|exists:users',
            ],
            [
                'email.exists'=>'Email does not exist'
            ]);
            if($validator->passes()){
               
                // send email to user 
                $userDetails = User::where('email',$data['email'])->first()->toArray();
                $email = $data['email'];
                $name = $userDetails['name'];

                Mail::to($email)->send(new ForgotPassword($name,$email));
                
                return response()->json(['type'=>'success','message'=>'New Password sent to registered email']);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);

            }
        }else{
            return view('front.users.forgot_password');
        }
       
    }

    public function changePassword(){
        return view('front.users.change_password');
    }

    public function createNewPassword(Request $request){
        $data = $request->all();
            //echo "<pre>"; print_r($data); die;
        $request->validate([
            'new_password'=>'required|min:6',
            'confirm_password'=>'required|min:6|same:new_password',
        ]);
         
        //update user current password
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($data['new_password']);
        $user->save();
        return redirect()->back()->with(['success_message'=>'Your New password has been created successfully']);

        
    }

    public function orders(){
        $orders = Order::where('user_id',Auth::id())->get();
        return view('front.orders.orders',compact('orders'));
    }

    public function viewOrders($id){
        $orders = Order::where('id',$id)->where('user_id',Auth::id())->first();
        return view('front.orders.view_orders',compact('orders'));
    }

    public function userLogout(){
        Auth::logout();
        return redirect('/');
    }


}