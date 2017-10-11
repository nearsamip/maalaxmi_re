<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Admin_model;
use DB;
use Auth;
use Intervention\Image\Facades\Image as Image;
// use Image;

class Admin extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] ='Dashboard';
        return view('admin/dashboard',$data);
    }

    public function admin_common()
    {
        // echo $_SERVER['HTTP_HOST'];die;
        $data['title'] ='Pages';
        $data['common'] = Admin_model::where('id',1)->first();
        return view('admin/common_admin',$data);
    }

    public function common_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'about_us' => 'required',
            'term' => 'required',
            'privacy_policy' => 'required'
        ]);

        if($validator->fails())
        {
            return redirect('common-admin')->withErrors($validator)->withInput();
        }
        else
        {
            Admin_model::where('id',1)->update([
                'about_us'=>$request->about_us,
                'term'=>$request->term,
                'privacy_policy'=>$request->privacy_policy
            ]);
            return redirect('common-admin');

        }
    }
}
