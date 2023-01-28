 <div class="vertical-menu" style="width: 250px">

     <div data-simplebar class="h-100">

         <!-- User details -->


         <!--- Sidemenu -->
         <div id="sidebar-menu">
             <!-- Left Menu Start -->
             <ul class="metismenu list-unstyled" id="side-menu">
                 <li class="menu-title">Menu</li>

                 <li>
                    
                     <a href="{{ url('/dashboard') }}" class="waves-effect">
                        <i class="fas fa-tachometer-alt"></i>
                         {{-- <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span> --}}
                         <span>Dashboard</span>
                     </a>
                 </li>
                 <li>
                    
                    <a href="{{ url('/orders') }}" class="waves-effect">
                       <i class="fas fa-tachometer-alt"></i>
                        {{-- <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span> --}}
                        <span>Manage Orders</span>
                    </a>
                </li>
                 
                 <hr>
                 <!-- ____________TO IMPLEMENT ___________________________-->
                 @if(Auth::user()->id == 1)
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-user-cog"></i>
                            <span>Manage Users</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href={{ route('users.all') }}>All Users</a></li>
                        </ul>
                    </li><!-- end Manage Users -->
                    <hr>
                @endif
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-tasks"></i>
                        <span>Manage Categories</span>
                    </a>                    
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href={{route('appliancesCategories.all')}}>Appliances</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href={{route('furnitureCategories.all')}} >Furnitures</a></li>
                    </ul>
                </li><!-- end Manage Categories -->

                
                
                
                <!-- ____________TO IMPLEMENT ___________________________-->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-tasks"></i>
                        <span>Manage Brands</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href={{ route('brands.all') }}>All Brands</a></li>
                    </ul>
                </li>
                <!-- end Manage Brands -->

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-tasks"></i>
                        <span>Manage Suppliers</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href={{ route('appLiancesSupplier.all') }}>Appliances Suppliers</a></li>
                     </ul>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a href={{ route('furnitureSuppliers.all') }}>Furniture Suppliers</a></li>
                    </ul>
                 </li>
                 <!-- end Manage Suppliers -->
                 

              

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" >
                        <i class="fas fa-tasks"></i>
                        <span>Manage Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href={{ route('appliancesProducts.all') }}>Appliances</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href={{ route('furnitureProducts.all') }}>Furnitures</a></li>
                    </ul>
                </li><!-- end Manage Products -->
                
                <hr>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-truck-loading"></i>
                        <span>Inbound Stocks</span>
                    </a>                       
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('appliancesDeliveries.all')}}">Appliances Deliveries</a></li>
                    </ul> 
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('furnitureDeliveries.all')}}">Furniture Deliveries</a></li>
                    </ul>                 
                </li><!-- end Inbound Stocks -->
                <!-- to implement -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-truck"></i>
                        <span>Outbound Stocks</span>
                    </a>                       
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('appliancesSales.all')}}">Appliances Sales</a></li>
                    </ul>  
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('furnitureSales.all')}}">Furniture Sales</a></li>
                    </ul>                
                </li><!-- end list -->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-truck"></i>
                        <span>Defective Stocks</span>
                    </a>                       
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('appliancesDefectives.all')}}">Appliances</a></li>
                    </ul> 
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('furnitureDefectives.all')}}">Furnitures</a></li>
                    </ul>
                                                        
                </li><!-- end list -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-truck"></i>
                        <span>Merchandise Returns</span>
                    </a>                       
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('merchandiseReturns.all')}}">All Returned Units</a></li>
                    </ul>                                     
                </li><!-- end list -->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-boxes"></i>
                        <span>Working Stocks</span>
                    </a>

                    
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href={{ route('appliancesWorkingStocks.all') }}>Appliances</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href={{ route('furnituresWorkingStocks.all') }}>Furnitures</a></li>
                    </ul>
                </li> 
                <hr>
                <!-- ____________TO IMPLEMENT ___________________________-->
                
                 

                <!-- PAGES -->
                 <!-- ********************************************************************** -->
                 {{-- <li class="menu-title">Pages</li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-account-circle-line"></i>
                         <span>Authentication</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="auth-login.html">Login</a></li>
                         <li><a href="auth-register.html">Register</a></li>
                         <li><a href="auth-recoverpw.html">Recover Password</a></li>
                         <li><a href="auth-lock-screen.html">Lock Screen</a></li>
                     </ul>
                 </li> --}}
                 <!-- ********************************************************************** -->                                 
             </ul>
         </div>
         <!-- Sidebar -->
     </div>
 </div>