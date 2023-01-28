@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Appliances Products</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{route('appliancesProducts.add')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Product</a> <br>  <br>               

                    <h4 class="card-title">Products Data </h4>


                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th>Model</th>   
                            <th>Description</th>   
                            {{-- <th>Serials</th>                         --}}
                            <th width="20%">Action</th>

                        </thead>


                        <tbody>

                        	@foreach($appliances as $key => $product)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $product->product_model}} </td>
                            <td>{{$product->description}}</td>
                            {{-- <td>
                                @foreach($product->getSerials as $serials)
                                    <ul>
                                        <li>{{$serials->name}}</li>    
                                    </ul>
                                @endforeach    
                            </td>                             --}}
                            {{-- <input type="hidden" name="category_id" value="{{$product->category_id}}">
                            <input type="hidden" name="supplier_id" value="{{$product->supplier_id}}">                             --}}
                            
                            <td>
                                 <a href="{{route('appliancesProduct.edit',$product->id)}} " class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

                                <a href="{{route('appliancesProduct.delete',$product->id)}}" class="btn btn-danger sm " title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

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


@endsection