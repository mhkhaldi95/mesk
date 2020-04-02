<?php

namespace App\Http\Controllers;

use App\User as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use App\Expense;
use Yajra\Datatables\Datatables;

class ControllerUser extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('createview');
        $this->middleware(['permission:delete_users'])->only('delete');
        $this->middleware(['permission:update_users'])->only('editview');
        // $this->middleware(['lang','auth']);
        $this->middleware(['auth']);

    }

    // public function change($lang){

    //     Session::put('lang',$lang);

    //     return redirect()->back();
    // }
    function index(Request $request){
        $users = User::when($request->search, function ($q) use ($request)  {
            return $q->where('name','like', '%' . $request->search . '%')
                // ->orWhere('address','like', '%' . $request->search . '%')
                // ->orWhere('phone','like', '%' . $request->seazzrch . '%')
                ;

        }) ->latest()->paginate(5);
        return view( "adminlte.dashboardview.user",compact('users'));
    }
    function users(Request $request){
//        $users = User::all();
//        $users = User::whereRoleIs('admin')->get();
        //first method
//        if($request->search){
//            $users = User::where('name','like','%'.$request->search.'%')->get();
//        }else $users = User::whereRoleIs('admin')->get();

        $users = User::whereRoleIs('admin')->when($request->search,function ($q) use ($request){
           return $q->where('name','like','%'.$request->search.'%');
        })->paginate(5);
        return view( "adminlte.dashboardview.user",compact('users'));
    }
    public function createview (){
        return view('adminlte.dashboardview.create');
    }
    function create(Request $request){

        $request->validate($this->rules(),$this->messages());

            $user= new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =Hash::make($request->password);
        if($request->image){

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();})->save(public_path('/uploads/image_user/'.$request->image->hashName()));
            $user->image = $request->image->hashName();
        }

        $user->save();
        $user->attachRole('super_admin');
        $user->syncPermissions($request->permissions);
//        \session()->flash('success',__('pos.added sucessfully'));

         return redirect()->route('dashboard.users.index');


    }
    function edit($id){
        try{
            $user = User::find($id);
            return view('adminlte.dashboardview.create',compact('user'));

        }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.categories.index')->withErrors(['error'=>__('غير موجود')]);
        }
        

    }

    function update(Request $request,$id){
        try{
            $user = User::find($id);
        }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.users.index')->withErrors(['error'=>__('غير موجود')]);
        }
        $request->validate($this->rulesedit($user),$this->messages());
//        $data = $request->except(['permissions']);
//
//        $user->update($data);
//        $user->syncPermissions($request->permissions);



        $user->name = $request->name;
        $user->email = $request->email;

        if($request->image){

            if($request->image!='default-png.png'){
                Storage::disk('public_uploads')->delete('/image_user/'.$user->image );

            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();})->save(public_path('/uploads/image_user/'.$request->image->hashName()));
            $user->image = $request->image->hashName();
        }
        $user->save();

        // $user->syncPermissions($request->permissions);
         return redirect()->route('dashboard.users.index');

    }
    public function destroy($id){
        try{
            $user = User::find($id);
        }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.users.index')->withErrors(['error'=>__('غير موجود')]);
        }
        if($user->image != 'default-png.png'){

            Storage::disk('public_uploads')->delete('/image_user/'.$user->image );
        }
        $user->delete();
        
      }
    public function Expenses_view(){
        
        return view( "adminlte.dashboardview.Expenses.expenses");

    }
    public function getExpense(){
        return Datatables::of(Expense::query())->make(true);
       

    }
      
    public function Expenses_create(){
        return view( "adminlte.dashboardview.Expenses.create");

    }  
    public function Expenses_Store(Request $request){
        $request->validate([
            'description' => 'required',
            'amount' => 'required',
        ]);
        Expense::create([
            'description' => $request->description,
        
            'amount' => $request->amount,
         
        
            ]);
            return redirect()->back()->with('Success', 'تمت الاضافة بنجاح');  

    } 
    private function rulesedit($user){
        return [
            'name'=>'required|min:3',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],            'image'=>'image',
            // 'permissions'=>'required',

        ];
    }

    private function rules(){
        return [
            'name'=>'required|min:3',
            'email'  =>  'required|unique:users',
            'image'=>'image',
            'permissions'=>'required',
            'password'=>'required|min:3',
//            'passwordc'=>'required|confirmed',
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
