@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>
                </div>
                <div>
                    <p class="text-truncate font-size-14 mb-2"><h4 class="text-primary">{{$curentMonth}}</h4> </p>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                
                                <p class="text-truncate font-size-14 mb-2">Total Appliances Sold</p>
                                <h4 class="mb-2">{{ $currentMonthAppliancesSold }}</h4>
                               
                                @if($percentageIncreaseApp)                                         
                                    <p class="text-muted mb-0"><span class="text-success" fw-bold font-size-12 me-2">                                      
                                    <i class='ri-arrow-right-up-line me-1 align-middle'></i>{{number_format($percentageIncreaseApp, 2, '.');}}%</span> from previous month</p>
                                @elseif($percentageDecreaseApp)
                                    <p class="text-muted mb-0"><span class="text-danger" fw-bold font-size-12 me-2">                                      
                                    <i class='ri-arrow-right-down-line me-1 align-middle'></i>{{number_format($percentageDecreaseApp, 2, '.')}}%</span> from previous month</p>
                                @elseif($equalApp)
                                    <p class="text-muted mb-0">
                                        <span class="text-danger  fw-bold font-size-12  me-2">No changes from previous month</span>                                      
                                    </p>
                                @endif
                                            
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-shopping-cart-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Furniture Sold</p>
                                <h4 class="mb-2">{{$currentMonthFurnitureSold}}</h4>
                                @if($percentageIncreaseFur)                                         
                                        <p class="text-muted mb-0"><span class="text-success" fw-bold font-size-12 me-2">                                      
                                        <i class='ri-arrow-right-up-line me-1 align-middle'></i>{{number_format($percentageIncreaseFur, 2, '.')}}%</span> from previous month</p>
                                @elseif($percentageDecreaseFur)
                                    <p class="text-muted mb-0"><span class="text-danger" fw-bold font-size-12 me-2">                                      
                                    <i class='ri-arrow-right-down-line me-1 align-middle'></i>{{number_format($percentageDecreaseFur, 2, '.')}}%</span> from previous month</p>
                                    @elseif($equalFur)
                                    <p class="text-muted mb-0">
                                        <span class="text-danger  fw-bold font-size-12  me-2">No changes from previous month</span>                                      
                                    </p>
                                @endif
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-shopping-cart-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Defective Appliances on Hand</p>
                                <h4 class="mb-2">{{$totalDefectiveApp}}</h4>
                                @if($increaseDefApp)                                                                                 
                                        <p class="text-muted mb-0"><span class="text-danger" fw-bold font-size-12 me-2">                                      
                                        <i class='ri-arrow-right-up-line me-1 align-middle'></i>{{number_format($increaseDefApp, 2, '.')}}%</span> from previous month</p>                                
                                @elseif($evenApp)
                                    <p class="text-muted mb-0">
                                        <span class="text-success  fw-bold font-size-14  me-2">Same from previous month</span>                                      
                                    </p>                                                
                                @elseif($decreaseDefApp)
                                    <p class="text-muted mb-0"><span class="text-info" fw-bold font-size-12 me-2">                                      
                                    <i class='ri-arrow-right-down-line me-1 align-middle'></i>{{number_format($decreaseDefApp, 2, '.')}}%</span> from previous month</p>        
                                @elseif($noDefApp)
                                    <p class="text-muted mb-0">
                                        <span class="text-success  fw-bold font-size-14  me-2">0% defective this month</span>                                      
                                    </p>
                                @endif                                                                
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-danger rounded-3">
                                    <i class="mdi mdi-image-broken-variant font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Defective Furnitures on Hand</p>
                                <h4 class="mb-2">{{$totalDefectiveFur}}</h4>
                                    
                                @if($increaseDefFur)                                                                                 
                                        <p class="text-muted mb-0"><span class="text-danger" fw-bold font-size-12 me-2">                                      
                                        <i class='ri-arrow-right-up-line me-1 align-middle'></i>{{number_format($increaseDefFur, 2, '.')}}%</span> from previous month</p>                                
                                @elseif($even)
                                    <p class="text-muted mb-0">
                                        <span class="text-success  fw-bold font-size-14  me-2">Same from previous month</span>                                      
                                    </p>                                                
                                @elseif($decreaseDefFur)
                                    <p class="text-muted mb-0"><span class="text-info" fw-bold font-size-12 me-2">                                      
                                    <i class='ri-arrow-right-down-line me-1 align-middle'></i>{{number_format($decreaseDefFur, 2, '.')}}%</span> from previous month</p>        
                                @elseif($noDefFur)
                                    <p class="text-muted mb-0">
                                        <span class="text-success  fw-bold font-size-14  me-2">0% defective this month</span>                                      
                                    </p>
                                @endif 
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-danger rounded-3">
                                    <i class="mdi mdi-image-broken-variant font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div>    

      
    <div class="row">
        <div class="col-xl-6 ps-4">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>

                    </div>

                    <h4 class="card-title mb-4">Appliances Best Sellers - {{ $curentMonth }}</h4>

                    <div class="table-responsive">
                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Product Model </th>
                                    <th>Supplier</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Description </th>
                                    <th style="width: 120px;">Qty Sold</th>
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                                @foreach($bestSellersApp as $item)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0">
                                                {{ $item['getProduct']['product_model'] }}
                                            </h6>
                                        </td>
                                        <td>{{ $item['getSupplier']['name'] }}
                                        </td>
                                        <td>
                                            {{ $item['getCategory']['name'] }}
                                        </td>
                                        <td>
                                            {{ $item['getBrand']['name'] }}
                                        </td>
                                        <td>
                                            {{ $item['getProduct']['description'] }}
                                        </td>
                                        <td>{{ $item->total }}</td>
                                    </tr> <!-- end tr-->
                                @endforeach
                                <!-- end -->
                            </tbody><!-- end tbody -->
                        </table> <!-- end table -->
                    </div>
                </div><!-- end card -->
            </div><!-- end card -->
        </div><!-- end col -->    

        <div class="col-xl-6 pe-4">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>

                    </div><!-- end of table -->

                    <h4 class="card-title mb-4">Furnitures Best Sellers - {{ $curentMonth }}</h4>

                    <div class="table-responsive">
                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Product Model </th>
                                    <th>Supplier</th>
                                    <th>Category</th>
                                    <th>Description </th>
                                    <th style="width: 120px;">Qty Sold</th>
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                                @foreach($bestSellersFur as $item)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0">
                                                {{ $item['getProduct']['product_model'] }}
                                            </h6>
                                        </td>
                                        <td>{{ $item['getSupplier']['name'] }}
                                        </td>
                                        <td>
                                            {{ $item['getCategory']['name'] }}
                                        </td>
                                        <td>
                                            {{ $item['getProduct']['description'] }}
                                        </td>
                                        <td>{{ $item->total }}</td>
                                    </tr> <!-- end tr-->
                                @endforeach

                                <!-- end -->
                            </tbody><!-- end tbody -->
                        </table> <!-- end table -->
                    </div>
                </div><!-- end card -->
            </div><!-- end card -->
        </div><!-- end col -->    
    </div><!-- end row -->
    
            
        
        
    @endsection