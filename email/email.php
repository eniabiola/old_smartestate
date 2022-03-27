<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 0');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$host = 'localhost';
$dbname = 'dataljb7_smart';
$user = 'dataljb7_smart';
$password = 'andy247742';
$db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8mb4', $user, $password);
include("signup.php");
include("signupnotice.php");
?>
<?php
class Postmark {
	private $api_key;
	private $attachment_count = 0;
	private $data = array();
	function __construct($key, $from, $reply = '')
	{
		$this->api_key = $key;
		$this->data['From'] = $from;
		$this->data['ReplyTo'] = $reply;
	}
	function send()
	{
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: '.$this->api_key
		);
		
		$ch = curl_init('http://api.postmarkapp.com/email');
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
		$return = curl_exec($ch);
		$curl_error = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		curl_close($ch);
		
		// do some checking to make sure it sent
		if($http_code !== 200)
			return false;
		else
			return true;
	}
	function to($to)
	{
		$this->data['To'] = $to;
		return $this;
	}
	
	function cc($cc)
	{
		$this->data["Cc"] = $cc;
		return $this;
	}
	
	function bcc($bcc)
	{
		$this->data["Bcc"] = $bcc;
		return $this;
	}
		
	function subject($subject)
	{
		$this->data['Subject'] = $subject;
		return $this;
	}
	function html_message($html)
	{
		$this->data['HtmlBody'] = $html;
		return $this;
	}
	function plain_message($msg)
	{
		$this->data['TextBody'] = $msg;
		return $this;
	}
	function tag($tag)
	{
		$this->data['Tag'] = $tag;
		return $this;
	}
	
	function attachment($name, $content, $content_type)
	{
		$this->data['Attachments'][$this->attachment_count]['Name']		= $name;
		$this->data['Attachments'][$this->attachment_count]['ContentType']	= $content_type;
		
		// Check if our content is already base64 encoded or not
		if( ! base64_decode($content, true))
			$this->data['Attachments'][$this->attachment_count]['Content']	= base64_encode($content);
		else
			$this->data['Attachments'][$this->attachment_count]['Content']	= $content;
		
		// Up our attachment counter
		$this->attachment_count++;
		
		return $this;
	}
}
?>
<?php 
if(isset($_GET['new']))
{
	$portalurl = "app.yellowduplex.com/express";
	$id = $_GET['new'];
	$opt = $_GET['opt'];
	if($opt === "signup"){
		$postmark = new Postmark("e2f3bbec-9c13-45f3-88f2-260e44f3956c","support@yellowduplex.com","support@yellowduplex.com");
		$qry = "SELECT * FROM `subscribers` WHERE idsession = '$id'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$subscriber = $row_edt['businessname'];
		$firstname = $row_edt['firstname'];
		$othername = $row_edt['othername'];
		$username = $row_edt['email'];
		$phone = $row_edt['phone'];
		$password = "00000";
		$sitetitle = "SmartEstate Manager Signup";
		$message = "You have been successfully signed up on SmartEstate Manager.";
		$html_message = email_signup($sitetitle,$sitetitle,$message,$portalurl,$username,$password);
		$result = $postmark->to($username)->subject($sitetitle)->html_message($html_message)->send();
		return $result;
	} else if($opt === "residentsignup"){
		$postmark = new Postmark("e2f3bbec-9c13-45f3-88f2-260e44f3956c","support@yellowduplex.com","support@yellowduplex.com");
		$qry = "SELECT * FROM `residents` WHERE idsession = '$id'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$residentname = $row_edt['surname']." ".$row_edt['othername'];
		$email = $row_edt['email'];
		$tenantid = $row_edt['tenant'];

		$qry = "SELECT * FROM `subscribers` WHERE id = '$tenantid'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$estatename = $row_edt['businessname'];
		$agencyemail = $row_edt['email'];
		$agencyphone = $row_edt['phone'];

		$sitetitle = "$estatename Resident Portal Signup";
		$message = "Dear $residentname,<br><br>";
		$message .= "Your signup on $estatename portal was successful. You will receive notification as soon as your details have been verified by the estate admin.<br><br>";
		$message .= "Thank You.";
		$html_message = residentsignup($sitetitle,$estatename,$message);
		$result = $postmark->to($email)->subject($sitetitle)->html_message($html_message)->send();
		return $result;
	} else if($opt === "residentconfirm"){
		$postmark = new Postmark("e2f3bbec-9c13-45f3-88f2-260e44f3956c","support@yellowduplex.com","support@yellowduplex.com");
		$qry = "SELECT * FROM `residents` WHERE id = '$id'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$residentname = $row_edt['surname']." ".$row_edt['othername'];
		$email = $row_edt['email'];
		$tenantid = $row_edt['tenant'];
		$password = $row_edt['password'];

		$qry = "SELECT * FROM `subscribers` WHERE id = '$tenantid'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$estatename = $row_edt['businessname'];

		$sitetitle = "$estatename Residence Portal Signup";
		$message = "You have been successfully signed up on $estatename Residence Portal.";
		$url = "app.yellowduplex.com/express";
		$html_message = email_signup($estatename,$sitetitle,$message,$portalurl,$email,$password);
		$result = $postmark->to($username)->subject($sitetitle)->html_message($html_message)->send();
		return $result;
	} else if($opt === "requestfeedback"){
		include("message.php");
		$qry = "SELECT * FROM `complaints_feedback` WHERE idsession = '$id'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$tenantid = $row_edt['tenant'];
		$residentid = $row_edt['residentid'];
		$requestid = $row_edt['requestid'];
		$feedbacknote = $row_edt['feedbacknote'];

		$qry = "SELECT * FROM `complaints` WHERE id = '$requestid'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$requestsubject = $row_edt['requestsubject'];

		$qry = "SELECT * FROM `residents` WHERE id = '$residentid'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$residentname = $row_edt['surname']." ".$row_edt['othername'];
		$email = $row_edt['email'];
		$tenantid = $row_edt['tenant'];

		$qry = "SELECT * FROM `subscribers` WHERE id = '$tenantid'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$estatename = $row_edt['businessname'];
		$agencyemail = $row_edt['email'];
		$to = $email;
		$title = "Re: $requestsubject";
		$msg = "Dear $residentname<br><br>$feedbacknote";
		$msgorg = $estatename;
		send_email_all($to,$title,$msg,$msgorg);
	} else if($opt === "closeticket"){
		include("message.php");
		$qry = "SELECT * FROM `complaints` WHERE id = '$id'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$requestsubject = $row_edt['requestsubject'];
		$residentid = $row_edt['residentid'];

		$qry = "SELECT * FROM `residents` WHERE id = '$residentid'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$residentname = $row_edt['surname']." ".$row_edt['othername'];
		$email = $row_edt['email'];
		$tenantid = $row_edt['tenant'];

		$qry = "SELECT * FROM `subscribers` WHERE id = '$tenantid'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$estatename = $row_edt['businessname'];
		$agencyemail = $row_edt['email'];
		$to = $email;
		$title = "Re: $requestsubject";
		$msg = "Dear $residentname<br><br>This ticket has been closed!";
		$msgorg = $estatename;
		send_email_all($to,$title,$msg,$msgorg);
	} else if($opt === "paybill"){
	   
	    $qry = "SELECT invoices.*,billings.billname AS billname,billings.amount AS amount 
	    FROM invoices,billings WHERE invoices.invoiceno = billings.id AND invoices.surname = '$id' 
	    AND invoices.invoicestatus = 'Not Paid'";
		$stmt = $db->query($qry);
		while($row_edt = $stmt->fetch(PDO::FETCH_ASSOC)){
		    $iddd = uniqid('', true);
		    $transid = $iddd;
            $walletid = $row_edt['surname'];
            $surname = $row_edt['billname'];
            $debit = $row_edt['amount'];
            $transref = $row_edt['id'];
            $transtatus = 'Transaction Successful';
            $tenant = $row_edt['tenant'];
            $user = $row_edt['user'];
            $qry33 = "SELECT sum(credit) - sum(debit)  balance FROM wallets WHERE walletid = '$id' AND transtatus = 'Successful'";
		    $stmt33 = $db->query($qry33);
		    $row_edt33 = $stmt33->fetch(PDO::FETCH_ASSOC);
		    $walletbal = $row_edt33['balance'];
		    if(($walletbal > $debit) || ($walletbal == $debit)){
    		    $tenantuser = "INSERT INTO wallets (`date`,transid,walletid,surname,debit,transref,`transtatus`,tenant,user) 
                VALUES (CURDATE(),'$transid','$walletid','$surname','$debit','$transref','$transtatus','$tenant','$user')";
                $db->query($tenantuser);
                $tenantuser = "UPDATE invoices SET invoicestatus = 'Paid' WHERE id = '$transref'";
                $db->query($tenantuser); 
		    }
		}
	} else if($opt === "resetpassword"){
		include("message.php");
		$qry = "SELECT * FROM `residents` WHERE email = '$id'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$email = $row_edt['email'];
		$tenantid = $row_edt['tenant'];
		$residentname = $row_edt['surname']." ".$row_edt['othername'];
		if($email === $id){
		    $qry2 = "SELECT * FROM `subscribers` WHERE id = '$tenantid'";
    		$stmt2 = $db->query($qry2);
    		$row_edt2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    		$estatename = $row_edt2['businessname'];
    		//
		    $newpasswprd = mt_rand(10000,99999);
		    $qry = "UPDATE `residents` SET password = '$newpasswprd' WHERE email = '$id'";
		    $stmt = $db->query($qry);
		    $feedbacknote = "Your password has been reset.<br><br>Login with <strong>$newpasswprd</strong>.
		    <br><br>You are adviced to change your password after you login.
		    <br><br>Thank You.";
		    $to = $email;
    		$title = "Password Reset";
    		$msg = "Dear $residentname<br><br>$feedbacknote";
    		$msgorg = $estatename;
    		send_email_all($to,$title,$msg,$msgorg);
    		$result = array("Response"=>"Successful");
            echo json_encode($result);
		}else{
		    $qry = "SELECT * FROM `usermanagements` WHERE email = '$id'";
    		$stmt = $db->query($qry);
    		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
    		$email = $row_edt['email'];
    		$tenantid = $row_edt['tenant'];
    		if($email === $id){
    		    $qry2 = "SELECT * FROM `subscribers` WHERE id = '$tenantid'";
        		$stmt2 = $db->query($qry2);
        		$row_edt2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        		$estatename = $row_edt2['businessname'];
        		//
        		$residentname = $row_edt['userfullname'];
        		$newpasswprd = mt_rand(10000,99999);
    		    $qry = "UPDATE `usermanagements` SET password = '$newpasswprd' WHERE email = '$id'";
    		    $stmt = $db->query($qry);
    		    $feedbacknote = "Your password has been reset.<br><br>Login with <strong>$newpasswprd</strong>.
    		    <br><br>You are adviced to change your password after you login.
    		    <br><br>Thank You.";
    		    $to = $email;
        		$title = "Password Reset";
        		$msg = "Dear $residentname<br><br>$feedbacknote";
        		$msgorg = $estatename;
        		send_email_all($to,$title,$msg,$msgorg);
        		$result = array("Response"=>"Successful");
                echo json_encode($result);
    		}else{
    		    $result = array("Response"=>"Failed");
                echo json_encode($result);
    		}
		}
	} else if($opt === "notification"){
		include("message.php");
		$qry = "SELECT * FROM `messagetemplates` WHERE id = '$id'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$tenantid = $row_edt['tenant'];
		$templatetitle = $row_edt['templatetitle'];
		$messagecontent = $row_edt['messagecontent'];

		$qry = "SELECT * FROM `subscribers` WHERE id = '$tenantid'";
		$stmt = $db->query($qry);
		$row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
		$estatename = $row_edt['businessname'];

		$qry = "SELECT * FROM `message_recipeient` WHERE messageid = '$id'";
		$stmt = $db->query($qry);
		while($row_edt = $stmt->fetch(PDO::FETCH_ASSOC)){
		    $residentname = $row_edt['fullname'];
    		$sn = $row_edt['id'];
    		$to = $row_edt['email'];
    		$title = $templatetitle;
    		$title = "$estatename Notification";
    		$msg = "Dear $residentname<br><br><strong>$templatetitle</strong><br>$messagecontent";
    		$msgorg = $estatename;
    		$gwresponse = send_email_all($to,$title,$msg,$msgorg);
    		$qry = "UPDATE `message_recipeient` SET sentstatus = '2' WHERE id = '$sn'";
		    $stmt2 = $db->query($qry);
		}
		$qry = "UPDATE `messagetemplates` SET sentstatus = '2' WHERE id = '$id'";
		$stmt = $db->query($qry);
		$result = array("email"=>$to,"gwresponse"=>$gwresponse,"response"=>"Success");
        echo json_encode($result);
	}
}
?>
