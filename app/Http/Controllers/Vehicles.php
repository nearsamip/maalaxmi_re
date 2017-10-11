<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\VehiclesModel;
use App\BillsModel;
use DB;

class Vehicles extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$data['title'] ='Vehicles List';
    	// $data['vehicles'] = VehiclesModel::get();
        $data['vehicles'] = BillsModel::groupBy('vehicles_num')->get();
        return view('admin/vehicles_list',$data);
    }

    public function add(Request $request)
    {
        // echo $request->customerPhoto;die;
    	$validator = \Validator::make($request->all(), [
          'number' => 'required',
          'photo' => 'required'
        ]);

        if($validator->fails())
        {

            $message = $validator->errors();
            return redirect('/vehicles')->withErrors($validator)->withInput();
        }
        else
        {

            $imageName = rand(11111,99999).time(). '.' .  $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move( base_path() . '/public/assets/uploads/vehicles/', $imageName);

        	$customerModel = new VehiclesModel;
        	$customerModel->number = $request->number;
        	$customerModel->photo = $imageName;
        	$customerModel->save();
        	

        	return redirect('/vehicles');
        }
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'number' => 'required',
          // 'photo' => 'required',
          
        ]);

        if($validator->fails())
        {
            // echo "no";die;
            
            $message = $validator->errors();
            return redirect('/vehicles')->withErrors($validator)->withInput();
        }
        else
        {
            // echo "t";die;
            if($request->file('photo') == "")
            {

                $imageName = $request->old_image;
            }
            else
            {
                $imageName = rand(11111,99999).time(). '.' .  $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->move( base_path() . '/public/assets/uploads/vehicles/', $imageName);
            }
            

            VehiclesModel::where('id',$request->vehicles_id)->update([
                'number'=>$request->number,
                'photo'=>$imageName
            ]);
            
            

            return redirect('/vehicles');
        }
    }

    public function delete($id)
    {
        VehiclesModel::where('id',$id)->delete();
        return redirect('/vehicles');
    }

    public function report($vehiclesNumber)
    {
        // echo $vehiclesNumber;die;
        $data['title'] = "vehicles report";
        $data['vehicles_reports'] = DB::table('tbl_bills')
            ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
            ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at','tbl_particular.particular_id as particular_id','tbl_particular.quantity as quantity','tbl_particular.units_id as units_id','tbl_particular.rate as rate')/*,DB::raw('sum(tbl_particular.quantity * tbl_particular.rate) as total')*/
            ->where('vehicles_num',$vehiclesNumber)
            ->orderBy('tbl_bills.id', 'desc')
            ->get(); 
            echo '<pre>';
            print_r($data['vehicles_reports']);die;
        return view('admin/vehicles_report',$data);
    }
}
