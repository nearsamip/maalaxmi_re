<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UnitsModel;

class Units extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$data['title'] ='Units List';
    	$data['units'] = UnitsModel::get();
        return view('admin/units_list',$data);
    }

    public function add(Request $request)
    {
        // echo $request->customerPhoto;die;
    	$validator = \Validator::make($request->all(), [
          'name' => 'required',
          // 'nepali_name' => 'required',
        ]);

        if($validator->fails())
        {

            $message = $validator->errors();
            return redirect('/units')->withErrors($validator)->withInput();
        }
        else
        {
            $nepaliName = $request->nepali_name != '' ? $request->nepali_name : 0;
        	$customerModel = new UnitsModel;
            $customerModel->name = $request->name;
        	$customerModel->nepali_name = $nepaliName;
        	$customerModel->save();
        	

        	return redirect('/units');
        }
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'name' => 'required',
          // 'nepali_name' => 'required',
          // 'photo' => 'required',
          
        ]);

        if($validator->fails())
        {
            // echo "no";die;
            
            $message = $validator->errors();
            return redirect('/units')->withErrors($validator)->withInput();
        }
        else
        {
            
            $nepaliName = $request->nepali_name != '' ? $request->nepali_name : 0;
            UnitsModel::where('id',$request->units_id)->update([
                'name'=>$request->name,
                'nepali_name'=>$nepaliName,
            ]);
            
            

            return redirect('/units');
        }
    }

    public function delete($id)
    {
        UnitsModel::where('id',$id)->delete();
        return redirect('/units');
    }

    public function get_units_name_by_id($id)
    {
        $units_detail = UnitsModel::find($id);

        if(!empty($units_detail))
        {
            return $units_detail->name;
        }
        else
        {
            return "";
        }
    }

    public function getUnitsNepaliName($id)
    {
        $result = UnitsModel::find($id);
        if(!empty($result))
        {
            if($result->nepali_name == '0')
            {
                return $result->name;
            }
            else
            {
                return $result->nepali_name;
            }
        }
        else
        {
            return '';
        }
    }
}
