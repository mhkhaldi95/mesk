<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;
use App\OrderProduct;



class ControllerProduct extends Controller
{
    public function __construct()
    {
//        $this->middleware(['permission:read_users'])->only('index');
//        $this->middleware(['permission:create_users'])->only('createview');
//        $this->middleware(['permission:delete_users'])->only('delete');
//        $this->middleware(['permission:update_users'])->only('editview');
        $this->middleware(['auth']);
    }
    public function anyData()
    {
        return Datatables::of(Product::query())
        
        ->setRowId('tr_{{$id}}') 
        
        ->editColumn('category_id', function(Product $product) {

            return  $product->category->name ;
        })
        ->addColumn('action',function(Product $product) {
            return '<a  id="delete" data-value="'.$product->id.'" class="btn btn-danger  remove-project">
            <i class="fa fa-trash" aria-hidden="true"></i>خذف
        </a>
        <a href="/dashboard/products/edit/'.$product->id.'"  class="btn btn-info editu" >
           <i class="fa fa-edit" aria-hidden="true"></i>تعديل
        </a>';
        })
        ->rawColumns(['action'])
       
        ->toJson();
        
        
    }
    public function Best_selling_products(){
        $best_sales = DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select('products.*', DB::raw('count(*) as total'))
            ->groupBy('products.id')
            ->orderBy('total','DESC')->paginate(10);
      
        
        return view('adminlte.dashboardview.Products.Best_selling_products',compact('best_sales'));
    }
    
  

    public function index()
    {
        // $categories = Category::all();

       
        
            return view('adminlte.dashboardview.Products.index');
       
    }

    // public function fetch_data(Request $request){
    //     $products = Product::paginate(5);
    //     if ($request->ajax()) {
    //         return view('adminlte.dashboardview.Products.load', ['products' => $products])->render();  
    //     }
    // }
    public function create(){
        $categories = Category::all();
        return view('adminlte.dashboardview.Products.create',compact('categories'));
    }
    public function store(Request $request)
    {
    $request->validate($this->rules(),$this->messages());

    $request_data = $request->all();
    $product=  Product::create($request_data);
    $category = Category::find($request_data['category_id']);
    $category->products()->save($product);

    return redirect()->back()->with('Success', 'تمت الاضافة بنجاح');  
}
public function edit($product)
    {
        try{
            $Product = Product::findOrFail($product);
            $categories = Category::all();
            return view('adminlte.dashboardview.Products.create',compact('categories','Product'));
         }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.products.index')->withErrors(['error'=>__('غير موجود')]);
        }
    }


    public function update(Request $request, Product $product)
    {
       
        $request->validate($this->rulesedit($product),$this->messages());
        $request_data = $request->all();

        $product->update($request_data);
        return redirect()->route('dashboard.products.index')->with('Success', 'تمت الاضافة بنجاح'); 
    }
public function destroy(Product $product)
{
        $product->delete();
        return back();

}

    


private function rulesedit($product){
    return [
        'name'=>'required|min:1|unique:products,name,'.$product->id.',id',
        'category_id'=>'required',
        'sequenceNo'=>'required',
        'whole_stoke' => 'required',
        'retail_stoke' => 'required',
        'purchase_price'=>'required',
                  

    ];
}



private function rules(){
   
    return [
        'name'=>'required|min:1|unique:products,name',
        'category_id'=>'required',
        'sequenceNo'=>'required',
        'whole_stoke' => 'required',
        'retail_stoke' => 'required',
        'purchase_price'=>'required',
        
    ];
}


private function messages(){
    return [
//            'name.required'=>'name is required',
//            'name.min'=>' name length is too short',
//            'password.required'=>'password is required',
//            'password.min'=>'password length is too short',
//            'passwordc.required'=>'password is required',
//            'passwordc.confirmed'=>'password must confirmed',
    ];
}


}







    // public function live_search_action(Request $request){
    //     if ($request->ajax()) {
    //         $query = $request->get('query');
    //         if($query != ''){
    //             $data = Product::where('name','like','%'.$query.'%')
    //             ->orWhere('sequenceNo','like','%'.$query.'%')
    //             ->orWhere('purchase_price','like','%'.$query.'%')
    //             ->orWhere('retail_stoke','like','%'.$query.'%')
    //             ->orWhere('category_id','like','%'.$query.'%')
    //             ->orWhere('whole_stoke','like','%'.$query.'%')
    //             ->orderBy('id','desc')
    //             ->get();
    //         }else{
    //             $data = Product::all()
    //             ->orderBy('id','desc')
    //             ->get();
    //         }
    //         if(count($data)>0){
    //             foreach($data as $index=>$row){
    //                 $output.='
    //                 <tr id="tr_'.$row->id.'">
    //                     <td>'.($index+1).'</td>
    //                     <td>'.$row->name.'</td>
    //                     <td>'.$row->sequenceNo.'</td>
    //                     <td>'.$row->category->name.'</td>
    //                     <td>'.$row->purchase_price.'</td>
    //                     <td>'.$row->whole_stoke.'</td>
    //                     <td>'.$row->retail_stoke.'</td>
    //                     <td>
    //                         <a data-value="'.$row->id.'" id="delete" class="btn btn-danger  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>حذف</a>
    //                         <a href="dashboard/products/edit/'.$row->id.'" class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i>تعديل</a>

    //                     </td>
    //                 </tr>
    //                 ';
    //             }
    //         }else{
    //             $output=' <tr><td align="center" colspan="7">لا يوجد بيانات</td></tr>';
    //         }
    //         $data = array(
    //             'table_data'=>$output,
    //         );
    //         echo json_decode($data);
    //     }
    // }