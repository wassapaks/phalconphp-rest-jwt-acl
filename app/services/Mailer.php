<?php

namespace Services;

Class Mailer {


	protected $config;

	public function __construct($config){
		$this->config = $config;
	}

    // send email using postmark
    public function sendMail($email, $subject, $content, $template) {


		if($template === 'addTemplate'){
			$body = $this->$template($content);
		}else{
			$body = "Empty Body";
		}

        $json = json_encode(array(
            'From' => $this->config->postmark->signature,
            'To' => $email,
            'Name' => 'Medisource',
            'Subject' => $subject,
            'HtmlBody' => $body
        ));
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $this->config->postmark->url);
        curl_setopt($ch2, CURLOPT_POST, true);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'X-Postmark-Server-Token: '.$this->config->postmark->token
        ));
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $json);
        $response = curl_exec($ch2);
        $http_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        curl_close($ch2);
        return true;
    }


    private function addTemplate($emailcontent){

        $content =
            '<html lang=en>
		<head>
			<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
			<meta name=viewport content="width=device-width, initial-scale=1">
			<meta http-equiv=X-UA-Compatible content=IE=edge>
			<meta name=format-detection content=telephone=no>
			<title>Body and Brain</title>

			<style type=text/css>
				body{margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}
				table{border-spacing: 0;}table td{border-collapse: collapse;}
				.ExternalClass{width: 100%;}
				.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div {line-height: 100%;}
				.ReadMsgBody {width: 100%;background-color: #ebebeb;}table {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}img {-ms-interpolation-mode: bicubic;}
				.yshortcuts a {border-bottom: none !important;}
				@media screen and (max-width: 599px) {
					.force-row,.container {width: 100% !important;max-width: 100% !important;}
				}
				@media screen and (max-width: 400px) {
					.container-padding {padding-left: 12px !important;padding-right: 12px !important;}
				}
				.ios-footer a {color: #aaaaaa !important;
					text-decoration: underline;}
				</style>
			</head>
			<body style="margin:0; padding:0;" bgcolor=#F0F0F0 leftmargin=0 topmargin=0 marginwidth=0 marginheight=0>
				<table border=0 width=100% height=100% cellpadding=0 cellspacing=0 bgcolor=#F0F0F0>
					<tr>
						<td align=center valign=top bgcolor=#F0F0F0 style="background-color: #F0F0F0;">
							<br>
							<table border=0 width=600 cellpadding=0 cellspacing=0 class=container style=width:600px;max-width:600px>
								<tr>
									<td class="container-padding header" align=left style="font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:12px;color:#49AFCD;padding-left:24px;padding-right:24px">Medisource</td>
								</tr>
								<tr>
									<td class="container-padding content" align=left style=padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff>
										<br>
										<div class=title style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#49AFCD">Login Information</div>
										<br>
										<div class=body-text style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:20px;text-align:left;color:#333333">This email was sent in response to your account credential for you to be able to login on our software. In order to login.
											<br><br>
										</div>

										<div class=body-text style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:20px;text-align:left;color:#333333">
											<span style="font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:600;color:#49AFCD">Username: </span>
											<span style="font-family:Helvetica, Arial, sans-serif;font-size:12px;font-weight:600;">'.$emailcontent["username"].'</span>
											<br>
											<span style="font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:600;color:#49AFCD">Password: </span>
											<span style="font-family:Helvetica, Arial, sans-serif;font-size:12px;font-weight:600;">'.$emailcontent["password"].' <i>(temporary password)</i></span>
											<br><br>
										</div>

										<div class=body-text style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:20px;text-align:left;color:#333333;margin-bottom:10px;">
											<span>To login your account please click the button bellow or copy and paste the link to browser.</span>
											<br>
											<br>
											<span>After you login please change your temporary password.</span>
											<br>
											<br>
											<a href="'.$this->config->application->baseURL.'/login'.'" style="background:#49AFCD;color:#FFF;padding:10px;text-decoration: none;border-radius:5px;font-size:14px;">Login Page</a>
											<br>
											<br>
											<a href="'.$this->config->application->baseURL.'/login'.'">'.$this->config->application->baseURL.'/login'.'</a>
											<br>
											<br>
										</div>

									</td>
								</tr>
								<tr>
									<td class="container-padding footer-text" align=left style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:16px;color:#aaaaaa;padding-left:24px;padding-right:24px">
										<br><br>
										Copyright: © Medisource
										<br><br>
										<strong>Medisource</strong>
										<br>
										<a href="http://www.bodynbrain.com" style=color:#aaaaaa>www.medisource.com</a>
										<br> <br><br>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</body>
			</html>';

        return $content;
    }


}