<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Service;
use App\Payment;
use App\Exports\ServiceExport;
use App\Http\Resources\Service as ServiceResource;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\User;

class ServiceController extends Controller
{

      // get info using their token
   public function __construct(){
       $this->middleware(['auth:api']);
   }
   
   public function __invoke(Request $request){
       $user = $request->user();
       return response()->json([
        'email'=> $user->email,
        'name'=> $user->name,
        'branch_id'=> $user->branch_id,
       ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filtered($branch_id){
         $services = DB::table('services')->where('branch',$branch_id)->get();
         return $services;
    }

    public function index()
    {
        //get services
        $services = Service::paginate(15);
        // return collection of services as a resource
        return ServiceResource::collection($services);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {   // check if the method is put. if true, find service true id. else, create a new service. Store in variable $service. 
        $service = $request->isMethod('put') ? Service::findOrFail($request->id) : new Service;

        $service->contract_no = $request->input('contract_no');
        $service->name = $request->input('name');
        $service->name_of_deceased = $request->input('name_of_deceased');
        $service->address = $request->input('address');
        $service->amount = $request->input('amount');
        $service->branch = $request->input('branch_id');
        $service->down_payment = $request->input('down_payment');
        $service->balance = $request->input('balance');
        $service->phone_number =$request->input('phone_number');
        $service->date_created = $request->input('date_created');
        $service->type_of_casket = $request->input('type_of_casket');
        $service->deceased_date = $request->input('deceased_date');

        if($service->save()){
            return new ServiceResource($service);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get service
        $service = Service::findOrFail($id);
        // return as resource
        return new ServiceResource($service);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get service
        $service = Service::findOrFail($id);
        if($service->delete()){
               // return as resource
            return new ServiceResource($service);
        }
     
        
    }
    public function edit_service_info(Request $request){
        $service = Service::findOrFail($request->service_id);
        $reqs = ['embalmer','embalm_date','embalm_helper','embalm_remarks','embalm_address',
        'retrieve_location','retrieve_date','retrieve_driver','retrieve_helper','deliver_time_in','deliver_time_out','deliver_driver','deliver_helper','deliver_remarks','date_of_burial','burial_address','burial_helper','burial_remarks'];

        foreach($reqs as $req){
            $service->$req = $request->$req;
        }
        if( $service->save()){
            return $service;
        }
       
    }

    public function get_total_service(Request $request){
        $year = $request->year;
        $month = $request->month;
        $branch_id = $request->branch_id;

        $count_month = Service::whereMonth('created_at',$month)->where('branch',$branch_id)->count();
        $count_year = Service::whereYear('created_at',$year)->where('branch',$branch_id)->count();

        return array($count_month,$count_year);
    }
    public function print_summary($month,$year,$branch_id){

        // convert cash on hand to cash_on_hand
        $month+=1;
        $dswd = Payment::where([
            ['mode_of_payment','DSWD'],
            ['branch_id',$branch_id],
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
        $mswdo = Payment::where([
            ['mode_of_payment','MSWDO'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
        $lgu = Payment::where([
            ['mode_of_payment','LGU'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
        $pswd = Payment::where([
            ['mode_of_payment','PSWD'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
        $cheque = Payment::where([
            ['mode_of_payment','Cheque'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
        $total_discount = Payment::where([
            ['mode_of_payment','discount'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
         $cash_on_hand = Payment::where([
            ['mode_of_payment','Cash On-hand'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
         ->whereYear('date_created',$year)->sum('amount');

        $total_cash_collected = Payment::where([
                ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
        
        // create an object to return
        // DSWD - MSWDO - LGU - PSWD - CHEQUE - TOTAL DISCOUNT - CASH - TOTAL CASH
        $results = array($dswd,$mswdo,$lgu,$pswd,$cheque,$total_discount,$cash_on_hand,$total_cash_collected);
        $date = date("Y-M-d");

        if($branch_id == '1'){
            $branch = 'Cantilan';
        }

        // get services this month from branch number

        $services = Service::whereMonth('date_created',$month)->whereYear('date_created',$year)->where('branch',$branch_id)->get();

        // return view('pdf.summary',compact('results','year','month','branch','services'));

        $pdf = PDF::loadView('pdf.summary',compact('results','year','month','branch','services'));
        return $pdf->download($month.'-'.$year.'-'.'results.pdf');

    }
    public function print_contract($contract_id, $branch_id){
        // get branch location
        $branch_location = User::select('location')->where('branch_id',$branch_id)->first();
        $service = Service::where('id',$contract_id)->where('branch',$branch_id)->get();
    
        return view('pdf.contract',compact('service','branch_location'));
        // $pdf = PDF::loadView('pdf.contract',compact('service','branch_location'));
        // return $pdf->download($service[0]->name.'.pdf');
    }
}
