@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="page-content">
    <div class="container-fluid">
        <h3>{{ $order->customer_name }}</h3>
        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
            <tr>                              
                <th>Products Model</th> 
                <th>Amount</th>                
                <th>Serial #</th>                
            </thead>


            <tbody>
                
                
            @foreach($order->orders as $item)
                <tr>                                       
                    <td> {{ $item->getProduct->product_model }} </td>                 
                    <td>{{ $item->amount }} </td> 
                    
                    <td>
                        @if(count($item->getProduct->getWorkingStock) > 0)                            
                            <form action="/orders/update_item" method="post">
                                @csrf <!-- {{ csrf_field() }} -->
                                <input type="hidden" name="id" value="{{ $item->id }}" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select name="working_stock_id" required class="form-select" id="item{{ $item->id }}">                            
                                            @foreach($item->getProduct->getWorkingStock as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->serial_id }}</option>                                
                                            @endforeach                            
                                        </select>
                                       
                                    </div>
                                    
                                    @if($item->status="new")
                                        <div class="col-sm-6">                                        
                                            <input type="submit" class="btn btn-success sm " value="Pack Item" />
                                        </div>
                                    @endif                                    
                                </div>
                            </form>     
                        @else
                            {{ $item->status }}
                        @endif
                       
                    </td>
                    
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

@endsection