<main>
	<div class="container">
		<div id="wizard_container">
            <div class="row justify-content-center pt-5 pb-5">
                <div class="col-12 col-md-6 pt-5 pb-5">
					<div class="card pt-4">
						<div class="row px-3 px-md-5 py-3 justify-content-center">
							<div class="col-6 col-md-6 col-lg-4">
								<img class="card-img-top img-fluid" src="img/web_development_icon_4.svg" alt="Login">
							</div>
						</div>
						<div class="card-body text-center">
							<h5 class="card-title">Masuk</h5>
							<p class="card-text mb-3">Kamu harus masuk terlebih dahulu untuk menggunakan Testra</p>
							<div class="row justify-content-center px-4 pb-2">
								<div class="col-12 col-lg-8">
									<?php 
										if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified') {
											header("Location: $url/?p=personality");
										} else {
											echo '<a href="'.$url.'/?act=login" class="twitter btn-custom"><i class="icon-twitter"></i> Masuk dengan Twitter</a>';
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
		</div>
		<!-- /Wizard container -->
	</div>
	<!-- /Container -->
</main>
<!-- /main -->