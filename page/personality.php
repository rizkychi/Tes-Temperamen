<?php 
	//var init
	$twitter_id			= '';
	$twitter_username 	= '';
	$twitter_fullname	= '';
	$profile_image_url  = '';
	$tweet_count		= 0;
	$personality_type   = 0; //dummy
	$tested				= false; //dummy
	$tweet_text			= urlencode('Yuk ketahui tipe temperamenmu dalam 5 menit! ada giveaway juga lho. Jangan sampai ga ikutan. #Testra2020 #Giveaway http://testra.masrizky.com/');
	

	if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified') {
		//Retrive variables
		$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
		$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
		$oauth_provider		= 'twitter';
		$db_user_info		= new Users();
	
		//Retrieve user info
		$connection			= new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
		$user_info 			= $connection->get('account/verify_credentials');
		$twitter_id			= $user_info->id;
		$twitter_username 	= $user_info->screen_name;
		$twitter_fullname	= $user_info->name;
		$profile_image_url  = $user_info->profile_image_url;
		$tweet_count		= $user_info->statuses_count;
		$protected			= $user_info->protected;

		//Retrieve prediction type
		$predict_type = $db_user_info->getPredictType($oauth_provider, $twitter_id);
		if ($predict_type == '' || $predict_type == null) {
			$tested = false;
		} else {
			$tested = true;
			$personality_type = $db_user_info->getUserInfo($oauth_provider, $twitter_id, $predict_type);
		}

		if (!$tested && $act != 'test'){
		    header("Location: $url/?p=personality&act=test");
		} else if ($tested && $act == 'test'){
		    header("Location: $url/?p=personality");
		} else if ($tested && $act == 'retake'){
			$db_user_info->retakePredict($oauth_provider, $twitter_id);
			header("Location: $url/?p=personality&act=test");
		}

		//form submitted
		if ($_POST && $act =='test') {

			if (!(isset($_GET['type']) && $_GET['type'] == 'auto')) {

				//store answer in array
				$answer = array();
				for ($i=0; $i < 40; $i++) { 
					array_push($answer, $_POST['answer_'.$i]);
				}

				//convert array to string
				$s_answer = json_encode($answer);

				//get primary result
				$result = array_count_values($answer);
				$primary_result = array_keys($result, max($result))[0];

				//var_dump($primary_result);

				//get secondary result
				$temp = $result;
				unset($temp[$primary_result]);
				$secondary_result = array_keys($temp, max($temp))[0];

				// echo "<br>primary result: ".$primary_result;
				// echo "<br>secondary result: ".$secondary_result;

				//get timer count
				$timer_result = $_POST['timer'];
				//echo '<br> time : '.$timer_result;

				// save to db
				$db_user_info->updatePersonality($oauth_provider, $twitter_id, $s_answer, $result[0], $result[1], $result[2], $result[3], $primary_result, $secondary_result, $timer_result, $tweet_count, $protected);
				header("Location: $url/?p=personality");
			}
		}
	} else {
		//Display login page
		header("Location: $url/?p=login");
	}

	//PERSONALITY QUESTION
	//make number range 
	$number = range(0,3);
	$q_step = 2; //question per step (multiples of 2)

	//load file from json
	$loadFile = file_get_contents("personality_profile.json");
	if ($loadFile === false) {
		echo 'load failed';
		die();
	}

	//decode json
	$assessment = json_decode($loadFile, true);
	if ($assessment === null) {
		echo 'decode error';
		die();
	}

	//copy key value to new array
	$type = array();
	foreach ($assessment as $key => $value) {
		array_push($type, $key);
	}

	//get json array size
	$sum  = 0;
	$size = 0;
	foreach ($type as $val) {
		$sum += sizeof($assessment[$val]);
		$size = sizeof($assessment[$val]);
	}
	if ($sum != $size * sizeof($assessment)) {
		echo 'total value each type in json array not same';
		die();
	}

	//PERSONALITY RESULT
	if ($tested) {
		//load file from json
		$loadFile = file_get_contents("personality_traits.json");
		if ($loadFile === false) {
			echo 'load failed';
			die();
		}

		//decode json
		$personality_traits = json_decode($loadFile, true);
		if ($personality_traits === null) {
			echo 'decode error';
			die();
		}

		//store into variabel
		$personality_name		= $personality_traits[$personality_type]['name'];
		$personality_alias		= $personality_traits[$personality_type]['alias'];
		$personality_character	= $personality_traits[$personality_type]['character'];
		$personality_desc		= $personality_traits[$personality_type]['desc'];
		$personality_strength	= $personality_traits[$personality_type]['strength'];
		$personality_weakness	= $personality_traits[$personality_type]['weakness'];
	}
	
?>
<main>
	<div class="container">
		<div id="wizard_container">
			<form name="example-1" id="wrapped" method="POST">
			<input id="website" name="website" type="text" value="">
			<input name="timer" type="hidden" id="timer" value="0">
				<!-- Leave for security protection, read docs for details -->
				<div id="middle-wizard">
					<div class="row">
						<div class="col">
							<div class="card">
								<div class="card-body row align-items-center justify-content-between">
									<div class="col-6 col-lg-2 my-2 my-lg-0">
										<div class="text-center">
											<img src="<?php echo $profile_image_url ?>" class="rounded-circle img-fluid avatar-custom"  alt="<?php echo $twitter_fullname ?>">
										</div>
									</div>
									<div class="col-6 col-lg-4 my-2 my-lg-0">
										<div class="float-left">
											<?php echo $twitter_fullname.' (@'.$twitter_username.')' ?>
										</div>
									</div>
									<div class="col-12 col-lg-4 my-2 my-lg-0 px-5 px-lg-0" id="progressInfo">
										<!-- <span class="progress-percent">Soal <span class="progress-count">0</span>/<span class="progress-count-max"></span></span> -->
										<div class="progress ">
											<div class="progress-bar progress-bar-striped progress-bar-animated" id="test-progress" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<div class="col-12 col-lg-2 my-2 my-lg-0">
										<div class="text-center">
											<a href="/?act=logout" class="btn btn-sm btn-danger text-white">Keluar</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<?php if (!$tested) { ?>
						<!-- Selection method step -->
						<div class="" id="select_method">
							<div class="question_title">
								<h3>Mau jenis tes yang mana?</h3>
								<p>Pilih salah satu aja ya</p>
							</div>
							<div class="row justify-content-center mb-5">
								<div class="col-lg-4">
									<div class="item">
										<input id="select_assessment" type="radio" name="selection_method" value="assessment">
										<label for="select_assessment"><img src="img/web_development_icon_1.svg" alt=""><strong>Assessment</strong>Tes kepribadian berupa kuesioner singkat berisi 40 soal.</label>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="item">
										<input id="select_automatic" type="radio" name="selection_method" value="automatic">
										<label for="select_automatic"><img src="img/web_development_icon_2.svg" alt=""><strong>Automatic</strong>Kepribadianmu akan dicari secara otomatis oleh sistem.</label>
									</div>
								</div>
							</div>
							<!-- /row-->
						</div>
						<!-- /Selection method step -->

						<!-- Instruction step -->
						<div class="step instruct" id="instruct_assessment">
							<div id="instruction"></div>
							<div class="question_title">
								<h3>Instruksi</h3>
								<p></p>
							</div>
							<div class="row justify-content-center">
								<div class="col-lg-8">
									<div class="box_general">
										<h6>Bacalah petunjuk berikut sebelum memulai tes</h6>
										<ol>
											<li>Dalam masing-masing deret empat kata ke samping berikut ini, pilih salah satu kata yang paling sering cocok dengan dirimu.</li>
											<li>Setiap kata memakai bahasa Inggris dan definisi dibawahnya memakai bahasa Indonesia</li>
											<li>Pastikan kamu memilih di setiap baris soal.</li>
											<li>Terdapat 40 baris soal (20 soal merupakan kekuatanmu dan 20 sisanya merupakan kelemahanmu) dengan masing-masing empat kata jawaban.</li>
											<li>Tidak ada jawaban benar atau salah, jadi jujurlah pada saat memilih.</li>
											<li>Jika kamu tidak yakin kata mana yang paling cocok, tanyakan pada teman atau keluargamu, dan pikirkan apa jawabanmu ketika dirimu masih anak-anak.</li>
										</ol>
									</div>
								</div>
							</div>
						</div>
						<!-- /Instruction step -->

						<!-- Question step -->
						<?php 
							//show option
							for ($i=0; $i < $size; $i+=$q_step) {
							?>
								<div class="step <?php echo ($i == $size-$q_step) ? 'submit':''?>">
									<div class="question-number"><?php echo ($i+$q_step); ?></div>
									<div class="question_title">
										<h3>Manakah yang merupakan <?php echo ($i < $size/2) ? 'kekuatanmu': 'kelemahanmu' ?>?</h3>
										<p>Pilih salah satu pada tiap baris yang paling cocok dengan dirimu</p>
									</div>
										<?php
											for ($k=0; $k < $q_step; $k++) { 
												echo '<div class="row justify-content-center">'; //row
												shuffle($number); //shuffle number
												for ($j=0; $j < 4; $j++) {
													//get assessment value from array
													$profile = $assessment [ $type [ $number [$j] ] ] [$i+$k][0];
													$desc    = $assessment [ $type [ $number [$j] ] ] [$i+$k][1];
													?>
														<div class="col-lg-3">
															<div class="item">
																<input id="<?php echo 'question_'.($i+$k).'_opt_'.$j ?>" name="<?php echo 'answer_'.($i+$k); ?>" type="radio" value="<?php echo $number [$j] ?>" class="required">
																<label for="<?php echo 'question_'.($i+$k).'_opt_'.$j ?>"><strong><?php echo $profile ?></strong><?php echo $desc ?></label>
															</div>
														</div>
													<?php
												}
												echo '</div>';
												echo '<hr class="style-two">';
											}
										?>
									<!-- /row-->
								</div>
							<?php
						} ?>
						<!-- /Question step -->
					<?php } ?>

					<!-- Personality Result -->
					<?php 
						if ($tested) {
							?>
								<div class="row mt-4" id="personalityResult">
									<div class="col">
										<div class="card p-5">
											<div class="row justify-content-center">
												<div class="col-12 col-lg-8 text-center">
													<h4><?php echo $twitter_fullname ?> adalah <?php echo $personality_alias ?></h4>
													<img class="my-3" src="img/personality/<?php echo $personality_type?>.png" class="rounded-circle" alt="<?php echo $personality_name ?>">
													<h4><?php echo $personality_name ?></h4>
													<h5 class="text-primary mt-4"><?php echo $personality_character ?></h5>
													<p><?php echo $personality_desc ?></p>
													
													<div class="row">
														<div class="col-12 col-lg-6">
															<h5 class="text-success">Kekuatan</h5>
															<ul>
																<?php
																	foreach ($personality_strength as $val) {
																		echo '<li>'.$val.'</li>';
																	}
																?>
															</li>
														</div>
														<div class="col-12 col-lg-6">
															<h5 class="text-danger">Kelemahan</h5>
															<ul>
																<?php
																	foreach ($personality_weakness as $val) {
																		echo '<li>'.$val.'</li>';
																	}
																?>
															</li>
														</div>
													</div>

													<h6 class="mt-5">Kamu tidak yakin dengan temperamenmu? tenang saja kamu bisa mengulanginya.</h6>
													<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#retake">
														Ulangi tes
													</button>
													<div class="row justify-content-center px-2">
														<div class="col-12 col-lg-8"><h6 class="mt-5">Penasaran dengan tipe temperamen temanmu?</h6>
														<a href="" class="twitter btn-custom" onclick="popUp=window.open('https://twitter.com/share?url=<?php echo $tweet_text;?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false"><i class="icon-twitter"></i> Tag temanmu untuk ikutan tes!</a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php
						}
					?>
					<!-- /Personality Result -->
				</div>
				<!-- /middle-wizard -->
				<?php
					if (!$tested) {
						?>
							<div id="bottom-wizard">
								<button type="button" name="back" class="back">Kembali</button>
								<button type="button" name="backward" class="backward">Sebelumnya</button>
								<button type="button" name="forward" class="forward">Selanjutnya</button>
								<button type="submit" name="process" class="submit">Submit</button>
							</div>
						<?php
					}
				?>
				<!-- /bottom-wizard -->
			</form>
		</div>
		<!-- /Wizard container -->
	</div>
	<!-- /Container -->
</main>
<!-- /main -->

<!-- Modal : Confirmation-->
<div class="modal fade" id="confirm_method" tabindex="-1" role="dialog" aria-labelledby="confirm_methodTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Ketahui temperamenmu dengan satu kali klik!</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Setelah klik tombol "Mulai" di bawah, sistem akan memulai proses untuk mencari tahu temperamen dan kepribadianmu.
			</div>
			<div class="modal-footer justify-content-center">
				<div class="col-4">
					<button type="button" class="btn btn-primary btn-block" id="btnStartAutomatic">Mulai</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal : Retake test-->
<!-- Modal -->
<div class="modal fade" id="retake" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Ulangi tes</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			Apakah kamu yakin ingin mengulang tes?
		</div>
		<div class="modal-footer">
			<a href="?act=retake"><button type="button" class="btn btn-primary">Ulangi</button></a>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
		</div>
		</div>
  </div>
</div>