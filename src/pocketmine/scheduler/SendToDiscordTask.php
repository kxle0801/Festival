<?php



namespace pocketmine\scheduler;

use function file_put_contents;
use pocketmine\Server;

class SendToDiscordTask extends AsyncTask{

	private $message;

	public function __construct($message){
		$this->message = $message;
		$this->username = Server::$webhookName;
		$this->url = Server::$discordWebhookLink;
	}

	public function onRun(){
		$data = [
			"username" => $this->username,
			"content" => $this->message
		];

		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0 Festival"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$ret = curl_exec($ch);
		curl_close($ch);
	}
}
