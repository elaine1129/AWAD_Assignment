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

        if ( Auth::attempt($data, $remember)) {
            $request->session()->regenerate();
            return redirect('/')->with('success','Welcome '.Auth::user()->name.'. ');
        }
        return back()->withInput($request->only(['email', 'remember']))->withErrors([
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
        return view('common.edit-profile', array_merge($user->toArray(), $user->data));
    }

    public function showEditPassword(Request $request)
    {
        return view('common.edit-password')->with('email', Auth::user()->email);
    }

    public function editPassword(Request $request)
    {
        $data = $request->validate([
            'email'=>'exclude',
            'old_password' => 'required',
            'password'=> [
                'required',
                'different:old_password',
                'required_with:old_password',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
            ],
        ]);
        $old_password = $data['old_password'];
        $new_password = $data['password'];
        $user = Auth::user();

        if($new_password) {
            if (Hash::check($old_password, $user->password)){
                $user->password = Hash::make($data['password']);
                $user->save();
                return redirect()->back()->with('success', 'Password changed.');
            }
            else
                return redirect()->back()->withErrors('Old password is incorrect');
        }
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();

        if($user->isDoctor()){
            $data = $request->validate([
                'name'=> 'required',
                'expertise' => 'string|nullable',
                'image' => 'nullable|image',
            ]);

            if($request->file('image')){
                $this->deleteImage($user->data['image_url']);
                $imgPath = $this->uploadImage($request->file('image'));
                $data['data']['image_url'] = $imgPath;
                unset($data['image']);
            }else {
                $data['data']['image_url'] = $user->image_url;
            }

            $data['data']['expertise'] = $data['expertise'];
            $user->data = $data['data'];

        }elseif ($user->isPatient()){
            $data = $request->validate([
                'email'=>'exclude',
                'name'=> 'required',
                'phone' => 'string|nullable',
                'ic' => ['regex:/^(([[1-9]{2})(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01]))-([0-9]{2})-([0-9]{4})$/', 'required'],
                'gender' => 'required',
                'address' => 'required',
            ]);

            $user->data = $request->except('name');
        }else {
            $data = $request->validate([
                'name'=> 'required',
            ]);
        }

        $user->name = $data['name'];
        $user->save();
        return redirect()->back()->with('success', 'Profile updated');
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





