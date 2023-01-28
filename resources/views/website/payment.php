<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Business Frontpage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="webtheme/assets/favicon.ico" />
        <!-- Bootstrap icons-->        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.2/sweetalert2.min.css"
        integrity="sha512-5aabpGaXyIfdaHgByM7ZCtgSoqg51OAt8XWR2FHr/wZpTCea7ByokXbMX2WSvosioKvCfAGDQLlGDzuU6Nm37Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />        
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="webtheme/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <div id="vue-container">
            <!-- Responsive navbar-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class="container px-5">
                    <a class="navbar-brand" href="#!">Start Bootstrap</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Welcome {{ user.name }}</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Header-->           
            <!-- Features section-->
        <section class="py-5 border-bottom" id="features">
            <div class="container px-5 my-5">
                <h3 class="text-center">Customer Details</h3>
                <form method="post" @submit.prevent="checkout" id="myForm">                            

                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Customer Name</label>
                        <div class="form-group col-sm-10">
                            <input v-model="request.customer_name"  class="form-control" type="text" required>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Customer Address</label>
                        <div class="form-group col-sm-10">
                            <input v-model="request.customer_address" class="form-control" type="text" required>
                        </div>
                    </div>
                    <!-- end row -->                            

                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Customer Email</label>
                        <div class="form-group col-sm-10">
                            <input v-model="request.customer_email" class="form-control" type="text" required >
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Contact Number</label>
                        <div class="form-group col-sm-10">
                            <input v-model="request.customer_contact" class="form-control" type="number" required>
                        </div>
                    </div>
                    <!-- end row -->                  

                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-info waves-effect waves-light" value="Order Now">
                    </div><!-- end row -->
                </form>
            </div>
            
        </section>
            <!-- Pricing section-->
           
            <!-- Footer-->
            <footer class="py-5 bg-dark fixed-bottom">
                <div class="container px-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
            </footer>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->        
        <script src="webtheme/js/api_url.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        

        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"
            integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>


        <script>
            new Vue({
                el: '#vue-container',
                //data contains variables...
                data: {
                    user: {},
                    cart: [],                  
                    request: {
                        customer_name: undefined,             
                        customer_address: undefined,
                        customer_email: undefined,
                        customer_contact: undefined,
                    },
                },
                
                // on mount
                mounted() {
                    
                    axios.get(api_url + 'customer')
                    .then((data) => {                        
                        this.user = data.data;
                        this.request.customer_name = this.user.name;                                                
                        this.request.customer_email = this.user.email;
                        this.request.customer_contact = this.user.mobile_no;
                    })
                                    
                },
            
                methods: {
                   checkout: function(){
                    axios.post(api_url + 'submit-cart-items',this.request)
                        .then((data) => {                        
                            Swal.fire({
                                title: "Success",
                                text: data.data.message,
                                icon: "success"
                            }).then(function() {
                                document.location = '/';
                            });

                        })
                   }
                }
            
            })
            </script>
    </body>
</html>
