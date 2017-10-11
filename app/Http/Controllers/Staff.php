<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CustomerModel;
use App\BillsModel;
use App\ParticularModel;
use App\UnitsModel;
use App\ItemsModel;
use App\VehiclesModel;
// use Auth;
use Intervention\Image\Facades\Image as Image;
use Response;
use DB;

class Staff extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*same as customer index*/
    public function index()
    {
    	$data['title'] ='Customer List';
    	$data['customers'] = CustomerModel::where('type',2)->get();
        return view('admin/customer_list',$data);
    }

    public function add(Request $request)
    {
        // echo $request->customerPhoto;die;
    	$validator = \Validator::make($request->all(), [
          'full_name' => 'required',
          'address' => 'required',
          'contact_number' => 'required|unique:tbl_customer,contact_number',
          'contact_number2' => 'required|unique:tbl_customer,contact_number2',
          'customerPhoto' => 'required'
        ]);

        if($validator->fails())
        {
            $message = $validator->errors();
            return redirect('/customer')->withErrors($validator)->withInput();
        }
        else
        {
            $imageName = rand(11111,99999).time(). '.' .  $request->file('customerPhoto')->getClientOriginalExtension();
            $request->file('customerPhoto')->move( base_path() . '/public/assets/uploads/customer/', $imageName);

        	$customerModel = new CustomerModel;
        	$customerModel->full_name = $request->full_name;
        	$customerModel->type = 2;
        	$customerModel->address = $request->address;
        	$customerModel->contact_number = $request->contact_number;
        	$customerModel->contact_number2 = $request->contact_number2;
        	$customerModel->customerPhoto = $imageName;
        	$customerModel->save();
        	
            if (isset($_POST['submit']))
            {
                return redirect('/staff');
            }
            else
            {
                return redirect('/bill');
            }
        }
    }

    public function report($id)
    {
        $data['customer_details'] = CustomerModel::find($id);
        $data['bill_id_of_customer'] = BillsModel::select('id')->where('customer_id',$id)->where('type_of_bill','!=','cash_only')->get();
        
        $data['items_reports'] = DB::table('tbl_bills')
                ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
                ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at','tbl_particular.particular_id as particular_id','tbl_particular.quantity as quantity','tbl_particular.units_id as units_id','tbl_particular.rate as rate')/*,DB::raw('sum(tbl_particular.quantity * tbl_particular.rate) as total')*/
                // ->groupBy('tbl_bills.id')
                ->where('customer_id',$id)
                ->orderBy('tbl_bills.id', 'desc')
                ->get();
        $data['cash_reports'] = DB::table('tbl_bills')
                ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
                ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at','tbl_particular.particular_id as particular_id','tbl_particular.quantity as quantity','tbl_particular.units_id as units_id','tbl_particular.rate as rate')/*,DB::raw('sum(tbl_particular.quantity * tbl_particular.rate) as total')*/
                ->groupBy('tbl_bills.id')
                ->where('customer_id',$id)
                ->orderBy('tbl_bills.id', 'desc')
                ->get();
        $data['title'] ='Report List';
        return view('admin/customer_report',$data);
    }


}
