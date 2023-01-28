@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Appliances Deliveries Page</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{route('appliancesDeliveries.add')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Deliveries </a> <br>  <br>               

                    <h4 class="card-title">Appliances Deliveries Data </h4>


                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Ref No.</th> 
                            <th>Date</th>                             
                            <th>Supplier</th> 
                            <th>Category</th>
                            <th>Brand</th>                            
                            <th>Model</th>
                            <th>Serial #</th>
                            <th>Qty</th>
                            <th>Unit Cost</th>                            
                            <th>Status</th>                                                                                                             
                            <th>Action</th>                                                                
                        
                            

                        </thead>


                        <tbody>

                        	@foreach($appliancesDeliveries as $key => $item)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $item->reference}} </td>
                            <td> {{ $item->date_in }} </td>  
                            <td> {{ $item['supplier']['name']}} </td>    <!--$product['eloquent function name'][fieldName from related table]   -->
                            <td> {{ $item['category']['name']}} </td> <!--BUGGED   -->
                            <td> {{ $item['getBrand']['name']}} </td>                            
                            
                            <td> {{ $item['getProducts']['product_model']}} </td>                                                                                                                                                  
                            <td> {{ $item['getSerials']['name'] }} </td>  
                            <td> {{ $item->qty}} </td>                                    
                            <td> {{ $item->unit_cost}}</td>  
                            <td>
                                @if($item->status == '0')
                                    <span class="btn btn-success" title="Prestine" ><i class="fas fa-check-circle" title="Prestine" onClick="myFunction()"></i></span> 
                                @elseif($item->status == '1')
                                <span class="btn btn-danger">Defective</span>
                                @endif
                            </td> 
                            
                            <td> 
                                @if(Auth::user()->id == 1) <!-- 1=admin 0=user -->                                                                                           
                                    <a href="{{route('appliancesDeliveries.delete',$item->id)}}" class="btn btn-danger sm " title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>                                                               
                                @endif
                            </td>

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