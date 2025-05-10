<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Complain;
use Toastr;
use File;
use Auth;
use Hash;

class ComplainController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:complain-list|complain-delete', ['only' => ['index','store']]);
         $this->middleware('permission:complain-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request){
        if($request->keyword){
            $show_data = Complain::orWhere('phone',$request->keyword)->orWhere('name',$request->keyword)->paginate(20);
        }else{
             $show_data = Complain::paginate(20);
        }
       
        return view('backEnd.complain.index',compact('show_data'));
    }
    public function destroy(Request $request)
    {
        $delete_data = Complain::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }

    
 
    
}
