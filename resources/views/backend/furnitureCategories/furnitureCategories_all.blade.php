@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Furniture Categories</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{route('furnitureCategory.add')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Category </a> <br>  <br>               

                    <h4 class="card-title">Categories Data </h4>


                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th width="10%">Sl</th>
                            <th>Name</th>
                            <th>Products</th>                                                         
                            <th width="20%">Action</th>

                        </thead>


                        <tbody>

                        	@foreach($categories as $key => $category)
                        <tr>
                            <td> {{ $key+1}} </td>
                            
                            <td> {{ $category->name }} </td> 
                            <td><!-- to implement hasMany Product relation
                                {{-- @forelse($category->getProducts as $products)
                                    <ul>
                                        <li>{{$products['product_model']}}</li>
                                    </ul>
                                @empty
                                    <p>No products related</p>
                                @endforelse --}}
                                -->
                            </td>
                            
                            <td>
                                <a href="{{route('furnitureCategory.edit', $category->id)}}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>
                                
                                <a href="{{route('furnitureCategory.delete', $category->id)}}" class="btn btn-danger sm " title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>                        
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