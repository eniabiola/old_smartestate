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
	.myButton {
		background:linear-gradient(to bottom, #44c767 5%, #5cbf2a 100%);
		background-color:#44c767;
		border-radius:28px;
		border:1px solid #18ab29;
		display:inline-block;
		cursor:pointer;
		color:#ffffff;
		font-family:Arial;
		font-size:17px;
		padding:7px 31px;
		text-decoration:none;
		text-shadow:0px 1px 0px #2f6627;
	}
	.myButton:hover {
		background:linear-gradient(to bottom, #5cbf2a 5%, #44c767 100%);
		background-color:#5cbf2a;
	}
	.myButton:active {
		position:relative;
		top:1px;
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
function send_email_all($to,$title,$msg,$msgorg){
    $html_message = msg_body($title,$msgorg,$msg);
	$postmark = new Postmark("e2f3bbec-9c13-45f3-88f2-260e44f3956c","$title <support@yellowduplex.com>","$title <support@yellowduplex.com>");
    return $result = $postmark->to($to)->subject($title)->html_message($html_message)->send();
}
?>