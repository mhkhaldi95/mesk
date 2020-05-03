<?php

namespace App\Http\Controllers;

use App\Client;
use App\Seller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ControllerSeller extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth']);

    }
    public function anyData()
    {
        return Datatables::of(Seller::query())

            ->setRowId('tr_{{$id}}')
            ->addColumn('details',function(Seller $seller) {
                return '<a href="/dashboard/sellers/orders/old_orders/'.$seller->id.'" class="btn btn-info btn-sm"  ><i class="fa fa-info" aria-hidden="true"></i> الطلبيات السابقة</a>';
            } )
            ->addColumn('add_order',function(Seller $seller) {
                return '<a href="/dashboard/sellers/orders/create/'.$seller->id.'" class="btn btn-primary btn-sm"  ><i class="fa fa-plus" aria-hidden="true"></i> اضافة طلبية</a>';
            } )

            ->addColumn('action',function(Seller $seller) {
                return
                    '<a  id="delete" data-value="'.$seller->id.'" class="btn btn-danger  remove-project">
            <i class="fa fa-trash" aria-hidden="true"></i>خذف
        </a>
        <a href="/dashboard/sellers/edit/'.$seller->id.'"  class="btn btn-info editu" >
           <i class="fa fa-edit" aria-hidden="true"></i>تعديل
        </a>';
            })
            ->rawColumns(['details','add_order','action'])
            ->toJson();


    }



    public function index(Request $request)
    {


        return view('adminlte.dashboardview.Sellers.index');
        //
    }
    public function create()
    {

        return view('adminlte.dashboardview.Sellers.create');
    }
    public function store(Request $request)
    {


        if($request->phone[1]!=null)
            $this->rule+=['phone.1'=>'numeric'];
        $request->validate($this->rule);

        Seller::create($request->all());
        return redirect()->back()->with('Success', 'تمت الاضافة بنجاح');

        // return redirect()->route('dashboard.clients.index');
    }
    public function edit(Seller $seller)
    {
        return view('adminlte.dashboardview.Sellers.create',compact('seller'));

    }

    public function update(Request $request, Seller $seller)
    {


        if($request->phone[1]!=null)
            $this->rule+=['phone.1'=>'numeric'];
        $request->validate($this->rule);

        $seller->update($request->all());
        return redirect()->route('dashboard.sellers.index')->with('Success', 'تمت التعديل بنجاح');

    }


    public function destroy($id)
    {


        try{
            $seller = Seller::findOrFail($id);
            $seller->delete();
        }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.sellers.index')->withErrors(['error'=>__('غير موجود')]);

        }
    }
    private $rule=[
        'name'=>'required',
        'phone.0'=>'required|numeric',
    ];
}
