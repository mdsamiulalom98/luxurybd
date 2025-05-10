<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Deposit;
use App\Models\Customer;

class DepositController extends Controller
{
    public function all()
    {
        $show_data = Deposit::paginate(20);
        return view('backEnd.deposit.all', compact('show_data'));
    }
    public function pending()
    {
        $show_data = Deposit::where('status', 'pending')->paginate(20);
        return view('backEnd.deposit.pending', compact('show_data'));
    }
    public function accepted()
    {
        $show_data = Deposit::where('status', 'accepted')->paginate(20);
        return view('backEnd.deposit.accepted', compact('show_data'));
    }
    public function return()
    {
        $show_data = Deposit::where('status', 'returned')->paginate(20);
        return view('backEnd.deposit.return', compact('show_data'));
    }
    public function status(Request $request)
    {
        $deposit_update = Deposit::find($request->hidden_id);
        $deposit_update->status = $request->status;
        $deposit_update->save();

        // balance update accepted
        if ($request->status == 'accepted') {
            $balance_update = Customer::find($deposit_update->customer_id);
            $balance_update->dpbalance += $deposit_update->amount;
            $balance_update->save();
        }
        // balance update return
        if ($request->status == 'returned') {
            $balance_update = Customer::find($deposit_update->customer_id);
            $balance_update->dpbalance -= $deposit_update->amount;
            $balance_update->save();
        }
        Toastr::success('Deposit Balance update successfully!');
        return redirect()->back();
    }
}
