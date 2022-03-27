<?php
function msg_body($msgtitle,$org,$msg){
    $email_body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>'.$msgtitle.'!</title>    
      </head>
      <body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#F2F4F6">
    <style type="text/css">
    body {
    width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #F2F4F6; color: #74787E; -webkit-text-size-adjust: none;
    }
    @media only screen and (max-width: 600px) {
      .email-body_inner {
        width: 100% !important;
      }
      .email-footer {
        width: 100% !important;
      }
    }
    @media only screen and (max-width: 500px) {
      .button {
        width: 100% !important;
      }
    }
    </style>
        <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#F2F4F6">
          <tr>
            <td align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
              <table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
              <tr>
              <td style="text-align: center;">
              
              </td>
          </tr>
          <tr>
            <td style="box-sizing: border-box; color: #fff; font-size: 18px; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 10px 0; word-break: break-word;" align="center" bgcolor="#1F99CC">
            '.$org.'
            </td>
          </tr>
                <tr>
                  <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#E0E0E0">
                    <table class="email-body_inner" align="center" width="80%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">
                      <tr>
                        <td class="content-cell" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word; font-size:16px;">
                          '.$msg.'                                       
                          </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#1F99CC" style="box-sizing: border-box; color: #fff; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; word-break: break-word;">
                    <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                      <tr>
                        <td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                          <p class="sub align-center" style="box-sizing: border-box; color: #fff; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">© 2020. All rights reserved.</p>
                          <p class="sub align-center" style="box-sizing: border-box; color: #fff; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center"></p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </body>
    </html>';
    return $email_body;
    }
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
function send_sms($to,$msg)
{
	$senderid = "Estate App";
	$sessionid = "01836163-83b7-4b97-ab81-1166f51b5454";
	$url = "http://www.smslive247.com/http/index.aspx?"
	. "cmd=sendmsg"
	. "&sessionid=" . UrlEncode($sessionid)
	. "&message=" . UrlEncode($msg)
    . "&sender=" . UrlEncode($senderid)
	. "&sendto=" . UrlEncode($to)
    . "&msgtype=0";
	return @fopen($url, "r");
}
function send_email($msgorg,$to,$title,$msg){
    $html_message = msg_body($title,$msgorg,$msg);
    $postmark = new Postmark("b2b62f8b-af73-4bb8-8cba-bca091bd40e4","$title <support@yellowduplex.com>","$title <support@yellowduplex.com>");
    $result = $postmark->to($to)->subject($title)->html_message($html_message)->send();
}
?>