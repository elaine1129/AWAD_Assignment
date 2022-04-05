<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DoctorController extends Controller
{
    
    public function edit(Doctor $doctor)
    {
        return view('common.edit-profile', array_merge($doctor->toArray(), $doctor->data));
    }

    public function index()
    {
        return view('doctor.admin-doctors', [
            'doctors' => User::whereRole('DOCTOR')->latest()->get()
        ]);
    }

    public function update(Request $request, Doctor $doctor)
    {
          $data = $request->validate([
                'name'=> 'required',
                'expertise' => 'string|nullable',
                'image' => 'nullable|image',
            ]);

            if($request->file('image')){
                $this->deleteImage($doctor->data['image_url']);
                $imgPath = $this->uploadImage($request->file('image'));
                $data['data']['image_url'] = $imgPath;
                unset($data['image']);
            }else {
                $data['data']['image_url'] = $doctor->image_url;
            }

            $data['data']['expertise'] = $data['expertise'];
            $doctor->data = $data['data'];

            $doctor->name = $data['name'];
            $doctor->save();
            return redirect('/admin/doctors')->with('alert',  [
                'message'=> $doctor->name.'\'s profile updated. ',
                'type'=>'success',
            ]);
    }

    public function delete(Doctor $doctor)
    {
       $doctor->delete();
       return redirect()->back()->with('alert', [
                'message'=>$doctor['name'].' deleted',
                'type'=>'success',
        ]);
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
