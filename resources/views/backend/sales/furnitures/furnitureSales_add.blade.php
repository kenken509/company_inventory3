@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Sales </h4><br><br>
            
    <div class="row">
        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label">Date</label>
                 <input class="form-control example-date-input" name="date" type="date"  id="date">
            </div>
        </div><!-- end column -->

        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label">Reference No</label>
                <input class="form-control example-date-input" name="reference_no" type="text"  id="reference_no">
            </div>
        </div><!-- end column -->

        <div class="col-md-4">
            <div class="md-4">
                <label for="example-text-input" class="form-label">Payment Mode</label>
                <select name="payment_mode" id="payment_mode" class="form-select select2" aria-label="Default select example">
                    <option selected="" value="">Open this select menu</option>                    
                        <option value="0">Loan</option> 
                        <option value="1">Cash</option>                               
                </select>
            </div>
        </div><!-- end column -->  
          
                
    </div> <!-- end row -->

    <div class="row"> 
        <div class="col-md-4">
            <div class="md-4">
                <label for="supplier_id" class="form-label">Category Name </label>
                <select id="category_id" name="category_id" class="form-select select2 " aria-label="Default select example" disabled >
                        <option selected="" value="" id="no_val_category" >Open this select menu</option>
                    @foreach($categories as $category)                    
                        <option value="{{ $category->id }}" >{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- end column --> 

        <div class="col-md-4">
            <div class="md-4">
                <label for="supplier_id" class="form-label">Product Model</label>
                <select id="product_model_id" name="product_model_id" class="form-select select2 " aria-label="Default select example" disabled>
                        <option selected="" value="" id="no_val_product">Open this select menu</option>                        
                </select>
                {{-- <input type="hidden" name="unit_price" value="" id="unit_price">
                <input type="hidden" name="srp_gdp" value="" id="srp_gdp"> --}}
                
            </div>
        </div><!-- end column -->   
                                                       
    </div> <!-- end row -->  
    <div class="row">       
        <div class="col-md-4">
            <div class="md-4 ">
                <label for="example-text-input" class="form-label" style="margin-top:43px;">  </label> 
                        
                <i class="btn  btn-secondary btn-rounded waves-effect waves-light fas fa-plus-circle addeventmore" id="addeventmore" > Add </i>           
            </div>
        </div><!-- end column -->        
    </div><!-- end row -->    
           
</div> <!-- End card-body -->

<!--  ---------------------------------- -->

        <div class="card-body">
        <form method="post" action="{{route('furnitureSales.store')}}" id="myForm"> 
            @csrf
            <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;" id='myTable'>
                <thead>
                    <tr>
                        <th>Category</th>                                            
                        <th>Model</th>                        
                        <th>Qty.</th>                        
                        <th>SRP</th>
                        <th>Payment Mode</th>                       
                        <th>Remarks</th>                        
                        <th>Total Price</th>
                        <th>Action</th> 
                    </tr>
                </thead>

                <tbody id="addRow" class="addRow form-group">
                    
                </tbody>

                <tbody>
                    <tr>
                        <td colspan="6"></td>
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

 

<!-- HANDLE BARS -->
<script id="document-template" type="text/x-handlebars-template">     
    <tr class="delete_add_more_item" id="delete_add_more_item">
        <input type="hidden" name="date[]" value="@{{date}}">
        <input type="hidden" name="reference[]" value="@{{reference}}">        
        
    <td>
        <input type="hidden" name="category_id[]" value="@{{category_id}}" >
        @{{ category_text }}
    </td>
    
     <td>
        <input type="hidden" name="product_model_id[]" value="@{{product_model_id}}" id="productId">
        <input type="hidden" name="product_model[]" value="@{{product_model}}">
        @{{ product_model }}  <!--product_model-->
    </td>

     <td>
        <input type="text"  class="form-control buying_qty text-right" name="qty[]" value=""> 
    </td>
    
    <!-- <td id="append_text">
        <input type="text" class="form-control  form-group unit_price text-right" name="unit_cost[]" value="@{{unit_price}}" id="test" readonly>         
    </td>  -->

    <td>
        <input type="number" class="form-control srp text-right srp" name="srp[]" value="@{{srp_gdp}}"  > 
    </td>
    
    <td>
        <input type="hidden" name="payment_mode[]" value="@{{payment_mode}}" id="paymentMode">
        @{{product_mode_text}} 
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

<!-- validate form data -->
<script>
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                'qty[]': {
                    required : true,
                }, 
                'srp[]':{
                    required:true,
                }                
            },
            messages :{
                'qty[]': {
                    required : '',
                },
                'srp[]': {
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
        
</script><!-- end script -->

<!-- ADD ROW-->
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click",".addeventmore", function(){                   
            var date                = $('#date').val();  //checked          
            var reference           = $('#reference_no').val();  //checked                                                      
            var product_model       = $('#product_model_id').find('option:selected').text();//checked    
            var product_model_id    = $('#product_model_id').val();//checked                            
            var payment_mode        = $('#payment_mode').val(); //checked    
            var product_mode_text   = $('#payment_mode').find('option:selected').text(); //checked        
            var category_id         = $('#category_id').val();
            var category_text       = $('#category_id').find('option:selected').text();
            // var unit_price          = $('#unit_price').val();
            // var srp_gdp             = $('#srp_gdp').val();
                     
            if(date == ''){
                $.notify("Date is Required" ,  {globalPosition: 'top right', className:'error' }); //(message, {position, className:type})
                return false;
            }
            if(reference == ''){
                $.notify("Reference No. is Required" ,  {globalPosition: 'top right', className:'error' });
                return false;
            }   
            if(payment_mode == ''){
                $.notify("Payment Mode is Required" ,  {globalPosition: 'top right', className:'error' });
                return false;
            }
            if(category_id == ''){
                $.notify("Category Required" ,  {globalPosition: 'top right', className:'error' });
                return false;
            }                                                  
            if(product_model_id == ''){
                $.notify("Product Model is Required" ,  {globalPosition: 'top right', className:'error' });
                return false;
            }                            
            
            //check duplicate ************************
            var tdContent={};
            var data1 = [];
            $("#myForm tr td").each(function() {            
                var currentRow = $(this);    
                var appended_product=currentRow.find("#productId").val();
                var appended_paymentMode=currentRow.find("#paymentMode").val();                                       
                
                var obj={};
                if(appended_product){
                    obj.appended_product=appended_product;                    
                }
                if(appended_paymentMode){
                    obj.appended_paymentMode=appended_paymentMode;                    
                }
                if(!jQuery.isEmptyObject(obj)){
                    data1.push(obj);
                };                                       
                                        
            });
            
            console.log(data1);
            var num = data1.length;
            for(var i = 0; i < num; i++){                 
                if(data1[i].appended_product == product_model_id && data1[i+1].appended_paymentMode == payment_mode){
                    $.notify("You've already added a \""+product_mode_text+"\"  "+product_model ,  {globalPosition: 'top center', className:'error' });
                    return false;
                };  
                i++;               
            }
            //end check duplicate *****************
            
            


            var source = $("#document-template").html();
            var template = Handlebars.compile(source);
            var data = {
                date                :date, //key : value                   
                reference           :reference,                    
                product_model       :product_model,
                product_model_id    :product_model_id,                                                                                                        
                payment_mode        :payment_mode,
                product_mode_text   :product_mode_text,
                category_id         :category_id,
                category_text       :category_text,
                // unit_price          :unit_price,
                // srp_gdp             :srp_gdp
            };
            var html = template(data);
            $("#addRow").append(html); 

            
        });// end .addeventmore

        $(document).on("click",".removeeventmore",function(event){//(event,classname, callback function)
            $(this).closest(".delete_add_more_item").remove(); //$(thisDocument).closest(class).remove;
            totalAmountPrice();
            
        });

        

        //table change
        $('#myTable').on('change', 'input', function () {            
            var srp = $(this).closest('tr').find('input.srp').val();
            var qty = $(this).closest("tr").find("input.buying_qty").val();
            var total = srp * qty;
            $(this).closest("tr").find("input.buying_price").val(total);
            totalAmountPrice();            
        });


        // $(document).on('change','.unit_price,.buying_qty', function(){ //(event,classname, callback function)
        //     var unit_price = $(this).closest("tr").find("input.unit_price").val();
        //     var qty = $(this).closest("tr").find("input.buying_qty").val();
        //     var total = unit_price * qty;
        //     $(this).closest("tr").find("input.buying_price").val(total);
        //     totalAmountPrice();
        // });

        $(document).on('keyup click','.addeventmore', function(){                       
            $('#no_val_category').attr('selected','selected');
        })
        
      
        $(document).on('change','#payment_mode', function(){
            $('#category_id').removeAttr('disabled');
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

        
    });


</script> <!-- end script -->

<!-- get product -->
<script type="text/javascript">
    $(function(){
        $(document).on('change','#category_id',function(){
            var category_id = $('#category_id').val();
            $.ajax({
                url:"{{ route('get-working-furniture') }}",
                type: "GET",
                data:{
                    category_id:category_id,                    
                },
                success:function(data){  
                    var response =  JSON.stringify(data);
                    localStorage.setItem('data', response);                       
                     if(data==''){
                        var html = '<option value="">No related products</option>';                                                
                     }else{
                        var html = '<option value="">Select Product</option>';
                     }     
                      
                     $.each(data,function(key,v){                                   
                        html += '<option value=" '+v.id+' "> '+v.product_model+'</option>'; 
                        //html += '<input type="hidden" value="'+v.unit_cost+'">';                                                                                           
                     });
                    
                     $('#product_model_id').html(html);
                     $('#product_model_id').removeAttr('disabled');
                }
            })
        });
    });

</script>

<!-- get product price -->
{{-- <script type="text/javascript">
    $(function(){
        $(document).on('change','#product_model_id',function(){
            var product_model_id = $(this).val();                
            $.ajax({
                url:"{{ route('get-furniture-price') }}",
                type: "GET",
                data:{
                    product_model_id:product_model_id,                    
                },
                success:function(data){                     
                    console.log(data.unit_cost);
                    console.log(data.srp_gdp);
                                        
                    $('#unit_price').val(data.unit_cost);
                    $('#srp_gdp').val(data.srp_gdp);
                    $('#addeventmore').removeAttr('disabled');
                },                
            });
        });
    });

</script> --}}



 


 
@endsection 