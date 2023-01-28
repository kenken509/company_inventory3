@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

                        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Merchandise Returns Page</h4>
                </div>
            </div>
        </div>
                        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Returned Units Data</h4>

                        
                        <table id="datatable" class="table table-bordered dt-responsive  text-break" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>MRS #</th>
                                    <th>Supplier</th><!--Supplier-->                
                                    <th>Brand</th>                             
                                    <th>Description</th> 
                                    <th>Model</th>
                                    <th>Serial #</th>
                                    <th>Qty</th>
                                    <th>Unit Cost</th>
                                    <th>Total Cost</th>
                                    <th>Reference-in</th>                                    
                                    <th>Returned date</th>                                                                                                                                     
                                </tr>
                            </thead>


                            <tbody id="example">
                                @foreach($mrs as $key => $item)
                                   <tr>
                                     
                                     <td>{{$key+1}}</td>
                                     <td> {{ $item->appliances_defective_id ? $item['getDefectiveAppliances']['getSupplier']['name'] : $item['getDefectiveFurniture']['getSupplier']['name'] }} </td>
                                     <td> {{ $item->appliances_defective_id ? $item['getDefectiveAppliances']['getBrand']['name'] : '--'}} </td>
                                     <td> {{ $item->appliances_defective_id ? $item['getDefectiveAppliances']['getProduct']['description'] : $item['getDefectiveFurniture']['getProduct']['description']}} </td>
                                     <td>{{$item->appliances_defective_id ? $item['getDefectiveAppliances']['getProduct']['product_model'] : $item['getDefectiveFurniture']['getProduct']['product_model']}}</td>   
                                     <td> {{ $item->appliances_defective_id ? $item['getDefectiveAppliances']['getSerial']['name'] : '--'}} </td>
                                     <td> {{ $item->appliances_defective_id ? $item['getDefectiveAppliances']['qty'] : $item['getDefectiveFurniture']['qty']}}</td>
                                     <td> {{ $item->appliances_defective_id ? $item['getDefectiveAppliances']['unit_cost'] : $item['getDefectiveFurniture']['unit_cost']}} </td>
                                     <td>{{$item->appliances_defective_id ? $item['getDefectiveAppliances']['qty']*$item['getDefectiveAppliances']['unit_cost'] : $item['getDefectiveFurniture']['qty']*$item['getDefectiveFurniture']['unit_cost']}}</td>
                                     <td> {{ $item->appliances_defective_id ? $item['getDefectiveAppliances']['dr_id'] : $item['getDefectiveFurniture']['dr_id'] }} </td>                                      
                                     <td> {{ $item->date_out}} </td>
                                   </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body -->
                </div> <!-- end card  -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- end page-content -->

@endsection