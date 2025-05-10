<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsStiker;
use Image;
use File;
use Toastr;

class NewsStikerController extends Controller
{
       function __construct()
    {
         $this->middleware('permission:news-list|news-create|news-edit|news-delete', ['only' => ['index','store']]);
         $this->middleware('permission:news-create', ['only' => ['create','store']]);
         $this->middleware('permission:news-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:news-delete', ['only' => ['destroy']]);
    }

     public function index(Request $request)
    {
        $data = NewsStiker::orderBy('id','DESC')->get();
        return view('backEnd.newsStiker.index',compact('data'));
    }
    public function create()
    {
        return view('backEnd.newsStiker.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'news' => 'required',
            'status' => 'required',
        ]);
        

        $input = $request->all();
        NewsStiker::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('news.index');
    }
    
    public function edit($id)
    {
        $edit_data = NewsStiker::find($id);
        return view('backEnd.newsStiker.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'news' => 'required',
        ]);
        $update_data = NewsStiker::find($request->id);
        $input = $request->all();
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('news.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = NewsStiker::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = NewsStiker::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = NewsStiker::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
