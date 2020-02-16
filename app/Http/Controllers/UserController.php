<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Mail;
use Validator;
use Cookie;

class UserController extends Controller
{
    public function register(Request $request){
        
        $fullname = $request->fullname;
        $email = $request->email;
        $password = bcrypt($request->password);
        $captcha = $request->captcha;
        
        $rule = [
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm' => 'same:password',
            'captcha' => 'required',
        ];
        
        $errorMessage = [
            'fullname.required' => 'wajib diisi',
            'email.required' => 'wajib diisi',
            'email.email' => 'format email salah',
            'email.unique' => 'email sudah dipakai',
            'password.required' => 'wajib diisi',
            'password.min' => 'minimal 6 huruf',
            'confirm.same' => 'password tidak sama',
            'captcha.required' => 'wajib di cek',
        ];

        $validator = Validator::make($request->all(), $rule, $errorMessage);
        if($validator->fails()){
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $user = new User;
        $user->fullname = $fullname;
        $user->email = $email;
        $user->password = $password;
        $user->verifyToken = Str::random(40);
        $user->image = 'pepsi.png';
        $user->role_id = 1;
        $user->save();
        
        $this->sendEmail($user);

        return response()->json([
            'type' => 'success',
            'message' => 'tunggu konfirmasi email',
        ]);
    }

    public function sendEmail($user){
        Mail::send('email.verify', ['user' => $user], function ($m) use ($user) {
            $m->from('yuliangunawan19@gmail.com', 'Qerja TPA');
            $m->to($user->email, $user->name)->subject('Verifikasi Email');
        });
    }

    public function verify($token){
        $user = User::where('verifyToken', $token)->first();
        if(!$user){
            return 'token tidak ada atau sudah tidak valid';
        }
        $user->status = 1;
        $user->save();

        Auth::login($user);
        return redirect('/company');
    }

    public function logout(){
        Auth::logout();
        Cookie::forget('remember_me');
    }

    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;
        $mau = $request->mauCaptcha;
        $remember = $request->remember == 'true';
        
        $rule = [
            'email' => 'required',
            'password' => 'required',
        ];

        $errorMessage = [
            'email.required' => 'wajib diisi',
            'password.required' => 'wajib diisi',
        ];

        if($mau == 'mau'){
            $rule['captcha'] = 'required';
            $errorMessage['captcha.required'] = 'wajib dicentang';
        }

        $validator = Validator::make($request->all(), $rule, $errorMessage);
        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        $valid = Auth::attempt($credentials);
        if($remember){
            Cookie::queue('remember_me', Auth::user(), 365*24*60);
        }

        if(!$valid){
            return response()->json([
                'type' => 'not found',
                'message' => 'email atau password salah'
            ]);
        }
        
        if(Auth::user()->status == 0){
            Auth::logout();
            return response()->json([
                'type' => 'not confirmed',
                'message' => 'konfirmasi email dulu'
            ]);
        }

        return response()->json([
            'type' => 'success',
            'message' => 'login sukses',
        ]);
    }

    public function getLoggedUser(){
        if(!Auth::check()) $role = 'guest';
        else $role = Auth::user()->role->name;
        return response()->json([
            'role' => $role,
            'user' => Auth::user(),
        ]);
    }

    public function getUserById(){
        $user = User::find(request()->id);
        return response()->json([
            'role' => $user->role->name,
            'user' => $user,
        ]);   
    }

    public function resend(Request $request){
        $user = User::where('email', $request->email)->first();
        $user->verifyToken = Str::random(40);
        $user->save();
        $this->sendEmail($user);
    }

    public function updatePassword(Request $request){
        $old = $request->old;
        $new = $request->new;
        $confirm = $request->confirm;

        $rule = [
            'old' => 'required',
            'new' => 'required',
            'confirm' => 'required|same:new',  
        ];
        
        $errorMessage = [
            'old.required' => 'wajib diisi',
            'new.required' => 'wajib diisi',
            'confirm.required' => 'wajib diisi',
            'confirm.same' => 'tidak sesuai',
        ];

        $validator = Validator::make($request->all(), $rule, $errorMessage);
        if($validator->fails()){
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        if(!Hash::check($old, Auth::user()->password)){
            return response()->json([
                'type' => 'wrong password',
                'message' => 'password lama salah'
            ]);
        }
        
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($new);
        $user->save();
        
        return response()->json([
            'type' => 'success',
            'message' => 'password berhasil di update'
        ]);
    }

    public function updateProfilePicture(Request $request){

        $rule = [
            'image' => 'required|image'
        ];
        $errorMessage = [
            'image.required' => 'pilih gambarnya',
            'image.image' => 'wajib gambar'
        ];
        $validator = Validator::make($request->all(), $rule, $errorMessage);
        if($validator->fails()){
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $image = $request->image;
        $filename = time() . $image->getClientOriginalName();
        $image->move(public_path('/image/user'), $filename);
        
        $user = User::find(Auth::user()->id);
        $user->image = $filename;
        $user->save();

        return response()->json([
            'type' => 'success',
            'message' => 'foto profile terupdate',
            'newImage' => $filename

        ]);
    }

}
