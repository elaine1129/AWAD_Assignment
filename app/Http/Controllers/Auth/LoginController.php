<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterDoctorRequest;
use App\Http\Requests\RegisterPatientRequest;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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
        'address'=>'',
        'gender'=>''
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
            return redirect('/')->with('success','Welcome '.Auth::user()->name.'. ');
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
        return redirect(route('login-form'));
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
        return redirect(route('login-form'))->with('success', 'Account created, please proceed to login.');
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

        return redirect()->back()->with('success', 'New doctor registered and temporarily password has been sent to '.$accountInfo['email'])->withInput();
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('doctor.edit-profile', array_merge($user->toArray(), $user->data));
    }

    public function editDoctorProfile(Request $request)
    {
        \Illuminate\Support\Facades\Gate::check('doctor-access');

        $data = $request->validate([
            'old_password' => 'nullable',
            'password'=> [
                'nullable',
                'different:old_password',
                'required_with:old_password',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
            ],
            'name'=> 'required',
            'expertise' => 'string|nullable',
            'image' => 'nullable|image',
        ]);
        $old_password = $data['old_password'];
        $new_password = $data['password'];
        unset($data['password']);
        unset($data['old_password']);
        $user = Auth::user();

        if($new_password) {
            if (Hash::check($old_password, $user->password))
                $user->password = bcrypt($data['password']);
            else
                return redirect()->back()->withErrors('Old password is incorrect');
        }

        if($request->file('image')){
            $this->deleteImage($user->data['image_url']);
            $imgPath = $this->uploadImage($request->file('image'));
            $data['data']['image_url'] = $imgPath;
            unset($data['image']);
        }else {
            $data['data']['image_url'] = $user->image_url;
        }

        $data['data']['expertise'] = $data['expertise'];
        $user->name = $data['name'];
        $user->data = $data['data'];
        $user->save();
        return redirect()->back()->with('success', 'Data updated');
    }


    private function deleteImage($imagePath)
    {
        $absolutePath = public_path($imagePath);
        if(File::exists($absolutePath))
            File::delete($absolutePath);
    }

    private function uploadImage($image){
        $dir = config('clinic.img_path');
        $fileName = \Illuminate\Support\Str::random().'.'.$image->getClientOriginalExtension();
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileName;
        if($image->isValid()){
            if(!File::exists($absolutePath))
                File::makeDirectory($absolutePath, 0755, true);
            File::move($image->path(), $relativePath);
            return $relativePath;
        }else{
            throw new \Exception('Invalid image');
        }
    }
}





