<?php
$access_token = 'aPRL1nzy4bv5J+iuL4vXXwnH352+hRAf/uXBHSrbrvsYklUaPpk1tIiqylteTDqKIfQOtEF9fCT7e0fUEv+8tnrM73mzSoG45ScIfNpRASEn2c0YeMGz4SeqYOECkxBkxKmbQiwsoXLJqYeekPvTowdB04t89/1O/w1cDnyilFU=';
$chanel_secret = '185c063487124d07c972c87bd8a5278b';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		if($event['type'] == 'follow' && $event['source']['type'] == 'user'){
			$userid = $event['source']['userId'];
			
			//// get data
			$url = 'https://api.line.me/v2/bot/profile/'.$userid;
			$headers = array('Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			
			$result_re = json_decode($result,true);
			
			$replyToken = $event['replyToken'];
			$str = 'Welcome to EON Solution ';
			$messages = [
				'type' => 'text',
				'text' => $result;
			];
			
			$url = 'https://api.line.me/v2/bot/message/push';
			$data = [
				'to' => $userid,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
			
		}
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			//Get User ID
			$userid = $event['source']['userId'];
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			
			if($text == 'image'){
				$url = 'https://shrouded-harbor-88523.herokuapp.com/download.png';
				$messages = [
				'type' => 'image',
				'originalContentUrl' => $url,
				'previewImageUrl' => $url
			];
			}else if($text == 'video'){
				$url = 'https://shrouded-harbor-88523.herokuapp.com/web_lpr.mp4';
				$url2 = 'https://shrouded-harbor-88523.herokuapp.com/download.png';
				$messages = [
				'type' => 'video',
				'originalContentUrl' => $url,
				'previewImageUrl' => $url
			];
			}else{
				$messages = [
				'type' => 'text',
				'text' => $text
			];
			}

			// Build message to reply back
			

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}else{

	echo "NOT EVENT";

}
echo "OK";
