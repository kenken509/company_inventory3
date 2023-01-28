@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Furnitures Working Stocks Page</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">                   
                    <h4 class="card-title">Furnitures Data </h4>


                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#</th>                            
                            <th>Supplier</th> 
                            <th>Category</th>                                                                                                                                             
                            <th>Model</th>                            
                            <th>Qty</th>
                            <th>Unit Cost</th>                            
                            <th>GDP/SRP</th>
                            <th>TOTAL GDP</th>
                            <th>Date In</th>
                            <th>Ref. In</th> 
                            <th>Date Out</th> 
                            <th>Ref. Out</th>                            
                            <th>Remarks</th>                                                                                                                                                                     
                        </thead>


                        <tbody>

                        	@foreach($furnitures as $key => $item)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $item['getSuppliers']['name']}} </td>
                            <td> {{ $item['getCategories']['name']}}</td> 
                            <td> {{ $item->product_model}} </td>  
                            <td> {{ $item->qty}} </td>                                    
                            <td> {{ $item->unit_cost == null ? '--': number_format($item->unit_cost, 2, '.', ',')}}</td>   
                            <td> {{ $item->srp_gdp == null ? '--': number_format($item->srp_gdp, 2, '.', ',')}}</td> 
                            <td> {{ $item->total_gdp == null ? '--': number_format($item->total_gdp, 2, '.', ',')}}</td> 
                            <td> 
                                <ul>
                                    @forelse($item->getDr as $dr)                                    
                                            <li>{{date('M-d-Y', strtotime($dr['date_in']))}}</li> 
                                    @empty
                                        <p>--</p>                                           
                                    @endforelse   
                                </ul>  
                            </td>
                            <td> 
                                <ul>
                                    @forelse($item->getDr as $dr)                                    
                                            <li>{{$dr['reference_name']}}</li> 
                                    @empty
                                            <p>--</p>  
                                    @endforelse   
                                </ul> 
                            </td>
                            <td> 
                                <ul>
                                    @forelse($item->getSi as $si)                                    
                                            <li>{{date('M-d-Y', strtotime($si['date_out']))}}</li> 
                                    @empty
                                        <p>--</p>                                           
                                    @endforelse   
                                </ul>  
                            </td>
                            <td> 
                                <ul>
                                    @forelse($item->getSi as $si)                                    
                                            <li>{{$si['reference_name']}}</li> 
                                    @empty
                                            <p>--</p>  
                                    @endforelse   
                                </ul> 
                            </td>
                            <td>                                 
                                @forelse($item->getDr as $dr)                                                                    
                                        <p>{{$dr['remarks'] == null ? '--': $dr['remarks']}}</p>                                    
                                @empty
                                    <p>--</p>
                                @endforelse
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