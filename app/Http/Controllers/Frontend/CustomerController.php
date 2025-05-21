<?php

namespace App\Http\Controllers\Frontend;

use shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers\ShurjopayController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\ShippingCharge;
use App\Models\PaymentGateway;
use App\Models\GeneralSetting;
use App\Models\OrderDetails;
use App\Models\SmsGateway;
use App\Models\CouponCode;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\District;
use App\Models\Withdraw;
use App\Models\Deposit;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use Mail;

class CustomerController extends Controller
{

    function __construct()
    {
        $this->middleware('customer', ['except' => ['order_save_draft', 'register', 'customer_coupon', 'coupon_remove', 'store', 'verify', 'resendotp', 'account_verify', 'login', 'signin', 'logout', 'checkout', 'forgot_password', 'forgot_verify', 'forgot_reset', 'forgot_store', 'forgot_resend', 'order_save', 'order_success', 'order_track', 'order_track_result']]);
    }
    public function customer_coupon(Request $request)
    {
        $findcoupon = CouponCode::where('coupon_code', $request->coupon_code)->first();

        if ($findcoupon == NULL) {
            return response()->json(['status' => 'error', 'message' => 'Opps! your entered promo code is not valid'], 422);
        } else {
            $currentdate = date('Y-m-d');
            $expiry_date = $findcoupon->expiry_date;

            if ($currentdate <= $expiry_date) {
                $totalcart = Cart::instance('shopping')->subtotal();
                $totalcart = str_replace(['.00', ','], '', $totalcart);

                if ($totalcart >= $findcoupon->buy_amount) {
                    if ($findcoupon->offer_type == 1) {
                        $discountamount = (($totalcart * $findcoupon->amount) / 100);
                        Session::put('coupon_amount', $discountamount);
                        Session::put('coupon_used', $findcoupon->coupon_code);
                    } else {
                        Session::put('coupon_amount', $findcoupon->amount);
                        Session::put('coupon_used', $findcoupon->coupon_code);
                    }

                    return response()->json(['status' => 'success', 'message' => 'Success! your promo code accepted']);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You need to buy a minimum of ' . $findcoupon->buy_amount . ' Taka to get the offer'
                    ], 422);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Opps! Sorry your promo code has expired'
                ], 422);
            }
        }
    }

    public function coupon_remove(Request $request)
    {
        Session::forget('coupon_amount');
        Session::forget('coupon_used');
        Session::forget('discount');
        return response()->json(['status' => 'success', 'message' => 'Coupon removed successfully']);
    }
    public function review(Request $request)
    {
        $this->validate($request, [
            'ratting' => 'required',
            'review' => 'required',
        ]);

        // data save
        $review = new Review();
        $review->name = Auth::guard('customer')->user()->name ? Auth::guard('customer')->user()->name : 'N / A';
        $review->email = Auth::guard('customer')->user()->email ? Auth::guard('customer')->user()->email : 'N / A';
        $review->product_id = $request->product_id;
        $review->review = $request->review;
        $review->ratting = $request->ratting;
        $review->customer_id = Auth::guard('customer')->user()->id;
        $review->status = 'pending';
        $review->save();

        Toastr::success('Thanks, Your review send successfully', 'Success!');
        return redirect()->back();
    }

    public function login()
    {
        return view('frontEnd.layouts.customer.login');
    }

    public function signin(Request $request)
    {
        $auth_check = Customer::where('phone', $request->phone)->first();
        if ($auth_check) {
            if (Auth::guard('customer')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
                Toastr::success('You are login successfully');
                if ($request->review == 1) {
                    return redirect()->back();
                }
                if (Cart::instance('shopping')->count() > 0) {
                    return redirect()->route('customer.checkout');
                }
                return redirect()->intended('customer/products');
            }
            Toastr::error('Opps! your phone or password wrong');
            return redirect()->back();
        } else {
            Toastr::error('Sorry! You have no account');
            return redirect()->back();
        }
    }

    public function register()
    {
        return view('frontEnd.layouts.customer.register');
    }

    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|unique:customers',
            'password' => 'required|min:6'
        ]);

        $reffer = Customer::select('id', 'name', 'refferal_1', 'reseller_id')->where(['reseller_id' => $request->referral_id, 'type' => 1])->first();
        if (!$reffer) {
            return response()->json(['status' => 'noaccount']);
        }
        // reffer 2
        $refferal_2 = Customer::select('id', 'name', 'refferal_1', 'reseller_id')->where('id', $reffer ? $reffer->refferal_1 : '')->first();
        // reffer 3
        $refferal_3 = Customer::select('id', 'name', 'refferal_1', 'reseller_id')->where('id', $refferal_2 ? $refferal_2->refferal_1 : '')->first();
        // reffer 4
        $refferal_4 = Customer::select('id', 'name', 'refferal_1', 'reseller_id')->where('id', $refferal_3 ? $refferal_3->refferal_1 : '')->first();
        // reffer 5
        $refferal_5 = Customer::select('id', 'name', 'refferal_1', 'reseller_id')->where('id', $refferal_4 ? $refferal_4->refferal_1 : '')->first();

        $last_id = Customer::orderBy('id', 'desc')->first();
        $last_id = $last_id ? $last_id->id + 1 : 1;
        $reseller_id = mt_rand(111111, 999999);
        $store = new Customer();
        $store->name = $request->name;
        $store->slug = strtolower(Str::slug($request->name . '-' . $last_id));
        $store->phone = $request->phone;
        $store->email = $request->email;
        $store->type = $request->customer_type;
        $store->reseller_id = $reseller_id;
        $store->refferal_1 = $reffer->id;
        $store->refferal_2 = $refferal_2->id ?? NULL;
        $store->refferal_3 = $refferal_3->id ?? NULL;
        $store->refferal_4 = $refferal_4->id ?? NULL;
        $store->refferal_5 = $refferal_5->id ?? NULL;
        $store->category1 = $request->category;
        $store->password = bcrypt($request->password);
        $store->verify = 1;
        $store->status = 'active';
        $store->save();

        Toastr::success('Success', 'Account Create Successfully');
        return redirect()->route('customer.login');
    }
    public function verify()
    {
        return view('frontEnd.layouts.customer.verify');
    }
    public function resendotp(Request $request)
    {
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        $customer_info->verify = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where('status', 1)->first();
        if ($sms_gateway) {
            $url = "$sms_gateway->url";
            $data = [
                "api_key" => "$sms_gateway->api_key",
                "number" => $customer_info->phone,
                "type" => 'text',
                "senderid" => "$sms_gateway->serderid",
                "message" => "Dear $customer_info->name!\r\nYour account verify OTP is $customer_info->verify \r\nThank you for using $site_setting->name"
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        Toastr::success('Success', 'Resend code send successfully');
        return redirect()->back();
    }
    public function account_verify(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required',
        ]);
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        if ($customer_info->verify != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');
            return redirect()->back();
        }

        $customer_info->verify = 1;
        $customer_info->status = 'active';
        $customer_info->save();
        Auth::guard('customer')->loginUsingId($customer_info->id);
        return redirect()->route('customer.account');
    }
    public function forgot_password()
    {
        return view('frontEnd.layouts.customer.forgot_password');
    }

    public function forgot_verify(Request $request)
    {
        $customer_info = Customer::where('phone', $request->phone)->first();
        if (!$customer_info) {
            Toastr::error('Your phone number not found');
            return back();
        }
        $customer_info->forgot = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1, 'forget_pass' => 1])->first();
        if ($sms_gateway) {
            $url = "$sms_gateway->url";
            $data = [
                "api_key" => "$sms_gateway->api_key",
                "number" => $customer_info->phone,
                "type" => 'text',
                "senderid" => "$sms_gateway->serderid",
                "message" => "Dear $customer_info->name!\r\nYour forgot password verify OTP is $customer_info->forgot \r\nThank you for using $site_setting->name"
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        session::put('verify_phone', $request->phone);
        Toastr::success('Your account register successfully');
        return redirect()->route('customer.forgot.reset');
    }

    public function forgot_resend(Request $request)
    {
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        $customer_info->forgot = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1])->first();
        if ($sms_gateway) {
            $url = "$sms_gateway->url";
            $data = [
                "api_key" => "$sms_gateway->api_key",
                "number" => $customer_info->phone,
                "type" => 'text',
                "senderid" => "$sms_gateway->serderid",
                "message" => "Dear $customer_info->name!\r\nYour forgot password verify OTP is $customer_info->forgot \r\nThank you for using $site_setting->name"
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        Toastr::success('Success', 'Resend code send successfully');
        return redirect()->back();
    }
    public function forgot_reset()
    {
        if (!Session::get('verify_phone')) {
            Toastr::error('Something wrong please try again');
            return redirect()->route('customer.forgot.password');
        }
        ;
        return view('frontEnd.layouts.customer.forgot_reset');
    }
    public function forgot_store(Request $request)
    {

        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();

        if ($customer_info->forgot != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');
            return redirect()->back();
        }

        $customer_info->forgot = 1;
        $customer_info->password = bcrypt($request->password);
        $customer_info->save();
        if (Auth::guard('customer')->attempt(['phone' => $customer_info->phone, 'password' => $request->password])) {
            Session::forget('verify_phone');
            Toastr::success('You are login successfully', 'success!');
            return redirect()->intended('customer/account');
        }
    }
    public function account()
    {
        return view('frontEnd.layouts.customer.account');
    }
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        Toastr::success('You are logout successfully', 'success!');
        return redirect()->route('customer.login');
    }
    public function checkout()
    {
        $select_charge = ShippingCharge::where(['id' => 2])->first();
        $bkash_gateway = PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
        $shurjopay_gateway = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
        Session::put('shipping_id', $select_charge->id);
        Session::put('shipping', $select_charge->amount);
        $districts = District::distinct()->select('district')->orderBy('district', 'asc')->get();
        return view('frontEnd.layouts.customer.checkout', compact('select_charge', 'bkash_gateway', 'shurjopay_gateway', 'districts'));
    }

    public function order_save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if (Cart::instance('shopping')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');
            return response()->json();
        }

        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $discount = Session::get('discount') + Session::get('coupon_amount');
        $wholeseller = false;
        if ($request->id == "Dhaka") {
            $shipping_area = ShippingCharge::where('id', 1)->first();
        } else {
            $shipping_area = ShippingCharge::where('id', 2)->first();
        }
        if (Auth::guard('customer')->user()) {
            $customer_id = Auth::guard('customer')->user()->id;
        } else {
            $exits_customer = Customer::where('phone', $request->phone)->select('phone', 'id', 'type')->first();
            if ($exits_customer) {
                $customer_id = $exits_customer->id;
                $wholeseller = $exits_customer->type == 2 ? true : false;
            } else {
                $password = rand(111111, 999999);
                $store = new Customer();
                $store->name = $request->name;
                $store->slug = $request->name;
                $store->phone = $request->phone;
                $store->password = bcrypt($password);
                $store->type = 1;
                $store->verify = 1;
                $store->status = 'active';
                $store->save();
                $customer_id = $store->id;
                $wholeseller = $store->type == 2 ? true : false;
            }
        }
        // order data save
        $order = new Order();
        $order->invoice_id = rand(11111, 99999);
        $order->amount = ($subtotal + $shipping_area->amount) - $discount;
        $order->discount = $discount ? $discount : 0;
        $order->shipping_charge = $shipping_area->amount;
        $order->customer_id = $customer_id;
        $order->customer_ip = $request->ip();
        $order->order_type = $wholeseller ? 'wholesale' : 'resell';
        $order->order_status = 10;
        $order->note = $request->note;
        $order->save();

        // shipping data save
        $shipping = new Shipping();
        $shipping->order_id = $order->id;
        $shipping->customer_id = $customer_id;
        $shipping->name = $request->name;
        $shipping->phone = $request->phone;
        $shipping->address = $request->address;
        $shipping->area = $request->id;
        $shipping->save();

        // payment data save
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->customer_id = $customer_id;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $order->amount;
        $payment->payment_status = 'draft';
        $payment->save();

        // order details data save
        foreach (Cart::instance('shopping')->content() as $cart) {
            // return $cart;
            $order_details = new OrderDetails();
            $order_details->order_id = $order->id;
            $order_details->product_id = $cart->id;
            $order_details->product_name = $cart->name;
            $order_details->sale_price = $cart->price;
            $order_details->purchase_price = $cart->options->purchase_price;
            $order_details->product_color = $cart->options->product_color;
            $order_details->product_size = $cart->options->product_size;
            $order_details->product_size = $cart->options->product_size;
            $order_details->product_type = $cart->options->type;
            $order_details->qty = $cart->qty;
            $order_details->save();
        }

        Cart::instance('shopping')->destroy();
        Session::forget('free_shipping');
        Session::put('purchase_event', 'true');

        Toastr::success('Thanks, Your order place successfully', 'Success!');
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1, 'order' => '1'])->first();
        if ($sms_gateway) {
            $url = "$sms_gateway->url";
            $data = [
                "api_key" => "$sms_gateway->api_key",
                "number" => $request->phone,
                "type" => 'text',
                "senderid" => "$sms_gateway->serderid",
                "message" => "Dear $request->name!\r\nYour order ($order->invoice_id) has been successfully placed. Track your order https://quickshoppingbd.com/customer/order-track and Total Bill $order->amount\r\nThank you for using $site_setting->name"
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        if ($request->payment_method == 'bkash') {
            return redirect('/bkash/checkout-url/create?order_id=' . $order->id);
        } elseif ($request->payment_method == 'shurjopay') {
            $info = array(
                'currency' => "BDT",
                'amount' => $order->amount,
                'order_id' => uniqid(),
                'discsount_amount' => 0,
                'disc_percent' => 0,
                'client_ip' => $request->ip(),
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'email' => "customer@gmail.com",
                'customer_address' => $request->address,
                'customer_city' => $request->area,
                'customer_state' => $request->area,
                'customer_postcode' => "1212",
                'customer_country' => "BD",
                'value1' => $order->id
            );
            $shurjopay_service = new ShurjopayController();
            return $shurjopay_service->checkout($info);
        } else {
            return redirect('customer/order-success/' . $order->id);
        }
    }
    public function order_save2(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $customer_data = Customer::where('phone', $request->phone)->first();
        $draft_order = Order::where(['customer_id' => $customer_data->id, 'order_status' => 10])
            ->with('orderdetails')
            ->latest()->first();

        if ($draft_order == NULL) {
            Toastr::error('Failed', 'Something wrong, please refresh and try again');
            return back();
        }

        $order_id = $draft_order->id;

        if (Cart::instance('shopping')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');
            return redirect()->back();
        }

        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $discount = Session::get('discount') + Session::get('coupon_amount');


        if ($request->district == "Dhaka") {
            $shipping_area = ShippingCharge::where('id', 1)->first();
        } else {
            $shipping_area = ShippingCharge::where('id', 2)->first();
        }

        if (Auth::guard('customer')->user()) {
            $customer_id = Auth::guard('customer')->user()->id;
        } else {
            $exits_customer = Customer::where('phone', $request->phone)->select('phone', 'id')->first();
            if ($exits_customer) {
                $customer_id = $exits_customer->id;
            } else {
                $password = rand(111111, 999999);
                $store = new Customer();
                $store->name = $request->name;
                $store->slug = $request->name;
                $store->phone = $request->phone;
                $store->password = bcrypt($password);
                $store->verify = 1;
                $store->status = 'active';
                $store->save();
                $customer_id = $store->id;
            }
        }
        // order data save
        $order = Order::where('id', $order_id)->first();
        $order->invoice_id = rand(11111, 99999);
        $order->amount = ($subtotal + $shipping_area->amount) - $discount;
        $order->discount = $discount ? $discount : 0;
        $order->shipping_charge = $shipping_area->amount;
        $order->customer_id = $customer_id;
        $order->customer_ip = $request->ip();
        $order->order_type = Session::get('free_shipping') ? 'digital' : 'goods';
        $order->order_status = 1;
        $order->note = $request->note;
        $order->save();

        // shipping data save
        $shipping = Shipping::where('order_id', $order_id)->first();
        $shipping->order_id = $order->id;
        $shipping->customer_id = $customer_id;
        $shipping->name = $request->name;
        $shipping->phone = $request->phone;
        $shipping->address = $request->address;
        $shipping->area = $request->district;
        $shipping->save();

        // payment data save
        $payment = Payment::where('order_id', $order_id)->first();
        $payment->order_id = $order->id;
        $payment->customer_id = $customer_id;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $order->amount;
        $payment->payment_status = 'pending';
        $payment->save();

        // order details data save
        foreach ($order->orderdetails as $orderdetail) {
            $item = Cart::instance('sale')->content()->where('id', $orderdetail->product_id)->first();
            if (!$item) {
                $orderdetail->delete();
            }
        }

        foreach (Cart::instance('shopping')->content() as $cart) {
            // return $cart;
            $orderIds = $draft_order->orderdetails->pluck('order_id');
            $exits = OrderDetails::whereIn('order_id', $orderIds)->first();

            if ($exits) {
                $order_details = OrderDetails::find($exits->id);
                $order_details->product_discount = $cart->options->product_discount;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            } else {
                $order_details = new OrderDetails();
                $order_details->order_id = $order->id;
                $order_details->product_id = $cart->id;
                $order_details->product_name = $cart->name;
                $order_details->sale_price = $cart->price;
                $order_details->purchase_price = $cart->options->purchase_price;
                $order_details->product_color = $cart->options->product_color;
                $order_details->product_size = $cart->options->product_size;
                $order_details->product_size = $cart->options->product_size;
                $order_details->product_type = $cart->options->type;
                $order_details->qty = $cart->qty;
                $order_details->save();
            }
        }

        Cart::instance('shopping')->destroy();
        Session::forget('free_shipping');
        Session::put('purchase_event', 'true');

        Toastr::success('Thanks, Your order place successfully', 'Success!');
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1, 'order' => '1'])->first();
        if ($sms_gateway) {
            $url = "$sms_gateway->url";
            $data = [
                "api_key" => "$sms_gateway->api_key",
                "number" => $request->phone,
                "type" => 'text',
                "senderid" => "$sms_gateway->serderid",
                "message" => "Dear $request->name!\r\nYour order ($order->invoice_id) has been successfully placed. Track your order https://quickshoppingbd.com/customer/order-track and Total Bill $order->amount\r\nThank you for using $site_setting->name"
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        if ($request->payment_method == 'bkash') {
            return redirect('/bkash/checkout-url/create?order_id=' . $order->id);
        } elseif ($request->payment_method == 'shurjopay') {
            $info = array(
                'currency' => "BDT",
                'amount' => $order->amount,
                'order_id' => uniqid(),
                'discsount_amount' => 0,
                'disc_percent' => 0,
                'client_ip' => $request->ip(),
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'email' => "customer@gmail.com",
                'customer_address' => $request->address,
                'customer_city' => $request->area,
                'customer_state' => $request->area,
                'customer_postcode' => "1212",
                'customer_country' => "BD",
                'value1' => $order->id
            );
            $shurjopay_service = new ShurjopayController();
            return $shurjopay_service->checkout($info);
        } else {
            return redirect('customer/order-success/' . $order->id);
        }
    }

    public function orders()
    {
        $orders = Order::where('customer_id', Auth::guard('customer')->user()->id)->with('status')->latest()->get();
        return view('frontEnd.layouts.customer.orders', compact('orders'));
    }
    public function order_success($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        return view('frontEnd.layouts.customer.order_success', compact('order'));
    }

    public function invoice(Request $request)
    {
        $order = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->with('orderdetails', 'payment', 'shipping', 'customer')->firstOrFail();

        $orders = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->with('orderdetails')->first();
        // return $orders;
        return view('frontEnd.layouts.customer.invoice', compact('order', 'orders'));
    }
    public function pdfreader(Request $request)
    {
        $order = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->with('orderdetails', 'payment', 'shipping', 'customer')->firstOrFail();

        $orders = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->with('orderdetails')->first();
        // return $orders;
        return view('frontEnd.layouts.customer.pdfreader', compact('order', 'orders'));
    }


    public function order_note(Request $request)
    {
        $order = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->firstOrFail();
        return view('frontEnd.layouts.customer.order_note', compact('order'));
    }
    public function profile_edit(Request $request)
    {
        $profile_edit = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();
        $districts = District::distinct()->select('district')->get();
        $areas = District::where(['district' => $profile_edit->district])->select('area_name', 'id')->get();
        return view('frontEnd.layouts.customer.profile_edit', compact('profile_edit', 'districts', 'areas'));
    }
    public function profile_update(Request $request)
    {
        $update_data = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();

        $image = $request->file('image');
        if ($image) {
            // image with intervention
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(Str::slug($name));
            $uploadpath = 'public/uploads/customer/';
            $imageUrl = $uploadpath . $name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 120;
            $height = 120;
            $img->resize($width, $height);
            $img->save($imageUrl);
        } else {
            $imageUrl = $update_data->image;
        }

        $update_data->name = $request->name;
        $update_data->phone = $request->phone;
        $update_data->email = $request->email;
        $update_data->address = $request->address;
        $update_data->district = $request->district;
        $update_data->area = $request->area;
        $update_data->image = $imageUrl;
        $update_data->save();

        Toastr::success('Your profile update successfully', 'Success!');
        return redirect()->route('customer.account');
    }

    public function order_track()
    {
        return view('frontEnd.layouts.customer.order_track');
    }

    public function order_track_result(Request $request)
    {

        $phone = $request->phone;
        $invoice_id = $request->invoice_id;

        if ($phone != null && $invoice_id == null) {
            $order = DB::table('orders')
                ->join('shippings', 'orders.id', '=', 'shippings.order_id')
                ->where(['shippings.phone' => $request->phone])
                ->get();
        } else if ($invoice_id && $phone) {
            $order = DB::table('orders')
                ->join('shippings', 'orders.id', '=', 'shippings.order_id')
                ->where(['orders.invoice_id' => $request->invoice_id, 'shippings.phone' => $request->phone])
                ->get();
        }

        if ($order->count() == 0) {

            Toastr::error('message', 'Something Went Wrong !');
            return redirect()->back();
        }

        //   return $order->count();

        return view('frontEnd.layouts.customer.tracking_result', compact('order'));
    }


    public function change_pass()
    {
        return view('frontEnd.layouts.customer.change_password');
    }

    public function password_update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $hashPass = $customer->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $customer->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('customer.account');
        } else {
            Toastr::error('Failed', 'Old password not match!');
            return redirect()->back();
        }
    }

    public function products()
    {
        $customer = Auth::guard('customer')->user();
        $categoryIds = collect([
            $customer->category1,
            $customer->category2,
            $customer->category3
        ])->filter()->unique();
        $validCategoryIds = Category::whereIn('id', $categoryIds)->pluck('id');
        $products = Product::where('status', 1)->whereIn('category_id', $validCategoryIds)->paginate(30);
        return view('frontEnd.layouts.customer.products', compact('products'));
    }

    public function categories()
    {
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        return view('frontEnd.layouts.customer.categories', compact('customer'));
    }

    public function category_update(Request $request)
    {
        $update_data = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();
        $update_data->category1 = $request->category1;
        $update_data->category2 = $request->category2;
        $update_data->category3 = $request->category3;
        $update_data->save();

        Toastr::success('Your category update successfully', 'Success!');
        return redirect()->route('customer.account');
    }

    public function deposit_create()
    {
        return view('frontEnd.layouts.customer.deposit');
    }

    public function deposit_store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'payment_method' => 'required',
            'sender_number' => 'required',
            'transaction_id' => 'required',
            'message' => 'required',
        ]);

        $complain = new Deposit();
        $complain->amount = $request->amount;
        $complain->payment_method = $request->payment_method;
        $complain->sender_number = $request->sender_number;
        $complain->transaction_id = $request->transaction_id;
        $complain->message = $request->message;
        $complain->customer_id = Auth::guard('customer')->user()->id;
        $complain->status = 'pending';
        $complain->created_at = Carbon::now();
        $complain->save();

        Toastr::success('Your deposit added successfully');
        return redirect()->route('customer.account');
    }

    public function deposit_history(Request $request)
    {
        $deposithistory = Deposit::where('customer_id', Auth::guard('customer')->user()->id)->get();
        return view('frontEnd.layouts.customer.deposit_history', compact('deposithistory'));
    }
    public function withdraw_create()
    {
        return view('frontEnd.layouts.customer.withdraw');
    }
    public function withdraw_store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'payment_method' => 'required',
            'account_number' => 'required',
            'message' => 'required',
        ]);

        $complain = new Withdraw();
        $complain->amount = $request->amount;
        $complain->payment_method = $request->payment_method;
        $complain->account_number = $request->account_number;
        $complain->message = $request->message;
        $complain->customer_id = Auth::guard('customer')->user()->id;
        $complain->status = 'pending';
        $complain->created_at = Carbon::now();
        $complain->save();

        Toastr::success('Your withdraw added successfully');
        return redirect()->route('customer.account');
    }
    public function withdraw_history(Request $request)
    {
        $withdrawhistory = Withdraw::where('customer_id', Auth::guard('customer')->user()->id)
            ->get();

        return view('frontEnd.layouts.customer.withdraw_history', compact('withdrawhistory'));
    }

    public function members(Request $request)
    {
        if ($request->level == 1) {
            $members = Customer::where(['refferal_1' => Auth::guard('customer')->user()->id])->select('id', 'name', 'phone', 'status')->get();
        } elseif ($request->level == 2) {
            $members = Customer::where(['refferal_2' => Auth::guard('customer')->user()->id])->select('id', 'name', 'phone', 'status')->get();
        } elseif ($request->level == 3) {
            $members = Customer::where(['refferal_3' => Auth::guard('customer')->user()->id])->select('id', 'name', 'phone', 'status')->get();
        } elseif ($request->level == 4) {
            $members = Customer::where(['refferal_4' => Auth::guard('customer')->user()->id])->select('id', 'name', 'phone', 'status')->get();
        } elseif ($request->level == 5) {
            $members = Customer::where(['refferal_5' => Auth::guard('customer')->user()->id])->select('id', 'name', 'phone', 'status')->get();
        }
        return view('frontEnd.layouts.customer.members', compact('members'));
    }
}
