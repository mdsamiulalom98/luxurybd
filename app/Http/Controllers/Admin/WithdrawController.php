<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Withdraw;
use App\Models\Customer;

class WithdrawController extends Controller
{
    public function all()
    {
        $show_data = Withdraw::paginate(20);
        return view('backEnd.withdraw.all', compact('show_data'));
    }
    public function pending()
    {
        $show_data = Withdraw::where('status', 'pending')->paginate(20);
        return view('backEnd.withdraw.pending', compact('show_data'));
    }
    public function accepted()
    {
        $show_data = Withdraw::where('status', 'accepted')->paginate(20);
        return view('backEnd.withdraw.accepted', compact('show_data'));
    }
    public function return()
    {
        $show_data = Withdraw::where('status', 'return')->paginate(20);
        return view('backEnd.withdraw.return', compact('show_data'));
    }
    public function status(Request $request)
    {
        $deposit_update = Withdraw::find($request->hidden_id);
        $deposit_update->status = $request->status;
        $deposit_update->save();

        // balance update accepted
        if ($request->status == 'accepted') {
            $balance_update = Customer::find($deposit_update->customer_id);
            $balance_update->inbalance -= $deposit_update->amount;
            $balance_update->save();
        }
        // balance update return
        if ($request->status == 'returned') {
            $balance_update = Customer::find($deposit_update->customer_id);
            $balance_update->inbalance += $deposit_update->amount;
            $balance_update->save();
        }
        Toastr::success('message', 'Withdraw Balance update successfully!');
        return redirect()->back();
    }
}
