<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterDoctorRequest;
use App\Http\Requests\RegisterPatientRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Psy\Util\Str;

class LoginController extends Controller
{
    static protected $commonFields = [
        'email' => '',
        'name'=>'',
        'password' => '',
    ];

    static protected $doctorFields = [
        'expertise' => '',
        'image_url'=>'',
    ];

    static protected $adminFields = [
    ];

    static protected $patientFields = [
        'phone' => '',
    ];

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable',
        ]);
        $remember = isset($data['remember']);
        unset($data['remember']);
        if (Auth::attempt($data, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }
        return back()->withErrors([
            'msg' => 'The provided credentials are not correct'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return '#LOGIN_VIEW';
    }

    // register for patient
    public function register(RegisterPatientRequest $request)
    {
        $accountInfo = $request->safe()->only(array_keys(self::$commonFields));
        $patientData = $request->safe()->only(array_keys(self::$patientFields));
        $user = User::create([
            'name' => $accountInfo['name'],
            'email' => $accountInfo['email'],
            'password' => bcrypt($accountInfo['password']),
            'data'=>$patientData
        ]);

        //        return to login view
    }

    public function registerDoctor(RegisterDoctorRequest $request)
    {
        $accountInfo = $request->safe()->only(array_keys(self::$commonFields));
        $doctorData = $request->safe()->except(array_keys(self::$commonFields));
//        $tempPassword = \Illuminate\Support\Str::random();
        // #TODO send temporary password to doctor email
        $tempPassword = 'password';

        if($request->file('image')){
            $imgPath = $this->uploadImage($request->file('image'));
            $doctorData['image_url'] = $imgPath;
            unset($doctorData['image']);
        }

        User::create([
            'name' => $accountInfo['name'],
            'email' => $accountInfo['email'],
            'password' => bcrypt($tempPassword),
            'role'=> 'DOCTOR',
            'data'=> $doctorData
        ]);

//        return to login view
    }


    private function deleteImage(User $user)
    {
        if($user->isDoctor() && $user->data['image_url'] != null)
            $absolutePath = public_path($user->data['image_url']);
        File::delete($absolutePath);
    }

    private function uploadImage($image){
        $dir = config('clinic.img_path');
        $fileName = \Illuminate\Support\Str::random().$image->getClientOriginalExtension();
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileName;
        if($image->isValid()){
            if(!File::exists($absolutePath))
                File::makeDirectory($absolutePath, 0755, true);
            $image->move($relativePath, $fileName);
            return $relativePath;
        }else{
            throw new \Exception('Invalid image');
        }
    }
}





