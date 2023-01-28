@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">All Users</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

    <a href="{{route('user.add')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add User </a> <br>  <br>               

                    <h4 class="card-title">Users All Data </h4>


                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th style="width: 4%">Sl</th>
                            <th>Name</th> 
                            <th style="width: 5%">Photos</th>
                            <th>Mobile Number </th>
                            <th>Email</th>
                            <th>Role</th> 
                            <th>Action</th>

                        </thead>


                        <tbody>

                        	@foreach($users as $key => $user)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $user->name }} </td> 
                            <td><img id="showImage" class="rounded avatar-lg" src="{{ (!empty($user->profile_image))? url('upload/admin_images/'.$user->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap" style="width:50px; height:50px;"></td>
                            <td> {{ "+63".$user->mobile_no}} </td> 
                            <td> {{ $user->email }} </td> 
                            <td> {{ $user->role == 2 ? 'Inventory Clerk' : ($user->role == 3 ? 'Sales Clerk' : 'Admin') }} </td> 
                            <td>
                                <a href="{{ route('user.edit',$user->id)}} " class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

                                <a href="{{route('user.delete',$user->id)}} " class="btn btn-danger sm " title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

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