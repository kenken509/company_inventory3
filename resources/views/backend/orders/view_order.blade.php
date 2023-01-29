@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3>Customer Orders </h3>
                <div class="card">
                    
                    <div class="card-body">                                        
                        <h5>Name: {{ $order->customer_name }}</h5>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>                              
                                    <th>Products Model</th> 
                                    <th>Amount</th>                
                                    <th>Serial #</th> 
                                    <th>Status</th> 
                                </tr>                  
                            </thead>
                            <tbody id="example">                                
                                @foreach($order->orders as $item)
                                    
                                    <tr>                                       
                                        <td> {{ $item->getProduct->product_model }} </td>                 
                                        <td>{{ $item->amount }} </td> 
                                        <form action="/orders/update_item" method="post">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <td>

                                                @if(count($item->getProduct->getWorkingStock) > 0)                                                                                                
                                                    <input type="hidden" name="id" value="{{ $item->id }}" />
                                                    <div class="row">
                                                        @if($item->status=="new")
                                                            <div class="col-sm-6">
                                                                <select name="working_stock_id" required class="form-select" id="item{{ $item->id }}">                            
                                                                    @foreach($item->getProduct->getWorkingStock as $stock)
                                                                        <option value="{{ $stock->id }}">{{ $stock->getSerial->name }}</option>                                
                                                                    @endforeach                            
                                                                </select>                                
                                                            </div> 
                                                        @endif                                                                                                           
                                                    </div>                     
                                                @endif                        
                                            </td>
                                            <td>
                                                @if($item->status=="new")
                                                    <div class="col-sm-6">                                        
                                                        <input type="submit" class="btn btn-success sm " value="Pack Item" />
                                                    </div>
                                                @else
                                                    {{ $item->status }}
                                                @endif  
                                            </td>
                                        </form>  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        @if($order->status != "done")
                            <form action="/orders/delivered" method="post">
                                @csrf <!-- {{ csrf_field() }} -->
                                <input type="hidden" name="id" value="{{ $order->id }}" />
                                    <div class="row">
                                        <div class="col-sm-6">                                        
                                            <input type="submit" class="btn btn-success sm " value="Set as Delivered" />
                                        </div>
                                    </div>
                                    
                            </form>
                    @endif
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>      
@endsection
