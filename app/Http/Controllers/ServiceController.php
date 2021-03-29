<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Service;
use App\Payment;
use App\Branch;
use App\Exports\ServiceExport;
use App\Http\Resources\Service as ServiceResource;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\User;
use Exception;
use Carbon\Carbon;

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
        
        $services = Service::where('branch_id',$branch_id)->get();
        return $services;
    }

    public function index()
    {
    
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

        $service->branch_id = $request->input('branch_id');
        $service->contract_no = $request->input('contract_no');
        $service->name = strtoupper($request->input('name'));
        $service->status = strtoupper($request->input('status'));
        $service->address = strtoupper($request->input('address'));
        $service->phone_number =$request->input('phone_number');
        $service->name_of_deceased = strtoupper($request->input('name_of_deceased'));
        $service->date_of_birth = $request->input('date_of_birth');
        $service->date_of_death = $request->input('date_of_death');
        $service->type_of_casket = strtoupper($request->input('type_of_casket'));
        $service->days_embalming = $request->input('days_embalming');
        $service->service_description = $request->input('service_description');
        $service->freebies_inclusion = $request->input('freebies_inclusion');
        // $service->interment_schedule = $request->input('interment_schedule');
        $service->interment_schedule = '2020-02-02';
        $service->contract_amount = $request->input('contract_amount');
        $service->balance = $request->input('contract_amount');
        $service->date_created = Carbon::now()->toDateTimeString();

        try{
            $service->save();
            if($request->isMethod('put')){
                return "Successfully Edited";
            }
            else{
                return $service; 
            } 
        }
        catch(Exception $e){
            return $e->getMessage();
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
        try{
            $service->delete();
            // delete payments
            try{
                Payment::where('service_id',$id)->delete();
                return "Successfully Deleted";
            }
            catch(Exception $e){
                return $e->getMessage();
            }

            
        }
        catch(Exception $e){
            return $e->getMessage();
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

        $count_month = Service::whereMonth('date_created',$month)->where('branch_id',$branch_id)->count();
        $count_year = Service::whereYear('date_created',$year)->where('branch_id',$branch_id)->count();

        return collect(['count_month'=>$count_month,'count_year'=>$count_year]);
    }
    public function print_summary($month,$year,$branch_id){

        // convert cash on hand to cash_on_hand
        $month+=1;
        $dswd_caraga = Payment::where([
            ['mode_of_payment','DSWD-CARAGA'],
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

        // $total_discount = Payment::where([
        //     ['mode_of_payment','discount'],
        //     ['branch_id',$branch_id]
        // ])->whereMonth('date_created',$month)
        // ->whereYear('date_created',$year)->sum('amount');

         $cash_on_hand = Payment::where([
            ['mode_of_payment','Cash On-hand'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
         ->whereYear('date_created',$year)->sum('amount');

        $pgo = Payment::where([
            ['mode_of_payment','PGO'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
         ->whereYear('date_created',$year)->sum('amount');

           $down_payment = Payment::where([
            ['mode_of_payment','Down Payment'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
         ->whereYear('date_created',$year)->sum('amount');
        $total_cash_collected = Payment::where([
                ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
        
        // create an object to return
        // DSWD - MSWDO - LGU - PSWD - CHEQUE - TOTAL DISCOUNT - CASH - TOTAL CASH
        // $results = array($dswd,$mswdo,$lgu,$pswd,$cheque,$cash_on_hand,
        //     $total_cash_collected);
        $results = collect([
            'dswd-caraga'=>$dswd_caraga,
            'mswdo'=>$mswdo,
            'lgu'=>$lgu,
            'pswd'=>$pswd,
            'cheque'=>$cheque,
            'pgo'=>$pgo,
            'down_payment'=>$down_payment,
            'cash_on_hand'=>$cash_on_hand,
            'total_cash_collected'=>$total_cash_collected
        ]);
        $date = date("Y-M-d");

       $branch = Branch::select('branch_location')->where('id',$branch_id)->first();

        // get services this month from branch number

        $services = Service::whereMonth('date_created',$month)->whereYear('date_created',$year)->where('branch_id',$branch_id)->get();

        $services = $services->map(function($q){
            // $last = Payment::find($q->id)
            $last = Payment::where('service_id',$q->id)->latest('created_at')->first();
            if($last != null){
                $rem = $last->remarks;
            }
            else{
                $rem = "No payments found";
            }
            $new = collect([
                'contract_no'=>$q->contract_no,
                'name'=>$q->name,
                'name_of_deceased'=>$q->name_of_deceased,
                'address'=>$q->address,
                'contract_amount'=>$q->contract_amount,
                'amount'=>$q->amount,
                'phone_number'=>$q->phone_number,
                'balance'=>$q->balance,
                'type_of_casket'=>$q->type_of_casket,
                'remarks'=>$rem
                ]);
            return $new;
        });
        // return $services;

        return view('pdf.summary',compact('results','year','month','branch','services'));

        // $pdf = PDF::loadView('pdf.summary',compact('results','year','month','branch','services'));
        // return $pdf->download($month.'-'.$year.'-'.'results.pdf');

    }
    public function print_contract($contract_id, $branch_id){
        // get branch location
        // $branch_location = User::select('location')->where('branch_id',$branch_id)->first();
        $branch_location = Branch::find($branch_id) ;
        $service = Service::where('id',$contract_id)->where('branch_id',$branch_id)->get();
        $first_payment = Payment::where('service_id',$contract_id)->where('branch_id',$branch_id)->where('mode_of_payment','Down Payment')->first();
        $payments = Payment::where('service_id',$contract_id)->where('branch_id',$branch_id)->get();
        // return $first_payment;
        return view('pdf.contract',compact('service','branch_location','first_payment','payments'));
        // $pdf = PDF::loadView('pdf.contract',compact('service','branch_location','first_payment'));
        // return $pdf->download($service[0]->name.'_contract.pdf');
    }
    public function filtered_service($branch_id){
        
        $cheque = Service::whereHas('payments',function($q){
            $q->where('mode_of_payment','Cheque');
        })->where('branch_id',$branch_id)->with(array('payments'=> function($q){
            $q->where('mode_of_payment','Cheque');
        }))->get();

        $cash_on_hand = Service::whereHas('payments',function($q){
            $q->where('mode_of_payment','Cash On-hand');
        })->where('branch_id',$branch_id)->with(array('payments'=> function($q){
            $q->where('mode_of_payment','Cash On-hand');
        }))->get();

        $mswdo = Service::whereHas('payments',function($q){
            $q->where('mode_of_payment','MSWDO');
        })->where('branch_id',$branch_id)->with(array('payments'=> function($q){
            $q->where('mode_of_payment','MSWDO');
        }))->get();

        $lgu = Service::whereHas('payments',function($q){
            $q->where('mode_of_payment','LGU');
        })->where('branch_id',$branch_id)->with(array('payments'=> function($q){
            $q->where('mode_of_payment','LGU');
        }))->get();

        $dswd_caraga = Service::whereHas('payments',function($q){
            $q->where('mode_of_payment','DSWD-CARAGA');
        })->where('branch_id',$branch_id)->with(array('payments'=> function($q){
            $q->where('mode_of_payment','DSWD-CARAGA');
        }))->get();

        $pswd = Service::whereHas('payments',function($q){
            $q->where('mode_of_payment','PSWD');
        })->where('branch_id',$branch_id)->with(array('payments'=> function($q){
            $q->where('mode_of_payment','PSWD');
        }))->get();

        $pgo = Service::whereHas('payments',function($q){
            $q->where('mode_of_payment','PGO');
        })->where('branch_id',$branch_id)->with(array('payments'=> function($q){
            $q->where('mode_of_payment','PGO');
        }))->get();

        $down_payment = Service::whereHas('payments',function($q){
            $q->where('mode_of_payment','Down Payment');
        })->where('branch_id',$branch_id)->with(array('payments'=> function($q){
            $q->where('mode_of_payment','Down Payment');
        }))->get();

        $col = collect([
            'cheque'=>$cheque,
            'cash_on_hand'=>$cash_on_hand,
            'mswdo'=>$mswdo,
            'lgu'=>$lgu,
            'dswd_caraga'=>$dswd_caraga,
            'pswd'=>$pswd,
            'pgo'=>$pgo,
            'down_payment'=>$down_payment,

        ]);
        return $col;
    }
}
