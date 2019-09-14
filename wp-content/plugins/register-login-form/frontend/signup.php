<?php 
function custom_login(){
echo '<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">';
wp_enqueue_style( 'bootstrap-min',plugins_url( '/bootstrap/css/bootstrap.min.css', __FILE__ ) );
wp_enqueue_style( 'theme',plugins_url( '/bootstrap/css/bootstrap-theme.min.css', __FILE__ ) );
wp_enqueue_style( 'custom',plugins_url( '/bootstrap/css/custom.css', __FILE__ ) );
wp_enqueue_script( 'jquery-min-js',plugins_url( '/bootstrap/js/jquery.min.js', __FILE__ ));
wp_enqueue_script( 'bootstrap-min-js',plugins_url( '/bootstrap/js/bootstrap.min.js', __FILE__ ));
wp_enqueue_script( 'custom-js',plugins_url( '/bootstrap/js/custom.js', __FILE__ ));

echo '<div class="signup-form" id="sigin-up">
    <form action="/examples/actions/confirmation.php" method="post">
		<h2>Sign Up</h2>
        <div class="form-group">
			<div class="row">
				<div class="col-xs-6"><input type="text" class="form-control" name="first_name" placeholder="First Name" required="required"></div>
				<div class="col-xs-6"><input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required"></div>
			</div>        	
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
        </div>        
        <div class="form-group">
			<label class="checkbox-inline"><input type="checkbox" required="required"> <p class="text_color">I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></p></label>
		</div>
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">SIGN UP</button>
        </div>
    </form>
	<div class="text-center">Already have an account? <a href="log_in.html">Log In</a></div>
</div>';

/*echo '<div class="signup-form" id="login">
    <form action="/examples/actions/confirmation.php" method="post">
		<h2>Log In</h2>
		
        
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
		       
        
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">LOG IN</button>
        </div>
    </form>
	<div class="text-center">Don’t have an account? <a href="sign_up.html">Sign Up</a></div>
</div>';*/

}

add_shortcode('register', 'custom_login')

?>