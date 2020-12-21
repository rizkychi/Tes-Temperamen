<?php
	session_start();
	ob_start();
	require_once 'config.php';
	include_once 'twitterlogin/config.php';
	include_once 'twitterlogin/inc/twitteroauth.php';
	include_once 'twitterlogin/includes/functions.php';

	// ------------- Switch Page ------------- //
	if (isset($_GET["p"])){
		$page = $_GET["p"];
	} else {
		$page = 'home';
	}

	// check if page file doesn't exist
	if (!file_exists('page/'.$page.'.php')){
		$page = '404';        
	}

	// action
	if (isset($_GET['act'])) {
		$act = $_GET['act'];

		if ($act == 'logout') {
			unset($_SESSION['userdata']);
			session_destroy();
			header("Location: $url/?p=home");
		} else if ($act == 'login') {
			header("Location: $url/twitterlogin/process.php");
		} else if ($act == 'test') {
			$page = 'personality';
		}
	} else {
		$act = '';
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106646524-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-106646524-3');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Dengan Testra kamu dapat mengetahui tipe temperamenmu dalam 5 menit.">
	<meta name="author" content="Rizkychi">
	
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:description" content="Dengan Testra kamu dapat mengetahui tipe temperamenmu dalam 5 menit." />
	<meta name="twitter:title" content="Tes Temperamenmu Sekarang!" />
	<meta name="twitter:site" content="@rizkychi_" />
	<meta name="twitter:image" content="http://testra.masrizky.com/img/people.jpg" />
	<meta name="twitter:creator" content="@rizkychi_" />

	<meta property="og:url" content="http://testra.masrizky.com" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Tes Temperamenmu Sekarang!" />
	<meta property="og:description" content="Dengan Testra kamu dapat mengetahui tipe temperamenmu dalam 5 menit." />
	<meta property="og:image" content="http://testra.masrizky.com/img/people.jpg" />

		<title>Testra</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/fav.png" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	<link href="css/menu.css" rel="stylesheet">
	<link href="css/vendors.min.css" rel="stylesheet">
	<link href="css/icon_fonts/css/all_icons.min.css" rel="stylesheet">
	<link href="css/skins/square/grey.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">
	
	<script src="js/modernizr.js"></script>
	<!-- Modernizr -->

</head>

<body>
	
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div><!-- /Preload -->
	
	<div id="loader_form">
		<div data-loader="circle-side-2"></div>
	</div><!-- /loader_form -->

	<div id="processLoading">
		<!-- <div class="processContainer">
			<h1 class="display-4">Tunggu sebentar ya</h1>
			<div class="text-center">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div> -->
		<div class="container d-flex h-100">
			<div class="row justify-content-center align-self-center w-100">
				<div class="col text-center">
					<h1 class="display-4">Tunggu sebentar ya</h1>
						<!-- <div class="spinner-border text-primary my-5" style="width: 3rem; height: 3rem;" role="status">
							<span class="sr-only">Loading...</span>
						</div> -->
						<img src="img/ame-roll.gif" alt="">
					<h5 id="process_status">Mengunduh tweet pengguna...</h5>
				</div>
			</div>
		</div>
	</div><!-- /process_loading -->
	
	<!-- Header -->
	<header class="header-custom">
		<div class="container">
		    <div class="row">
                <div class="col-12">
					<nav class="navbar navbar-expand-lg justify-content-between">
						<a class="navbar-brand">
							<img src="img/personality/testra_logo.png" style="height:40px" alt="Testra">
						</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
							<span class="text-secondary h3 icon-menu icon-menu-custom"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
							<ul class="navbar-nav mr-auto mt-2 mt-lg-0 text-center">
							<li class="nav-item <?php echo ($page == 'home') ? 'active-custom': ''?>">
								<a class="nav-link" href="?p=home">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item <?php echo ($page == 'personality') ? 'active-custom': ''?>">
								<a class="nav-link" href="?p=personality">Mulai tes</a>
							</li>
							<li class="nav-item <?php echo ($page == 'about') ? 'active-custom': ''?>">
								<a class="nav-link" href="?p=about">Tentang</a>
							</li>
							</ul>
						</div>
					</nav>
                </div>
            </div>
		</div>
	</header>
	<!-- /Header -->

	<!-- Content -->
	<?php
		//put page file
		include 'page/'.$page.'.php';
	?>
	<!-- /Content -->
	
	<footer>
		<div class="container clearfix">
			<p>Tes Temperamen © 2020</p>
		</div>
	</footer>
	<!-- /footer -->
	
	<!-- Modal terms -->
	<?php include 'modal.php';?>
	<!-- /Modal terms -->
	
	<!-- COMMON SCRIPTS -->
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/common_scripts.min.js"></script>
	<script src="js/menu.js"></script>
	<script src="js/main.js"></script>
	<script src="js/wizard_func_without_branch.js"></script>	
	
	<script>
		var time = 0;
		function timer() {
			time++;
			$("#timer").val(time);
		}

		function showProgress(val) {
			if (val == 0) {
				$("#progressInfo").css('visibility', 'hidden');
				$("#progressInfo").addClass('shrink-height');
				$(".forward").text('Mulai');
			} else {
				$("#progressInfo").css('visibility', 'visible');
				$("#progressInfo").removeClass('shrink-height');
				$(".forward").text('Selanjutnya');
			}
		}

		function switch_method(val) {
			if (val == true) {
				$("#select_method").show();
				$("#instruct_assessment").hide();
				$("#bottom-wizard").hide();
			} else {
				$("#select_method").hide();
				$("#instruct_assessment").show();
				$("#bottom-wizard").show();
			}
		}
		
		$(document).ready(function(){
			var progress   = 0;
			var count	   = 0;
			var max		   = 40; //total question
			var step	   = 100 / max; 

			count	 = $(".current").children('.question-number').text(); //get question number
			if (count == null || count == "") {
				count = 0;
			}
			progress = count * step;
			showProgress(count);

			$(".progress-count").text(count);
			$(".progress-count-max").text(max);
			$("#test-progress").attr('aria-valuenow', progress).css('width', progress+'%');
			$("#test-progress").text(progress + '%');

			$(".forward, .backward").click(function(){
				count = $(".current").children('.question-number').text();

				if (count > max) {
					count = max;
				} else if (count == null || count == "") {
					count = 0;
				}
				showProgress(count);

				progress = count * step;
				if (progress > 100) {
					progress = 100;
				} else if (progress < 0) {
					progress = 0;
				}

				$("#test-progress").attr('aria-valuenow', progress).css('width', progress+'%');
				$("#test-progress").text(progress + '%');
				$(".progress-count").text(count);
			});

			//timer
			var myTimer;
			var isStart = false;
			clearInterval(myTimer);	

			$(".forward").click(function(){
				if (!isStart) {
					isStart = true;
					myTimer = setInterval(timer ,1000);	
				}
			});

			<?php 
				if ($act == 'test'){
					echo   '$("#bottom-wizard").show();
							$("#personalityResult").hide();';
				} else {
					echo   '$(".step").hide();
							$("#bottom-wizard").hide();
							$("#personalityResult").show();';
				}
			?>

			// selection method
			switch_method(true);
			
			$('#select_method input:radio[name="selection_method"]').change(function() {
				if ($(this).val() == 'assessment') {
					switch_method(false);
				} else if ($(this).val() == 'automatic') {
					$('#confirm_method').modal('show');
				} else {
					alert('error');
				}
				$(this).prop('checked', false);
			});

			// process : automatic method
			$("#btnStartAutomatic").click(function() {
				$('#processLoading').fadeIn('slow'); 
			})

			<?php
				//show modal dialog
				if ($page == 'home') {
					echo '$("#modal-txt").modal();';
				}
			?>
		});
	</script>
	
</body>
</html>
<?php
	ob_end_flush();
?>