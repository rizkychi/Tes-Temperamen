<main>
	<div class="container">
		<div id="wizard_container">
            <div class="row justify-content-center mt-5 mb-5">
                <div class="col-6 text-center pt-5 pb-5">
                    <h1 class="display-3">Login first</h1>
					<?php 
						if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified') {
							header("Location: $url/?p=personality");
						} else {
							//Display login button
							echo '<a href="'.$url.'/?act=login"><img src="twitterlogin/images/twitter.png"/></a>';
						}
					?>
                </div>
            </div>
		</div>
		<!-- /Wizard container -->
	</div>
	<!-- /Container -->
</main>
<!-- /main -->