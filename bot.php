<?php

    date_default_timezone_set("Asia/kolkata");
    //Data From Webhook
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];
    $id = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $firstname = $update["message"]["from"]["first_name"];
    $chatname = $_ENV['CHAT']; 
 /// for broadcasting in Channel
$channel_id = "-100xxxxxxxxxx";

/////////////////////////

    //Extact match Commands
    if($message == "/start"){
        send_message($chat_id,$message_id, "Hey $firstname \nUse /cmds to view commands \n$chatname");
    }

    if($message == "/cmds" || $message == "/cmds@github_rbot"){
        send_message($chat_id,$message_id, "
          /deneme <query> (Google search)
          \n/smirror <name> (Search Movies/Series)
          \n/bin <bin> (Bin Data)
          \n/weather <name of your city> (Current weather Status)
          \n/dice (dice emoji random 1-6)
          \n/date (today's date)
          \n/dict <word> (Dictionary)
          \n/time (current time)
          \n/git <username> (Github User Info)
          \n/repodl <username/repo_name> (Download Github Repository)
          \n/btcrate (Current BTC Rate)
	  \n/ethrate (Current ETH Rate)
          \n/inbtc <USD> (Convert USD to BTC)
          \n/toss (Random Heads or Tails)
          \n/syt <query> (Search on Youtube)
          \n/info (User Info)
          \n/help 
          ");
    }
    if($message == "/date"){
        $date = date("d/m/y");
        send_message($chat_id,$message_id, $date);
    }
   if($message == "/help"){
        $help = "Contact @reboot13_dev";
        send_message($chat_id,$message_id, $help);
    }
   if($message == "/time"){
        $time = date("h:i a", time());
        send_message($chat_id,$message_id, $time);
    }

  if($message == "/sc" || $message == "/si" || $message == "/st" || $message == "/cs" || $message == "/ua" || $message == "/at"  ){
   $botdown = "@WorldCheckerBot is under Maintenance";
        send_message($chat_id,$message_id, $botdown);
    }

if($message == "/dice"){
        sendDice($chat_id,$message_id, "🎲");
    }


    

if($message == "/toss"){
      $toss =array("Heads","Tails","Heads","Tails","Heads");
    $random_toss=array_rand($toss,4);
    $tossed = $toss[$random_toss[0]];
        send_message($chat_id,$message_id, "$tossed \nTossed By: @$username");
    }

     if($message == "/info"){
        send_message($chat_id,$message_id, "User Info \nName: $firstname\nID:$id \nUsername: @$username");
    }




///Commands with text


    //Google Search
if (strpos($message, "/search") === 0) {
        $search = substr($message, 8);
         $search = preg_replace('/\s+/', '+', $search);
$googleSearch = "[View On Web](https://www.google.com/search?q=$search)";
    if ($googleSearch != null) {
     send_MDmessage($chat_id,$message_id, $googleSearch);
    }
  }

//World Mirror Search
if (strpos($message, "/smirror") === 0) {
$smovie = substr($message, 9);
$smovie = preg_replace('/\s+/', '+', $smovie);
$murl = "[Results-Go to World Mirror](https://witcher.lalbaake456.workers.dev/0:search?q=$smovie)";
if ($smovie != null) {
  send_MDmessage($chat_id,$message_id, $murl);
}
}

if (strpos($message, "/repodl") === 0) {
$gitdlurl = substr($message, 8);
$gitdlurl1 = "[Click here](https://github.com/$gitdlurl/archive/master.zip)";
if ($gitdlurl != null) {
  send_MDmessage($chat_id,$message_id, "https://github.com/$gitdlurl/archive/main.zip
 \n⬇️In Case of no preview⬇️ \n$gitdlurl1"  );
}
}

//Youtube Search
if (strpos($message, "/syt") === 0) {
$syt = substr($message, 5);
$syt = preg_replace('/\s+/', '+', $syt);
$yurl = "[Open Youtube](https://www.youtube.com/results?search_query=$syt)";
if ($syt != null) {
  send_MDmessage($chat_id,$message_id, $yurl);
}
}


///Channel BroadCast
if (strpos($message, "/broadcast") === 0) {
$broadcast = substr($message, 11);
// id == (admins user id)
if ($id == 1171876903 /*|| $id == 1478297206 || $id == 654455829 || $id == 638178378 || $id == 971532801*/ ) { // || uncomment for multiple admins
  send_Cmessage($channel_id, $broadcast);
}
else {
    send_message($chat_id,$message_id, "You are not authorized to use this command");
 // example
///send_message("-100xxxxxxxxxx",$message_id, "You are not authorized to use this command");
///send_message("@channel_username",$message_id, "You are not authorized to use this command");
/// You can add as many channel and chat you want use the above format (make sure bot is promoted as admin in chat and channel)
}

}


//Bin Lookup
     if(strpos($message, "/bin") === 0){
        $bin = substr($message, 5);
   $curl = curl_init();
   curl_setopt_array($curl, [
	CURLOPT_URL => "https://lookup.binlist.net/".$bin,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"authority: lookup.binlist.net",
		"accept: application/json",
		"accept-language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
		"origin: https://binlist.net",
		"https://binlist.net/",
		"sec-fetch-dest: empty",
		"sec-fetch-site: same-site"
	],
]);

$result = curl_exec($curl);
curl_close($curl);
$data = json_decode($result, true);
$bank = $data['bank']['name'];
$country = $data['country']['alpha2'];
$currency = $data['country']['currency'];
$emoji = $data['country']['emoji'];
$scheme = $data['scheme'];
$Brand = $data['brand'];
$type = $data['type'];
  if ($scheme != null) {
        send_MDmessage($chat_id,$message_id, "***
✅ Valid BIN
Bin: $bin
Type: $scheme
Brand : $Brand
Bank: $bank
Country: $country $emoji
Currency: $currency
Credit/Debit:$type
Checked By @$username ***");
    }
else {
    send_MDmessage($chat_id,$message_id, "Enter Valid BIN");
}
   }
    




    //Wheather API
if(strpos($message, "/weather") === 0){
        $location = substr($message, 9);
        $weatherToken = ""; ///get api key from openweathermap.org

   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "http://api.openweathermap.org/data/2.5/weather?q=$location&appid=$weatherToken",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"Accept: */*",
        "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
        "Host: api.openweathermap.org",
        "sec-fetch-dest: empty",
		"sec-fetch-site: same-site"
  ],
]);


$content = curl_exec($curl);
curl_close($curl);
$resp = json_decode($content, true);

$weather = $resp['weather'][0]['main'];
$description = $resp['weather'][0]['description'];
$temp = $resp['main']['temp'];
$humidity = $resp['main']['humidity'];
$feels_like = $resp['main']['feels_like'];
$country = $resp['sys']['country'];
$name = $resp['name'];
$kelvin = 273;
$celcius = $temp - $kelvin;
$feels = $feels_like - $kelvin;

if ($location = $name) {
        send_MDmessage($chat_id,$message_id, "***
Weather at $location: $weather
Status: $description
Temp : $celcius °C
Feels Like : $feels °C
Humidity: $humidity
Country: $country 
Checked By @$username ***");
}
else {
           send_message($chat_id,$message_id, "Invalid City");
}
    }

///Github User API
if(strpos($message, "/git") === 0){
  $git = substr($message, 5);
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.github.com/users/$git",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 50,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "Accept-Encoding: gzip, deflate, br",
    "Accept-Language: en-GB,en;q=0.9",
    "Host: api.github.com",
    "Sec-Fetch-Dest: document",
    "Sec-Fetch-Mode: navigate",
    "Sec-Fetch-Site: none",
    "Sec-Fetch-User: ?1",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36"
  ],
]);


$github = curl_exec($curl);
curl_close($curl);
$gresp = json_decode($github, true);

$gusername = $gresp['login'];
$glink = $gresp['html_url'];
$gname = $gresp['name'];
$gcompany = $gresp['company'];
$blog = $gresp['blog'];
$gbio = $gresp['bio'];
$grepo = $gresp['public_repos'];
$gfollowers = $gresp['followers'];
$gfollowings = $gresp['following'];


if ($gusername) {
        send_MDmessage($chat_id,$message_id, " ***
Name: $gname
Username: $gusername
Bio: $gbio
Followers: $gfollowers
Following : $gfollowings
Repositories: $grepo
Website: $blog
Company: $gcompany
Github url: $glink
Checked By @$username ***");
}
else {
           send_message($chat_id,$message_id, "User Not Found \nInvalid github username checked by @$username");
}
    }

    /// Conversion - USD => BTC

if(strpos($message, "/inbtc") === 0){
$inbtc = substr($message, 7);
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://blockchain.info/tobtc?currency=USD&value=$inbtc",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7",
        "cookie: __cfduid=d922bc7ae073ccd597580a4cfc5e562571614140229",
        "referer: https://www.blockchain.com/",
        "sec-fetch-dest: document",
        "sec-fetch-mode: navigate",
        "sec-fetch-site: cross-site",
        "sec-fetch-user: ?1",
        "upgrade-insecure-requests: 1",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$valueinbtc = curl_exec($curl);
curl_close($curl);
$outvalue = json_decode($valueinbtc, true);

send_MDmessage($chat_id,$message_id, "***USD = $inbtc \nBTC = $outvalue \nValue checked by @$username ***");
}

/// Bitcoin Rate
if(strpos($message, "/btcrate") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://blockchain.info/ticker",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7",
        "cache-control: max-age=0",
        "cookie: __cfduid=d922bc7ae073ccd597580a4cfc5e562571614140229",
        "referer: https://www.blockchain.com/",
        "sec-fetch-dest: document",
        "sec-fetch-mode: navigate",
        "sec-fetch-site: cross-site",
        "sec-fetch-user: ?1",
        "upgrade-insecure-requests: 1",
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$btcvalue = curl_exec($curl);
curl_close($curl);
$currentvalue = json_decode($btcvalue, true);

$valueinUSD = $currentvalue["USD"]["15m"];
$valueinINR = $currentvalue["INR"]["15m"];

send_MDmessage($chat_id,$message_id, "***1 BTC \nUSD = $valueinUSD $ \nINR = $valueinINR ₹ \nRate checked by @$username ***");
}


/// Etherum Rate
if(strpos($message, "/ethrate") === 0){
   $curl = curl_init();
   $ethToken = ""; /// Get Api key from etherscan.io
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.etherscan.io/api?module=stats&action=ethprice&apikey=$ethToken",

	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept-encoding: gzip, deflate, br",
"accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7",
"cache-control: max-age=0",
"cookie: __cfduid=d842bd50be4d4c3d6eef45691148f3fb81614487925; _ga=GA1.2.533709807.1614487927; _gid=GA1.2.138466737.1614487927",
"sec-fetch-dest: document",
"sec-fetch-mode: navigate",
"sec-fetch-site: none",
"sec-fetch-user: ?1",
"upgrade-insecure-requests: 1",
"user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Mobile Safari/537.36"
  ],
]);
$ethValue = curl_exec($curl);
curl_close($curl);
$ethCurrentValue = json_decode($ethValue, true);

$ethValueInUSD = $ethCurrentValue["result"]["ethusd"];

send_MDmessage($chat_id,$message_id, "***1 ETH \nUSD = $ethValueInUSD $ \nRate checked by @$username ***");
}


///Dictionary API
 if(strpos($message, "/dict") === 0){
  $dict = substr($message, 6);
  $curl = curl_init();
  curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.dictionaryapi.dev/api/v2/entries/en/$dict",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "accept: */*",
    "accept-encoding: gzip, deflate, br",
    "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7",
    "origin: https://google-dictionary.vercel.app",
    "referer: https://google-dictionary.vercel.app/",
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: cross-site",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
        ],
]);


  $dictionary = curl_exec($curl);
  curl_close($curl);

$out = json_decode($dictionary, true);
$definition0 = $out[0]['meanings'][0]['definitions'][0]["definition"];
$definition1 = $out[0]['meanings'][1]['definitions'][0]["definition"];

$example = $out[0]['meanings'][0]['definitions'][0]["example"];

$Voiceurl = $out[0]["phonetics"][0]["audio"];

if ($definition0 != null) {
        send_MDmessage($chat_id,$message_id, "***
Word: $dict
meanings : 
1:$definition0
2:$definition1
Example : $example
Pronunciation : $Voiceurl
Checked By @$username ***");
    }
    else {
        send_message($chat_id,$message_id, "Invalid Input");
    }
}
///Send Message (Global)
    function send_message($chat_id,$message_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&reply_to_message_id=$message_id&text=$text");
    }
    
//Send Messages with Markdown (Global)
      function send_MDmessage($chat_id,$message_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&reply_to_message_id=$message_id&text=$text&parse_mode=Markdown");
    }
///Send Message to Channel
      function send_Cmessage($channel_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$channel_id&text=$text");
    }

//Send Dice (dynamic emoji)
function sendDice($chat_id,$message_id, $message){
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendDice?chat_id=$chat_id&reply_to_message_id=$message_id&text=$message");
    }


?>
