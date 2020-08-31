<?php
    $db_winner_ga	= new Users();
    $result         = array();
    $result         = $db_winner_ga->getListWinnerGA();
    $winner         = ['helloalphacanis', 'bbbblubs', 'rlinaelzbth', 'Powerstrangers_']
?>

<main>
	<div class="container">
		<div id="wizard_container">
            <div class="row justify-content-center pt-5 pb-5">
                <div class="col-8 text-center pt-5 pb-5">
                    <h3 class="display-4">GIVEAWAY</h3>
                    <p>Pengumuman pemenang giveaway Testra 24 - 30 Agustus 2020</p>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-md-3">
                                            <img class="my-2" src="img/seo_icon_3.svg" alt="Winner">
                                        </div>
                                    </div>
                                    <p>Terima kasih kepada 388 partisipan yang telah mengikuti giveaway Testra ini dan SELAMAT kepada para pemenang.</p>
                                    <div class="row">
                                        <?php
                                            foreach ($winner as $val) {
                                                ?>
                                                    <div class="col-12 col-md-3 mb-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <?php echo $val; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <p>*NB: Kepada para pemenang mohon tunggu DM dari kami untuk pemberian hadiahnya.</p>
                                    
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/U8Iqu_s0z24?rel=0" allowfullscreen></iframe>
                                    </div>
                                    
                                    <div class="row my-3">
                                        <div class="col">
                                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                Daftar partisipan
                                            </button>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapseExample">
                                        <div class="row justify-content-center">
                                            <?php
                                                foreach($result as $key => $val) {
                                                    ?>
                                                        <div class="col-12 col-md-3 mb-2">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <?php echo $val[0]; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>

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