<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BookingController extends FrontBaseController
{
    protected $panel = 'Booking';  //for section/moudule
    protected $folder = 'frontend.customer.'; //for view file
    protected $base_route = 'frontend.customer.'; //for route method
    protected $folder_name = 'customer'; //for route method
    protected $title;
    protected $model = 'Booking';

    function __construct()
    {
        $this->model = new Booking();

    }


    public function index(){
        $this->title = 'List';
        $data['fds'] = Booking::all();
        return view($this->__loadDataToView($this->folder . 'index'), compact('data' ));

    }


    public function create()
    {
//        dd('hello');
        $this->title = 'Create';
        return view($this->__loadDataToView($this->folder . 'create'));
    }

    public function store(BookingRequest $request){
//        dd($request->all());
        if (isset(Auth::guard('customer')->user()->id)) {
            $bookingData = [];
            $bookingData['costume_id'] = $request->product_id;
            $bookingData['quantity'] = $request->qty;
            $bookingData['size'] =  $request->size;
            $bookingData['price'] = $request->price;
            $bookingData['total_price'] = $bookingData['price'] * $bookingData['quantity'];
            $bookingData['customer_id'] = Auth::guard('customer')->user()->id;
            $bookingData['order_code'] = uniqid();
            $bookingData['booking_date'] = date('Y-m-d H:i:s');
//            dd($bookingData);
            Booking::create($bookingData);

        $request->session()->flash('success', 'Your booking is successfull');
        return redirect()->route('dashboard.bookings');
        }
        else{
            $request->session()->flash('error','Please login to book your costume!');
            return redirect()->route('customer.login');
        }

    }



    public function show($id){
        //
    }


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
        $data['row']=$this->model->find($id);
        $data['row']->delete();
        if($data['row'])
        {
            request()->session()->flash('success','Your booking was canceled');
        }
        else
        {
            request()->session()->flash('error','Error in deleting'.$this->panel);
        }
        return redirect()->route('dashboard.bookings');
    }
    public function backIndex(){
        $data['rows']=Booking::all();
        return view($this->__loadDataToView('backend.booking.index'),compact('data'));

    }
    public function statusChange($id){
        Booking::where('id',$id)->update(array('order_status'=>'1'));
        return redirect()->route('booking.Backindex');
    }
}
