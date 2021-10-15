<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts/dashPages.head')
</head>
<body>
    <div class="container">
        <div class="header mt-5 px-5 text-center bg-primary py-5 text-white">
            <h1>Pay for services</h1>
            
        </div>
        <div class="main">
            <form id="makePaymentForm">
                @csrf
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter the amount" id="amount">
                    </div>
                    <div class="col-6">
                        <label for="number">MT4/MT5 Account Number</label>
                        <input type="number" class="form-control" name="number" placeholder="Enter MT4/MT5 account number" id="number">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Pay Now</button> <!-- onClick="makePayment()" -->
                </div>
            </form>
        </div>
    </div>

    


      
      <script>
          
          $(function () {
              $("#makePaymentForm").submit(function (e){
                  e.preventDefault();
                  //console.log("Well");
                  var name = $("#name").val();
                  var email = $("#email").val();
                  var amount = $("#amount").val();
                  var accountnumber = $("#number").val();

                  //make payment
                  makePayment(amount,email,accountnumber,name);
              });
          });

        function makePayment(amount,email,phone_number,name) {
          FlutterwaveCheckout({
            public_key: "FLWPUBK_TEST-12f4a3cd7c403e30b4e10b9153ad75fd-X",//FLWPUBK-1d1226e0998b9786d64b87e1972964d9-X    is  for live environment
            tx_ref: "RX1_{{substr(rand(0,time()),0,7)}}",// for test FLWPUBK_TEST-12f4a3cd7c403e30b4e10b9153ad75fd-X
            amount,
            currency: "NGN",
            country: "NG",
            payment_options: " ",
            redirect_url: // specified redirect URL
            "https://archfxglobe.com",
            customer: {
              email,
              phone_number,
              name,
            },
            callback: function (data) {
              var transaction_id = data.transaction_id;
              //console.log(data);
              //make ajax request
              var _token = $("input[name='_token']").val();
              $.ajax({
                  type: "POST",
                  url: "{{URL::to('verify-payment')}}",
                  data: {
                    transaction_id,
                    _token,
                  },
                  success: function (response){
                    //console.log(Object.entries(response));
                  }
              });
            },
            onclose: function() {
              // close modal
            },
            customizations: {
              title: "My store",
              description: "Payment for items in cart",
              logo: "https://s3-us-west-2.amazonaws.com/hp-cdn-01/uploads/orgs/flutterwave_logo.jpg?69",
            },
          });
        }
      </script>      
</body>
</html>