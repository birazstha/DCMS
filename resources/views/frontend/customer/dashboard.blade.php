@extends('frontend.layout.master')
@section('content')


    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">My Account</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- My Account Start -->
    <div class="my-account">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="dashboard-nav" data-toggle="pill" href="#dashboard-tab" role="tab"><i class="fa fa-tachometer-alt"></i>Dashboard</a>
                        <a class="nav-link" id="orders-nav" data-toggle="pill" href="#orders-tab" role="tab"><i class="fa fa-shopping-bag"></i>My Bookings</a>
                        <a class="nav-link" id="payment-nav" data-toggle="pill" href="#payment-tab" role="tab"><i class="fa fa-credit-card"></i>Payment Method</a>
                        <a class="nav-link" id="account-nav" data-toggle="pill" href="#account-tab" role="tab"><i class="fa fa-user"></i>Account Details</a>
                        <a class="nav-link" href="{{route('customer.logout')}}"><i class="fa fa-sign-out-alt"></i>Logout</a>
                    </div>
                </div>

                <div class="col-md-9">
                    @if(Session::has('success'))
                        <p class="alert alert-success">{{Session::get('success')}}</p>
                    @endif
                    @if(Session::has('error'))
                        <p class="alert alert-danger">{{Session::get('error')}}</p>
                    @endif

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="dashboard-tab" role="tabpanel" aria-labelledby="dashboard-nav">
                            <h4>Dashboard</h4>
                            <p>
                                Welcome {{Auth::guard('customer')->user()->fname}}!!
                            </p>
                        </div>
                        <div class="tab-pane fade" id="orders-tab" role="tabpanel" aria-labelledby="orders-nav">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Product</th>
                                        <th>Order Code</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total Price</th>
                                        <th>Booking Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($data['booking'] as $index=>$costume)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$costume->bookingDetail->costume->name}}</td>
                                        <td>{{$costume->order_code}}</td>
                                        <td>{{$costume->bookingDetail->size}}</td>
                                        <td>{{$costume->bookingDetail->quantity}}</td>
                                        <td>{{$costume->bookingDetail->price}}</td>
                                        <td>{{$costume->bookingDetail->total_price}}</td>
                                        <td>{{$costume->booking_date}}</td>
                                        <td>

                                            {!!  Form::open(['route' => ['booking.destroy',$costume->id],'method'=>'post','class'=>'d-inline']) !!}

                                            {!! Form::hidden('_method','DELETE') !!}

                                            {!!  Form::submit('Cancel',['class'=>'btn btn-danger','onclick'=>"return confirm('Are you sure you want to delete this item?');"]) !!}

                                            {!! Form::close() !!}



                                        </td>
                                    @empty
                                        <tr>
                                            <td style="color:red"; colspan="9">No bookings are made</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment-tab" role="tabpanel" aria-labelledby="payment-nav">
                            <h4>Payment Method</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In condimentum quam ac mi viverra dictum. In efficitur ipsum diam, at dignissim lorem tempor in. Vivamus tempor hendrerit finibus. Nulla tristique viverra nisl, sit amet bibendum ante suscipit non. Praesent in faucibus tellus, sed gravida lacus. Vivamus eu diam eros. Aliquam et sapien eget arcu rhoncus scelerisque.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="account-tab" role="tabpanel" aria-labelledby="account-nav">
                            <h4>Account Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="form-control" type="text" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" placeholder="Last Name">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" placeholder="Mobile">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" placeholder="Email">
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control" type="text" placeholder="Address">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn">Update Account</button>
                                    <br><br>
                                </div>
                            </div>
                            <h4>Password change</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <input class="form-control" type="password" placeholder="Current Password">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" placeholder="New Password">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" placeholder="Confirm Password">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- My Account End -->
@endsection
