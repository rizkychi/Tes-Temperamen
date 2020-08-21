<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="STEPS | Multipurpose Working Wizard with Branches">
    <meta name="author" content="Ansonika">
    <title>STEPS | Multipurpose Working Wizard with Branches</title>

	<!-- Favicons-->
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

	<!-- GOOGLE WEB FONT -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">

	<!-- BASE CSS -->
	<link href="css/style.css" rel="stylesheet">

	<!-- YOUR CUSTOM CSS -->
	<link href="css/custom.css" rel="stylesheet">
    
	<script type="text/javascript">
    function delayedRedirect(){
        window.location = "index-3.html"
    }
    </script>

</head>
<body style="background:#f8f8f8 url(img/pattern.svg) repeat;" onLoad="setTimeout('delayedRedirect()', 5000)">
<?php
						$mail = $_POST['email'];

						$to = "test@domain.com";	/* YOUR EMAIL HERE */
						$subject = "Quotation from STEPS";
						$headers = "From: Quotation from STEPS <noreply@yourdomain.com>";
						$message = "DETAILS\n";
	
						$message .= "\nWhat Type of Project do you need:\n" ;
						foreach($_POST['answers_1'] as $value) 
							{ 
							$message .=   "- " .  trim(stripslashes($value)) . "\n"; 
							};
						$message .= "\nAre you a Company or Private User: " . $_POST['answer_group_1'] . "\n";
						$message .= "\n\nAnswers to the following questions" ;
						$message .= "\nIf you already have an hosting plan, please define: " . $_POST['select_1'];
						$message .= "\nIf you need an hosting plan, please define which one: " . $_POST['select_2'];
						$message .= "\nIf you need a newsletter campaign, please define the provider you prefer: " . $_POST['select_3'];
						$message .= "\n\nWhat is your Budget: " . $_POST['budget_slider']. "$". "\n";

						$message .= "\nPERSONAL DETAILS" ;
						$message .= "\nName and Lastname: " . $_POST['first_last_name'];
						$message .= "\nEmail: " . $_POST['email'];
						$message .= "\nTelephone " . $_POST['telephone'];
						$message .= "\nCountry: " . $_POST['country'];
						$message .= "\nTerms and conditions accepted: " . $_POST['terms'] . "\n";
												
						//Receive Variable
						$sentOk = mail($to,$subject,$message,$headers);
						
						//Confirmation page
						$user = "$mail";
						$usersubject = "Thank You";
						$userheaders = "From: info@steps.com\n";
						/*$usermessage = "Thank you for your time. Your quotation request is successfully submitted.\n"; WITH OUT SUMMARY*/
						//Confirmation page WITH  SUMMARY
						$usermessage = "Thank you for your time. Your quotation request is successfully submitted. We will reply shortly.\n\nBELOW A SUMMARY\n\n$message"; 
						mail($user,$usersubject,$usermessage,$userheaders);
	
?>
<!-- END SEND MAIL SCRIPT -->   
<div id="success">
	<div class="icon icon--order-success svg">
		<svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                <g fill="none" stroke="#8EC343" stroke-width="2">
                  <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                  <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                </g>
              </svg>
	</div>
	<h4><span>Request successfully sent!</span>Thank you for your time</h4>
	<small>You will be redirect back in 5 seconds.</small>
</div>
</body>
</html>