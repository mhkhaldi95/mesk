<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\User as User;
use http\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ControllerCategory extends Controller
{
    public function index(Request $request)
    {

        // $categories = Category::when($request->search, function ($q) use ($request) {
        //     return $q->whereTranslationLike('name','%' . $request->search . '%');
        // })->latest()->paginate(5);
        // $categories = Category::when($request->search,function ($q) use ($request){
        //     return $q->where('name','like','%'.$request->search.'%');
        //  })->paginate(5);
        $categories = Category::all();

        return view('adminlte.dashboardview.Categories.index', compact('categories'));
    }
    public function create()
    {
        return view('adminlte.dashboardview.Categories.create');

    }
    public function store(Request $request)
    {
        $request->validate($this->rules());
       $category =  Category::create($request->all());
       return redirect()->back()->with('Success', 'تمت الاضافة بنجاح');   


        //    return response()->json(['message'=>'done','data'=>$category],200);

        // session()->flash('success',('aaaaaaaaaaaaaaaaa'));
        // return redirect()->route('dashboard.categories.index');
    }
    public function edit($id)
    {
        try{
            $category = Category::findOrFail($id);
            return view('adminlte.dashboardview.Categories.create',compact('category'));
         }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.categories.index')->withErrors(['error'=>__('غير موجود')]);
        }

}
public function update(Request $request, $id)
    {

        try {
            $category = Category::findOrFail($id);
            $request->validate($this->rulesedit($category),$this->messages());

            $category->update($request->all());
            return redirect()->route('dashboard.categories.index')->with('Success', 'تمت التعديل بنجاح'); 
        }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.categories.index')->withErrors(['error'=>__('غير موجود')]);
    }

        
    

    }
    public function destroy($id)
    {
        try{
            $category = Category::findOrFail($id);
                $category->products()->delete();

            $category->delete();
            return back();
        }catch (ModelNotFoundException $exception){
            return redirect()->route('dashboard.categories.index')->withErrors(['error'=>__('غير موجود')]);

        }


    }
    private function rulesedit($category){
        return [
            'name'=>'required|min:1|unique:categories,name,'.$category->id.',id',
            Rule::unique('categories')->ignore($category->name),
                      

        ];
    }
   

    private function rules(){
        return [
            'name'=>'required|min:1|unique:categories',
            
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
