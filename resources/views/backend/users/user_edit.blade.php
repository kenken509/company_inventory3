@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Update User Page </h4>
            <hr>
            
            <form method="post" action="{{ route('user.update') }}" enctype="multipart/form-data" id="myForm">
                @csrf

                <input type="hidden" name="id" value="{{ $existingUser->id }}">
            <div class="row mb-3 ">
                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10 form-group">
                    <input name="name" class="form-control" type="text" value="{{$existingUser->name}}"  id="">
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">User Email</label>
                <div class="col-sm-10 form-group">
                    <input name="email" class="form-control" type="email" value="{{$existingUser->email}}"  id="">
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Contact Number</label>
                <div class="col-sm-10 form-group">
                    <input name="mobile_no" class="form-control" type="number" value="{{$existingUser->mobile_no}}"  id="">
                </div>
            </div>
            <!-- end row -->


            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">UserName</label>
                <div class="col-sm-10 form-group">
                    <input name="username" class="form-control" type="text" value="{{$existingUser->username}}"  id="">
                </div>
            </div>
            <!-- end row -->
                        
            <!-- end row -->

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Account Role</label>
                <div class="col-sm-10 form-group">
                    <select name="role" class="form-select" aria-label="Default select example">                        
                        <option  value="1" {{$existingUser->role == '1' ? 'selected':''}}>Admin</option>
                        <option  value="2" {{$existingUser->role == '2' ? 'selected':''}}>Inventory Clerk</option>
                        <option  value="3" {{$existingUser->role == '3' ? 'selected':''}}>Sales Clerk</option>                        
                    </select>
                </div>
            </div>
            <!-- end row -->



            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Profile Image </label>
                <div class="col-sm-10">
                    <input name="profile_image" class="form-control" type="file"  id="image" value="{{$existingUser->profile_image}}">
                </div>
            </div>
            <!-- end row -->

              <div class="row mb-3">
                 <label for="example-text-input" class="col-sm-2 col-form-label">  </label>
                <div class="col-sm-10">
                    <img id="showImage" class="rounded avatar-lg" src="{{ (!empty($existingUser->profile_image))? url('upload/admin_images/'.$existingUser->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap">
                </div>
            </div>
            <!-- end row -->
                <input type="submit" class="btn btn-info waves-effect waves-light" value="Update User">
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
                email: {
                    required : true,
                },
                mobile_no: {
                    required : true,
                },                
                username: {
                    required : true,
                },                           
                role: {
                    required : true,
                },
            },
            messages :{
                name: {
                    required : 'Please Enter Name',
                },
                email: {
                    required : 'Please Enter Email',
                },
                mobile_no: {
                    required : 'Please Enter Mobile Number',
                },                
                username: {
                    required : 'Please Enter Username',
                },                
                role: {
                    required : 'Please Select Role',
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
    
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>



@endsection 
