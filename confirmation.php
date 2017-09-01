<!DOCTYPE html>
<?php
	$price = $_POST['price'];
	$name = $_POST['name'];
	$shipping_cost = 10;
?>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/86/three.js" type="text/javascript"></script>
	<script src="https://js.stripe.com/v3/"></script>
	<link rel="stylesheet" href="assets/styles.css" type="text/css">
	<link rel="stylesheet" href="assets/checkout-styles.css" type="text/css">
	<title></title>
    <script type="text/javascript">
        function calcTotal(){
            var unitPrice = <?= $_POST['price']; ?>;
            var q = document.getElementById('quantity-input').value;
            var shippingCost = <?= $shipping_cost; ?>;

            document.getElementById('cost-sub').innerHTML = unitPrice * q;
            document.getElementById('cost-shipping').innerHTML = shippingCost;
            document.getElementById('cost-total').innerHTML = unitPrice * q + shippingCost;
        }
    </script
</head>
<body>
<div class="container">
<div class="row">
	<div class="col-md-3"><img src="assets/v3d.png" class="img-responsive img-branding" /></div>
	<div class="col-md-9"></div>
</div>
<hr>
</div>
<div class="container wrapper main">
<div class="row form-group">
    <div class="col-xs-12">
        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
            <li class="disabled"><a href="#step-1">
                <h4 class="list-group-item-heading">Step 1</h4>
                <p class="list-group-item-text">Upload a 3D File</p>
            </a></li>
            <li><a href="view.php?file=<?php echo $name; ?>">
                <h4 class="list-group-item-heading">Step 2</h4>
                <p class="list-group-item-text">Select Print Options</p>
            </a></li>
            <li class="active"><a href="#step-3">
                <h4 class="list-group-item-heading">Step 3</h4>
                <p class="list-group-item-text">Enter Your Details</p>
            </a></li>
        </ul>
    </div>
</div>
  
<div class="row cart-body">
    <form class="form-horizontal" method="post" action="">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <!--SHIPPING METHOD-->
        <div class="panel panel-default">
            <div class="panel-heading"><i class="glyphicon glyphicon-home"></i><h3>Address</h3></div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-12"><label class="lbl-form"><strong>Country:</strong></label></div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="country" value="" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-10 col-xs-12">
                        <label class="lbl-form"><strong>Full Name:</strong></label>
                        <input type="text" name="full_name" class="form-control" value="" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12"><label class="lbl-form"><strong>Address:</strong></label></div>
                    <div class="col-md-10">
                        <input type="text" name="address" class="form-control" value="" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12"><label class="lbl-form"><strong>City:</strong></label></div>
                    <div class="col-md-10">
                        <input type="text" name="city" class="form-control" value="" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12"><label class="lbl-form"><strong>County/State:</strong></label></div>
                    <div class="col-md-10">
                        <input type="text" name="state" class="form-control" value="" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12"><label class="lbl-form"><strong>Zip / Postal Code:</strong></label></div>
                    <div class="col-md-10">
                        <input type="text" name="zip_code" class="form-control" value="" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12"><label class="lbl-form"><strong>Phone Number:</strong></label></div>
                    <div class="col-md-10"><input type="text" name="phone_number" class="form-control" value="" required/></div>
                </div>
                <div class="form-group">
                    <div class="col-md-12"><label class="lbl-form"><strong>Email Address:</strong></label></div>
                    <div class="col-md-10"><input type="text" name="email_address" class="form-control" value="" required/></div>
                </div>
            </div>
        </div>
        <!--SHIPPING METHOD END-->
        <!--CREDIT CART PAYMENT-->
        <div class="panel panel-default">
            <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span><h3>Secure Payment</h3></div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-12 card-details">
                        <span><strong>Card Details: </strong></span>
                    </div>
                    <div class="col-md-12">
	                    <div class="group">
					    <label class="lbl-card">
					      <div id="card-element" class="field"></div>
					    </label>
						</div>
                    </div>
                	<div class="col-md-12">
                    	<button type="submit" class="btn btn-primary btn-submit-fix">Place Order</button>
                	</div>
                	<div class="outcome">
				    <div class="error" role="alert"></div>
				    <div class="success">
				      Success! Your Stripe token is <span class="token"></span>
				    </div>
				   </div>
                </div>
            </div>
        </div>
        <!--CREDIT CART PAYMENT END-->
    </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <!--REVIEW ORDER-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Review Order</h3><div class="pull-right"><small><a class="afix-1" href="#">Edit Cart</a></small></div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-3 col-xs-3">
                        <img class="img-responsive" src="assets/cube.png" />
                    </div>
                    <div class="col-sm-7 col-xs-7">
                        <div class="col-xs-12 file-name"><?php echo $name; ?></div>
                        <div class="col-xs-12"><small>Volume : <span><?php echo $_POST['volume']; ?> <?php echo $_POST['unit']; ?><sup>3</sup></span></small></div>
                        <br />
                        <div class="col-xs-12"><small>Quantity : <span><input id="quantity-input" name="quantity" value="1" onChange="calcTotal();"></span></small></div>
                        <div class="col-xs-12"><small>Material : <span><?php echo $_POST['material-option']; ?></span></small></div>
                        <div class="col-xs-12"><small>Colour : <span><?php echo $_POST['colour-option']; ?></span></small></div>
                        <div class="col-xs-12"><small>Polishing : <span><?php echo (isset($_POST['checkbox-polished']) ? 'yes' : 'no'); ?></span></small></div>
                        <div class="col-xs-12"><small>Unit : <span><?php echo $_POST['unit']; ?></span></small></div>
                    </div>
                    <div class="col-sm-2 col-xs-2 text-right">
                        <h6><span>£</span><?php echo $price; ?></h6>
                    </div>
                </div>
           
                <div class="form-group"><hr /></div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <strong>Subtotal</strong>
                        <div class="pull-right"><span>£</span><span id="cost-sub"></span></div>
                    </div>
                    <div class="col-xs-12">
                        <small>Shipping</small>
                        <div class="pull-right"><span>£</span><span id="cost-shipping"></span></div>
                    </div>
                </div>
                <div class="form-group"><hr /></div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <strong>Order Total</strong>
                        <div class="pull-right"><span>£</span><span id="cost-total"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <!--REVIEW ORDER END-->
    </div>
    </form>
</div>
</div>
<div class="container">
<hr id="footer-sep">
<ul id="footer-links">
    <li><a href="">PrintWorks</a></li>
    <li><a href="">Contact PrintWorks</a></li>
</ul>
</div>
<script type="text/javascript">
$( document ).ready( function(){
var stripe = Stripe('pk_test_6pRNASCoBOKtIshFeQd4XMUh');
var elements = stripe.elements();

var card = elements.create('card', {
  style: {
    base: {
      iconColor: '#666EE8',
      color: '#31325F',
      lineHeight: '40px',
      fontWeight: 300,
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSize: '15px',

      '::placeholder': {
        color: '#CFD7E0',
      },
    },
  }
});
card.mount('#card-element');

function setOutcome(result) {
  var successElement = document.querySelector('.success');
  var errorElement = document.querySelector('.error');
  successElement.classList.remove('visible');
  errorElement.classList.remove('visible');

  if (result.token) {
    // Use the token to create a charge or a customer
    // https://stripe.com/docs/charges
    successElement.querySelector('.token').textContent = result.token.id;
    successElement.classList.add('visible');
  } else if (result.error) {
    errorElement.textContent = result.error.message;
    errorElement.classList.add('visible');
  }
}

card.on('change', function(event) {
  setOutcome(event);
});

document.querySelector('form').addEventListener('submit', function(e) {
  e.preventDefault();
  var form = document.querySelector('form');
  var extraDetails = {
    name: form.querySelector('input[name=full_name]').value,
  };
  stripe.createToken(card, extraDetails).then(setOutcome);
});
});

$(document).ready( function(){
    calcTotal();
});
</script>
</body>
</html>