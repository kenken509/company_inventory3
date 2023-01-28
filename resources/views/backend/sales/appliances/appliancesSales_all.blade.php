@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Appliances Sales Page</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{route('appliancesSales.add')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Sales </a> <br>  <br>               

                    <h4 class="card-title">Appliances Sales Data </h4>


                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>      
                            <th>Ref No.</th>
                            <th>Product Model</th>                                                      
                            <th>Supplier</th> 
                            <th>Category</th>
                            <th>Brand</th>                            
                            <th>Description</th>
                            <th>Serial #</th>
                            <th>Qty</th>
                            <th>Unit Cost</th> 
                            <th>Remarks</th>                           
                            <th>Payment</th>                                                                                                             
                                                                                                                                                
                        </thead>


                        <tbody>

                        	@foreach($appliancesSales as $key => $item)
                        <tr>
                            
                            <td> {{ $key+1}} </td>
                            <td> {{ date("M-d-Y", strtotime($item->date_out)) }} </td> 
                            <td> {{ $item->reference}} </td> 
                            <td> {{ $item['getProduct']['product_model']}} </td>            
                            <td> {{ $item['getSupplier']['name']}} </td>    <!--$product['eloquent function name'][fieldName from related table]   -->
                            <td> {{ $item['getCategory']['name']}} </td>
                            <td> {{ $item['getBrand']['name']}} </td>                            
                            <td> {{ $item->description}} </td>                             
                            <td> {{ $item['getSerial']['name']}} </td>  
                            <td> {{ $item->qty}} </td>                                    
                            <td> {{ $item->unit_cost}}</td>
                            <td> {{ $item->remarks}} </td>                                                                                        
                            <td>
                                @if($item->payment_mode == '0')
                                    <p>Loan</p>
                                @elseif($item->payment_mode == '1')
                                    <p>Cash</p>
                                @elseif($item->payment_mode == '2')
                                <p>COD</p>
                                @endif
                            </td> 
                            
                            {{-- <td> 
                                @if(Auth::user()->id == 1) <!-- 1=admin 0=user -->                                                                                           
                                    <a href="{{route('appliancesSales.delete',$item->id)}}" class="btn btn-danger sm " title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>                                                               
                                @endif
                            </td> --}}

                        </tr>
                        @endforeach

                        </tbody>
                    </table>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <script>
                    function myFunction() {
                      alert("Prestine");
                    }
                </script>

@endsection