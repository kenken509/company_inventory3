@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Furniture Deliveries  </h4><br><br>
            
    <div class="row">
        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label">Date</label>
                 <input class="form-control example-date-input" name="date_in" type="date"  id="date_in">
            </div>
        </div><!-- end column -->

        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label">Reference No</label>
                <input class="form-control example-date-input" name="reference_name" type="text"  id="reference_name">
            </div>
        </div><!-- end column -->


        <div class="col-md-4">
            <div class="md-4">
                <label for="supplier_id" class="form-label">Supplier Name </label>
                <select id="supplier_id" name="supplier_id" class="form-select select2 " aria-label="Default select example" >
                    <option selected="" value="" >Open this select menu</option>
                    @foreach($suppliers as $supp)
                        <option value="{{ $supp->id }}" >{{ $supp->name }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- end column -->        
    </div> <!-- end row -->

    <div class="row">    
        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label">Category Name </label>
                <select name="category_id" id="category_id" class="form-select select2" aria-label="Default select example" disabled>
                    <option selected="" value="">Open this select menu</option>               
                </select>
            </div>
        </div> <!-- end column -->           
        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label">Product Model</label>
                <select name="product_model" id="product_model" class="form-select select2" aria-label="Default select example" disabled>
                    <option selected="" value="">Open this select menu</option> 
                                       
                </select>
            </div>
        </div> <!-- end column -->

        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label">Status</label>
                <select name="status" id="status" class="form-select select2" aria-label="Default select example" disabled>
                        <option selected="" value="">Open this select menu</option>                    
                        <option value="0">Pristine</option> 
                        <option value="1">Defective</option>                               
                </select>
            </div>
        </div><!-- end column -->
        
                             
    </div> <!-- end row -->    

    <div class="row">  
        
        
        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label" style="margin-top:43px;">  </label>        
                <i class="btn btn-secondary btn-rounded waves-effect waves-light fas fa-plus-circle addeventmore"> Add </i>
            </div>
        </div><!-- end column -->
    </div> <!-- end row --> 

           
</div> <!-- End card-body -->
<!--  ---------------------------------- -->

        <div class="card-body">
        <form method="post" action="{{route('furnitureDeliveries.store')}}" id="myForm"> 
            @csrf
            <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;" id="myTable">
                <thead>
                    <tr>
                        <th>Category</th>                                            
                        <th>Model</th>                        
                        <th>Qty.</th>
                        <th>Unit Price </th> 
                        <th>SRP</th>
                        <th>Status</th>                       
                        <th>Remarks</th>                        
                        <th>Total Price</th>
                        <th>Action</th> 
                    </tr>
                </thead>

                <tbody id="addRow" class="addRow form-group">
                    
                </tbody>

                <tbody>
                    <tr>
                        <td colspan="8"></td>
                            <td>
                                <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control estimated_amount" readonly style="background-color: #ddd;" >
                            </td>
                        <td>

                        </td>
                    </tr>

                </tbody>                
            </table><br>
            <div class="form-group">
                <button type="submit" class="btn btn-info" id="storeButton" >Save</button>                
            </div>
            
        </form>

        </div> <!-- End card-body -->


 




    </div>
</div> <!-- end col -->
</div>
 


</div>
</div>

 


<script id="document-template" type="text/x-handlebars-template">
     
<tr class="delete_add_more_item" id="delete_add_more_item">
        <input type="hidden" name="date_in[]" value="@{{date_in}}">
        <input type="hidden" name="reference_name[]" value="@{{reference_name}}">
        <input type="hidden" name="supplier_id[]" value="@{{supplier_id}}">         
        
    <td>
        <input type="hidden" name="category_id[]" value="@{{category_id}}" >
        @{{ category_name }}
    </td>

     <td>
        <input type="hidden" name="product_model_id[]" value="@{{product_model_id}}" id="product_id">        
        @{{ product_model_name }}  
    </td>
    
     <td>
        <input type="number" class="form-control buying_qty text-right" name="qty[]" value=""> 
    </td>
    
    <td id="append_text">
        <input type="number" class="form-control  form-group unit_price text-right" name="unit_cost[]" value="" id="test" >         
    </td>

    <td>
        <input type="number" class="form-control srp text-right" name="srp[]" value=""  > 
    </td>
    
    <td>
        <input type="hidden" name="status[]" value="@{{status}}" id="appended_status" >
        @{{statusText}} 
    </td>
    
    <td>
        <input type="text" class="form-control" name="remarks[]"> 
    </td>
    
     <td>
        <input type="number" class="form-control buying_price text-right" name="buying_price[]" value="0" readonly> 
    </td>

     <td>
        <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
    </td>

    </tr>

</script> <!-- end script -->

<script>
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                "unit_cost[]": {
                    required : true,
                },
                "qty[]":{
                    required : true,
                },
                "srp[]":{
                    required : true,
                },           
            },
            messages :{
                "unit_cost[]": {
                    required : '',
                },
                "qty[]":{
                    required : '',
                },
                "srp[]":{
                    required : '',
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


<script type="text/javascript">
    $(document).ready(function(){ //jquery should be written on ready function
        $(document).on("click",".addeventmore", function(){ //(onclic,addClass, function())
            var date_in = $('#date_in').val();            
            var reference_name = $('#reference_name').val();
            var supplier_id = $('#supplier_id').val();            
            var category_id  = $('#category_id').val();            
            var category_name = $('#category_id').find('option:selected').text();            
            var product_model_name = $('#product_model').find('option:selected').text();
            var product_model_id = $('#product_model').val();                       
            var status = $('#status').val();   
            var statusText = $('#status').find('option:selected').text();

                       
            if(date_in == ''){
                    $.notify("Date is Required" ,  {globalPosition: 'top center', className:'error' }); //(message, {position, className:type})
                    return false;
                 }
            if(reference_name == ''){
                $.notify("Reference No. is Required" ,  {globalPosition: 'top center', className:'error' });
                return false;
            }

            if(supplier_id == ''){
                $.notify("Supplier is Required" ,  {globalPosition: 'top center', className:'error' });
                return false;
            }
            if(category_id == ''){
                $.notify("Category is Required" ,  {globalPosition: 'top center', className:'error' });
                return false;
            }
                 
            if(product_model_id == ''){
                $.notify("Product Model is Required" ,  {globalPosition: 'top center', className:'error' });
                return false;
            }
            if(status == ''){
                $.notify("Product Status is Required" ,  {globalPosition: 'top center', className:'error' });
                return false;
            }                   
            //*****************************
            var data1 = [];
           // var tdContent={};
            //var appendedStatus=[];
            
            var tdContent={};
            $("#myForm tr td").each(function() {
                var currentRow = $(this);    
                var appended_product=currentRow.find("#product_id").val();
                var appended_status=currentRow.find("#appended_status").val();                                       
                
                var obj={};
                if(appended_product){
                    obj.appended_product=appended_product;                    
                }
                if(appended_status){
                    obj.appended_status=appended_status;                    
                }
                if(!jQuery.isEmptyObject(obj)){
                   data1.push(obj);
                };                                       
                                        
            });
            var num = data1.length;
            for(var i = 0; i < num; i++){ 
                if(data1[i].appended_product == product_model_id && data1[i+1].appended_status == status){
                    $.notify("You've already added a \""+statusText+"\"  "+product_model_name ,  {globalPosition: 'top center', className:'error' });
                    return false;
                };  
                i++;               
            }

                                      
            
            

            //*****************************

            var source = $("#document-template").html();
            var template = Handlebars.compile(source);
            var data = {
                date_in:date_in, //key : value                   
                reference_name:reference_name,
                supplier_id:supplier_id, //key : value
                category_id:category_id, //key : value
                category_name:category_name, //key : value    
                product_model_name:product_model_name,
                product_model_id:product_model_id,                                                                                 
                status:status,
                statusText:statusText,
            };
            var html = template(data);
            $("#addRow").append(html); 
            
        });// <<<<<<<<<<<< end .addEventMore

        $(document).on("click",".removeeventmore",function(event){//(event,classname, callback function)
            $(this).closest(".delete_add_more_item").remove(); //$(thisDocument).closest(class).remove;
            totalAmountPrice();
        });

        $(document).on('keyup click','.unit_price,.buying_qty', function(){ //(event,classname, callback function)
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var qty = $(this).closest("tr").find("input.buying_qty").val();
            var total = unit_price * qty;
            $(this).closest("tr").find("input.buying_price").val(total);
            totalAmountPrice();
        });

        $(document).on('change','#product_model',function(){
            $('#status').removeAttr('disabled');
        });
        // Calculate sum of amout in invoice 

        function totalAmountPrice(){
            var sum = 0;
            $(".buying_price").each(function(){
                var value = $(this).val();
                if(!isNaN(value) && value.length != 0){
                    sum += parseFloat(value);
                }
            });
            $('#estimated_amount').val(sum);
        }  

        
        
        // $(document).on("keyup click",".addeventmore", function(){
        //     var data = [];
            
        //     $("#myForm td #test1").each(function() {
        //         var tdContent = $(this).val();
        //         data.push(tdContent);                                
        //     });    
        //     //3
        //     for(var i = 0; i < data.length; i++){
                
        //         for(var j = i+1; j <data.length; j++){
        //             if(data[i] == data[j]){
        //                 $.notify("duplicate value" ,  {globalPosition: 'top right', className:'error' });
        //                 return false;
        //             }else{
        //                 console.log('no dup');
        //             }
        //         }
        //     }
        //     if (duplicates){
        //         alert("There were duplicates.");
        //     }
        // });
        

    });


</script> <!-- end script -->




<!-- category -->
<script type="text/javascript">
    $(function(){                                       // declare a function
        $(document).on('change','#supplier_id',function(){
            var supplier_id = $(this).val();            //get the value of the selected id
            
            $.ajax({
                url:"{{ route('get-furniture-categories') }}",      //this function will send a request to this route route('get-category')
                type: "GET",                            // type is a method GET or POST
                data:{supplier_id:supplier_id},         //<<-{key: value from $(this).val();}
                success:function(data){                 //function(your data as parameter) // success means if this ajax function successfully get a response then success function will be executed                                                            
                    var html = '<option value="">Select Category</option>';
                    $.each(data,function(key,value){ 
                        // console.log(value.category_id);
                         html += '<option value=" '+value.category_id+' "> '+value.get_categories.name+'</option>'; //v.category.name == v.eloquentRelation.field                        
                    });
                    $('#category_id').html(html);
                    $('#category_id').removeAttr('disabled');
                }
            })
        });
    });

</script>


<!-- product_model -->
<script type="text/javascript">
    $(function(){
        $(document).on('change','#category_id',function(){
            var category_id = $(this).val(); 
            var supplier_id = $('#supplier_id').val();           
            $.ajax({
                url:"{{ route('get-furniture-products') }}",
                type: "GET",
                data:{
                    category_id:category_id,
                    supplier_id:supplier_id
                },
                success:function(data){
                    var html = '<option value="">Select Product Model</option>';
                    $.each(data,function(key,v){
                        
                         html += '<option value=" '+v.id+' "> '+v.product_model+'</option>';                                              
                    });
                    
                    $('#product_model').html(html);
                    $('#product_model').removeAttr('disabled');
                }
            })
        });
    });

</script>

<!-- Brand -->
<script type="text/javascript">
    $(function(){
        $(document).on('change','#product_model',function(){
            var product_model = $('#product_model').val();
            $.ajax({
                url:"{{ route('get-brands') }}",
                type: "GET",
                data:{
                    product_model:product_model,                    
                },
                success:function(data){
                    
                    var html = '<option value="">Select Brand</option>';
                    $.each(data,function(key,v){
                        //console.log(v);
                        html += '<option value=" '+v.brand_id+' "> '+v.get_brand.name+'</option>';                                              
                    });
                    
                     $('#brand_id').html(html);
                     $('#brand_id').removeAttr('disabled');
                }
            })
        });
    });

</script>



 


 
@endsection 