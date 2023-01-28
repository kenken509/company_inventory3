@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Furnitures Add Product Page </h4><br><br>

                        <form method="post" action="{{ route('furnitureProduct.store') }}" id="myForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Product Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" id="supplierName">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Supplier Name</label>
                                <div class="col-sm-10 form-group">
                                    <select name="supplier_id" class="form-select" aria-label="Default select example">
                                        <option selected="" value="">select supplier</option>
                                        @foreach($suppliers as $key => $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @endforeach
                                        </select>
                                </div>
                            </div>
                            <!-- end row -->                            

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10 form-group">
                                    <select name="category_id" class="form-select" aria-label="Default select example">
                                        <option selected="" value="">select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                        </select>
                                </div>
                            </div>
                            <!-- end row -->

                            <!-- end row -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10 form-group">
                                    <input type="text" name="description" class="form-control">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="form-group">
                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Product">
                            </div><!-- end row -->
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>



    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                }, 
                supplier_id: {
                    required : true,
                },
                unit_id: {
                    required : true,
                },
                category_id: {
                    required : true,
                },
            },
            messages :{
                name: {
                    required : 'Please Enter Product Name',
                },
                supplier_id: {
                    required : 'Please Select Supplier',
                },
                unit_id: {
                    required : 'Please Select Unit',
                },
                category_id: {
                    required : 'Please Select Category',
                },
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>




@endsection