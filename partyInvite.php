<?
## simple script to grab form values and test email template

function mail_factory($name, $email, $template) {
	#get email template and add form values
	$email_message = file_get_contents($template);
	$email_message = str_replace("#NAME#", $name, $email_message);
	
	
	#construct header
	$to = $email;
	$from = "vmanamino@gmail.com";
	$subject = "Party time!";
	
	$headers = "From: ".$from. "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	
	#send mail
	mail($to, $subject, $email_message, $headers);
	
	$confirmation = "An invitation was sent to ".$name." ".$email.".";
	
	return $confirmation;

}

## extract superglobals into variables
extract($_GET, EXTR_PREFIX_SAME, "get");

## loop through each form variable using nesting
for ($i = 1; $i < 11; $i++) {
	$name = "name".$i;
	$email = "email".$i;
	## if not empty then send to email factory
	if ($$name && $$email) {
		if (!filter_var($$email, FILTER_VALIDATE_EMAIL) === false) { ## check for valid email
			$confirmation = mail_factory($$name, $$email, $_SERVER['DOCUMENT_ROOT']."/php1_hmwk/lesson12/emailInvite.txt");
			echo $confirmation."<br/><br/>";
		} else { ## invalid email message
			echo $$email." is not valid.  Please enter the correct email for .".$$name.".<br/><br/>";
		}
		
	} else if (!($$name) && $$email) { ## empty name with entered email
		echo "You didn't enter a name for ".$$email."<br/><br/>";
	} else if ($$name && !($$email)) { ## empty email entered with name
		echo "You didn't enter an email for ".$$name."<br/><br/>";
	}
	
	


}

?>