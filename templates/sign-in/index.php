<link rel="stylesheet" href="templates/sign-in/style.css" type="text/css">

<body>
	<div class="container h-100">

		<?php
		if(isset($_SESSION["login_error"])){
			?>
			<div class="alert alert-danger" role="alert">
				<small>
					<strong>User Authentication Failed: </strong>Please type a valid username and password.
				</small>
				<a type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="float: right"><i class='bx bx-x nav_icon'></i></a>
			</div>
			<?php
			unset($_SESSION["login_error"]);
		}
		?>
		
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="img/Snap-Repair.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form method="POST" action="server/user_auth/user-auth.php">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="username" class="form-control input_user" value="" placeholder="username" required>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass" value="" placeholder="password" required>
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="rememberme" class="custom-control-input" id="customControlInline">
								<label class="custom-control-label" for="customControlInline">Remember me</label>
							</div>
						</div>
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="login" class="btn login_btn">Login</button>
				   </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						<a href="#" class="text-danger">Forgot your password?</a>
					</div>
                    <div class="d-flex justify-content-center links">
                        <small>
						    Powered By <a href="https://devmarkportfolio.cf" class="ml-2 text-light">_devmark IT Solutions</a>
                        </small>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>