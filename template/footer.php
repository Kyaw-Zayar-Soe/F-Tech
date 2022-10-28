 <!-- Footer Start -->
 <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-9 col-md-7 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-3 col-md-5">
                    
                    <!-- <div class="col-md-5 mb-5"> -->
                        <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    <!-- </div> -->
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                    by
                    <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="./assets/img/payments.png" alt="">
            </div>
        </div>
</div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


</body>
</html>
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://js.stripe.com/v2/"></script>

<script src="./assets/lib/easing/easing.min.js"></script>
<script src="./assets/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="./assets/mail/jqBootstrapValidation.min.js"></script>
<script src="./assets/mail/contact.js"></script>

<!-- Template Javascript -->
<script src="./assets/js/main.js"></script>
<script>
   
let currentPage = location.href;
    $(".menu-link").each(function () {
    let links = $(this).attr("href");
    console.log(links)
    if(currentPage ==  links){
        $(this).addClass('active');
    }
});
function password_show_hide() {
  var x = document.getElementById("password");
  var show_eye = document.getElementById("show_eye");
  var hide_eye = document.getElementById("hide_eye");
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}



function confirmDelete()
{
    return confirm("Sure you want to delete this data?");
}
// $(document).ready(function () {

    
// 	advFieldsStatus = $('#advFieldsStatus').val();

// 	$('#paypal_form').hide();
// 	$('#stripe_form').hide();
// 	$('#bank_form').hide();

//     $('#advFieldsStatus').on('change',function() {
//         advFieldsStatus = $('#advFieldsStatus').val();
//         if ( advFieldsStatus == '' ) {
//         	$('#paypal_form').hide();
// 			$('#stripe_form').hide();
// 			$('#bank_form').hide();
//         } else if ( advFieldsStatus == 'PayPal' ) {
//            	$('#paypal_form').show();
// 			$('#stripe_form').hide();
// 			$('#bank_form').hide();
//         } else if ( advFieldsStatus == 'Stripe' ) {
//            	$('#paypal_form').hide();
// 			$('#stripe_form').show();
// 			$('#bank_form').hide();
//         } else if ( advFieldsStatus == 'Bank Deposit' ) {
//         	$('#paypal_form').hide();
// 			$('#stripe_form').hide();
// 			$('#bank_form').show();
//         }
//     });
// });


// $(document).on('submit', '#stripe_form', function () {
//     // createToken returns immediately - the supplied callback submits the form if there are no errors
//     $('#submit-button').prop("disabled", true);
//     $("#msg-container").hide();
//     Stripe.card.createToken({
//         number: $('.card-number').val(),
//         cvc: $('.card-cvc').val(),
//         exp_month: $('.card-expiry-month').val(),
//         exp_year: $('.card-expiry-year').val()
//         // name: $('.card-holder-name').val()
//     }, stripeResponseHandler);
//     return false;
// });
// Stripe.setPublishableKey('<?php #echo $stripe_public_key; ?>');
// function stripeResponseHandler(status, response) {
//     if (response.error) {
//         $('#submit-button').prop("disabled", false);
//         $("#msg-container").html('<div style="color: red;border: 1px solid;margin: 10px 0px;padding: 5px;"><strong>Error:</strong> ' + response.error.message + '</div>');
//         $("#msg-container").show();
//     } else {
//         var form$ = $("#stripe_form");
//         var token = response['id'];
//         form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
//         form$.get(0).submit();
//     }
// }




</script>