
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/favicon.ico">
<link rel="icon" type="image/png" href="./assets/img/favicon.ico">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>PetBlog</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'/>
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700|Source+Sans+Pro:400,600,700" rel="stylesheet">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<!-- Main CSS -->
<link href="http://blog.test/assets/css/main.css" rel="stylesheet"/>
<link href="http://blog.test/assets/css/style.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Vue JS -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js'></script>
<!-- jQuery -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>


</head>
<body>
<!--------------------------------------
NAVBAR
--------------------------------------->
<nav class="topnav navbar navbar-expand-lg navbar-light bg-white fixed-top">
<div class="container">
	<a class="navbar-brand" href="/"><strong>PetBlog</strong></a>
	<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="navbar-collapse collapse" id="navbarColor02">
		<ul class="navbar-nav mr-auto d-flex align-items-center">
			<li class="nav-item">
			<a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="/category">Category</a>
			</li>

			<?php if((isLoggedIn() ) && (isLoggedIn()->role ==1  || isLoggedIn()->role ==2 )): ?>
				<li class="nav-item">
					<a class="nav-link" href="/admin">Admin</a>
				</li>
			<?php endif ?>
		</ul>
		<ul class="navbar-nav ml-auto d-flex align-items-center" style="gap: 8px">
			
			<?php if(!isLoggedIn()) :?>
			<li class="nav-item highlight">
			<a class="nav-link" href="/login">Log In</a>
			</li>
            <li class="nav-item highlight">
			<a class="nav-link" href="/register">Register</a>
			</li>
			<?php else: ?>
			
			<div class="d-flex justify-content-center align-center " style="gap:10px">
				<p style="margin-top: 5px">Hello <b> <?=isLoggedIn()->firstname ?></b> </p>

				<li class="nav-item highlight">
					<a class="nav-link" href="/logout">Logout</a>
				</li>
			</div>
			
			<?php endif; ?>


		</ul>
	</div>
</div>
</nav>
<!-- End Navbar -->

{{content}}


<!--------------------------------------
FOOTER
--------------------------------------->
<div class="container mt-5">
	<footer class="bg-white border-top p-3 text-muted small">
	<div class="row align-items-center justify-content-between">
		<div>
            <span class="navbar-brand mr-2"><strong>PetBlog</strong></span> Copyright &copy;
			<script>document.write(new Date().getFullYear())</script>
			 . All rights reserved.
		</div>
		<div>
			<!-- Made with <a target="_blank" class="text-secondary font-weight-bold" href="">Prova</a> -->
		</div>
	</div>
	</footer>
</div>
<!-- End Footer -->
    
<!--------------------------------------
JAVASCRIPTS
--------------------------------------->
<script src="http://blog.test/assets/js/vendor/jquery.min.js" type="text/javascript"></script>
<script src="http://blog.test/assets/js/vendor/popper.min.js" type="text/javascript"></script>
<script src="http://blog.test/assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
<script src="http://blog.test/assets/js/functions.js" type="text/javascript"></script>
<script src="http://blog.test/assets/js/script.js" type="text/javascript"></script>


</body>
</html>