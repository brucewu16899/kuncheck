<?session_start();
header("Content-Type:text/html ; charset=utf-8");
$info[0]["name"]="website";
$info[0]["address"]="211.21.192.220";
$info[0]["port"]="80";

$info[1]["name"]="mail";
$info[1]["address"]="211.21.192.220";
$info[1]["port"]="110";

$date3=date("m/d h:i:s");

$infocount = 1;
$timeout = 2;

function sentgmail ($msg){
	//要是有Warning: stream_socket_enable_crypto() [streams.crypto]: this stream does not support SSL/crypto in錯誤
	//要去php.ini啟動extension=php_openssl.dll 這個才可以
	include("../PHPMailer_v5.1/class.phpmailer.php"); //匯入PHPMailer類別       
      
	$mail= new PHPMailer();									//建立新物件        
	$mail->IsSMTP(); //設定使用SMTP方式寄信        
	$mail->SMTPAuth = true; //設定SMTP需要驗證   
	$mail->SMTPSecure = "tls";								 // Gmail的SMTP主機需要使用SSL連線   
	$mail->Host = "smtp.gmail.com"; 						//Gamil的SMTP主機        
	$mail->Port = 587; 										//Gamil的SMTP主機的SMTP埠位為465埠。        
	$mail->CharSet = "utf8"; 								//設定郵件編碼        
      
	$mail->Username = "yzuradio@gmail.com"; 				//設定驗證帳號   
	$mail->Password = "20radio08";						 //設定驗證密碼 
	$mail->From = "yzuradio@gmail.com";					 //設定寄件者信箱
	$mail->FromName = "plurk自動系統";					 //設定寄件者姓名
	$mail->Subject = "[報告] 來自廣力系統的信"; 	//設定郵件標題        
	$mail->Body =$msg; 									//設定郵件內容        
	$mail->IsHTML(true);								//設定郵件內容為HTML        
	$mail->AddAddress("davidou1234@gmail.com", "老歐"); //設定收件者郵件及名稱          
	//$mail->AddAddress("bency80097@gmail.com", "班西"); //設定收件者郵件及名稱 

	if(!$mail->Send()) {        
		echo "Mailer Error: " . $mail->ErrorInfo;        
	} else {        
	echo "Message sent!";        
	}
}

echo '<table width="500" border="0">';
for ($i=0; $i<=$infocount; $i++){
$fp = @fsockopen ($info[$i]["address"], $info[$i]["port"], $errno, $errstr, $timeout);
$name=$info[$i]["name"];
if ($fp) {
echo "<tr><td><img src='signal-Vista.png' alt='Connected'  width=24 height=24 >存在</td><td><a href='http://" . $info[$i]["address"] . "'>" . $info[$i]["name"] . "</a></td><td>" . $info[$i]["address"] . "</td><td>" . $info[$i]["port"] . "</td></tr>";

$_SESSION[$name]=NULL;
}else{

if($_SESSION[$name]!="send"){
$_SESSION[$name]="send";
	sentgmail("死機拉~ 	\"". $info[$i]["name"]."\"\r\n".$date3);
echo "送信拉".$name;
	}
	
	else{$error= "等待修復";}
	
echo "<tr><td>不存在</td><td>" . $info[$i]["name"] . "</td><td>" . $info[$i]["address"] . "</td><td>" . $info[$i]["port"] . " ".$error."</td></tr>";


	}
}
echo "</tr></table>";


?>


<html>
<head>
<title>廣力偵測網頁</title>
<meta http-equiv="refresh" content="120; url=check.php" />

</head>
<body>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
<? echo "現在時間".$date3;?>
</body>

</html>