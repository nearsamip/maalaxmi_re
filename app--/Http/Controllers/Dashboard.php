<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\ItemsModel;
use App\UnitsModel;
use App\CustomerModel;
use App\BillsModel;
use App\ParticularModel;
use DB;

class Dashboard extends Controller
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

    public function index()
    {
        $data['title'] ='Dashboard';
        $data['cash_detail'] = BillsModel::select(DB::raw('SUM(cash_received) as cash_received'),DB::raw('SUM(cash_given) as cash_given'))->first();
        return view('admin/dashboard',$data);
    }

    
}
