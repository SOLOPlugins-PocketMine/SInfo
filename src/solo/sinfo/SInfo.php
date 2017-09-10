<?php

namespace solo\sinfo;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;

use solo\sinfo\replacer\server\ServerInfoReplacer;
use solo\sinfo\replacer\world\WorldInfoReplacer;
use solo\sinfo\replacer\player\PlayerInfoReplacer;

class SInfo extends PluginBase implements Listener{

	/** @var SInfo */
	private static $instance;

	/** @var EconomyAPI */
	private static $economyapi = null;

	public static function getInstance() : SInfo{
		return self::$instance;
	}

	public static function isExistEconomyAPI() : bool{
		return self::$economyapi !== null;
	}

	public static function getMoney($player){
		return method_exists(self::$economyapi, "koreanWonFormat") ? self::$economyapi->koreanWonFormat(self::$economyapi->myMoney($player)) : self::$economyapi->myMoney($player);
	}

	public static function isExistRankMethod() : bool{
		return method_exists(self::$economyapi, "getRank");
	}

	public static function getRank($player) : string{
		return self::$economyapi->getRank($player);
	}

	public static function getTimeString(int $time) : string{
		if($time < 2000){
			return "아침";
		}else if($time < 12000){ // 2000 ~ 12000 : 낮
			return "낮";
		}else if($time < 14000){ // 12000 ~ 14000 : 저녁
			return "저녁";
		}else if($time < 23000){ // 14000 ~ 23000 : 밤
			return "밤";
		}else{
			return "아침";
		}
	}

	public static function getGamemodeString(int $gamemode) : string{
		if($gamemode === Player::SURVIVAL){
			return "서바이벌";
		}else if($gamemode === Player::CREATIVE){
			return "크리에이티브";
		}else if($gamemode === Player::ADVENTURE){
			return "어드벤쳐";
		}else if($gamemode === Player::SPECTATOR){
			return "관찰자";
		}
		return "Unknown";
	}

	public static function getDirectionString(int $direction) : string{
		if($direction === 0){
			return "남";
		}else if($direction === 1){
			return "서";
		}else if($direction === 2){
			return "북";
		}else if($direction === 3){
			return "동";
		}
		return "Unknown";
	}

	/** @var Config */
	private $setting;

	private $playerInfoReplacerList = [];
	private $worldInfoReplacerList = [];
	private $serverInfoReplacerList = [];

	private $adjustHorizontal = 0;
	private $adjustVertical = 0;

	public function onLoad(){
		if(self::$instance !== null){
			throw new \InvalidStateException();
		}
		self::$instance = $this;
	}

	public function onEnable(){
		@mkdir($this->getDataFolder());
		$this->saveResource("setting.yml");
		$this->setting = new Config($this->getDataFolder() . "setting.yml", Config::YAML);

		$this->adjustHorizontal = intval($this->setting->get("adjust-horizontal-text-on-screen", 3));
		$this->adjustVertical = intval($this->setting->get("adjust-vertical-text-on-screen", -3));

		self::$economyapi = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");

		$classBase = "solo\\sinfo\\replacer\\";
		foreach([
			"PlayerDirectionNameReplacer",
			"PlayerDirectionReplacer",
			"PlayerGamemodeReplacer",
			"PlayerHealthBarReplacer",
			"PlayerHealthReplacer",
			"PlayerHeartBarReplacer",
			"PlayerMaxHealthReplacer",
			"PlayerMoneyRankReplacer",
			"PlayerMoneyReplacer",
			"PlayerNameReplacer",
			"PlayerXReplacer",
			"PlayerYReplacer",
			"PlayerZReplacer"
		] as $className){
			$class = $classBase . "player\\" . $className;
			$this->playerInfoReplacerList[] = new $class();
		}

		foreach([
			"WorldNameReplacer",
			"WorldPlayersCountReplacer",
			"WorldTimeReplacer"
		] as $className){
			$class = $classBase . "world\\" . $className;
			$this->worldInfoReplacerList[] = new $class();
		}

		foreach([
			"DateReplacer",
			"MaxPlayersCountReplacer",
			"PlayersCountReplacer",
			"ServerAverageTPSReplacer",
			"ServerMotdReplacer",
			"ServerTPSReplacer",
			"TimeReplacer"
		] as $className){
			$class = $classBase . "server\\" . $className;
			$this->serverInfoReplacerList[] = new $class();
		}

		$this->getServer()->getScheduler()->scheduleRepeatingTask(new class($this) extends SInfoTask{
			public function _onRun(int $currentTick){
				$this->owner->handleTick($currentTick);
			}
		}, 1);

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onDisable(){

	}

	public function addServerInfoReplacer(ServerInfoReplacer $replacer){
		$this->serverInfoReplacerList[] = $replacer;
	}

	public function addWorldInfoReplacer(WorldInfoReplacer $replacer){
		$this->worldInfoReplacerList[] = $replacer;
	}

	public function addPlayerInfoReplacer(PlayerInfoReplacer $replacer){
		$this->playerInfoReplacerList[] = $replacer;
	}

	public function getServerInfoReplacerList(){
		return $this->serverInfoReplacerList;
	}

	public function getWorldInfoReplacerList(){
		return $this->worldInfoReplacerList;
	}

	public function getPlayerInfoReplacerList(){
		return $this->playerInfoReplacerList;
	}

	public function handleTick(int $currentTick){
		static $currentText = null;
		if($currentTick % 20 === 0 || $currentText === null){
			$horizontal = $this->adjustHorizontal;
			$vertical = $this->adjustVertical;
			$currentText =
				implode("\n", array_map(function($string) use($horizontal){
					if($horizontal == 0){
						return $string;
					}else if($horizontal < 0){
						return $string . str_repeat(" ", $horizontal * -20);
					}else{
						return str_repeat(" ", $horizontal * 20) . $string;
					}
				}, explode("\n", $this->setting->get("text-on-screen-format"))))
				. str_repeat("\n ", ($vertical + 3) * 5);
			foreach($this->serverInfoReplacerList as $replacer){
				if($replacer->canReplace($currentText)){
					$currentText = $replacer->replace($currentText, $this->getServer());
				}
			}
		}

		static $currentText_level = [];
		$c = $currentTick;
		foreach($this->getServer()->getLevels() as $level){
			$name = $level->getFolderName();
			if($c++ % 20 === 0 || !isset($currentText_level[$name])){
				$currentText_level[$name] = $currentText;
				foreach($this->worldInfoReplacerList as $replacer){
					if($replacer->canReplace($currentText_level[$name])){
						$currentText_level[$name] = $replacer->replace($currentText_level[$name], $level);
					}
				}
			}
		}

		$c = $currentTick;
		foreach($this->getServer()->getOnlinePlayers() as $player){
			if($c++ % 20 === 0){
				$send = $currentText_level[$player->getLevel()->getFolderName()];
				foreach($this->playerInfoReplacerList as $replacer){
					if($replacer->canReplace($send)){
						$send = $replacer->replace($send, $player);
					}
				}
				switch($this->setting->get("text-on-screen-channel", "tip")){
					case "popup": $player->sendPopup($send); break;
					case "actionbar": $player->sendActionbar($send); break;
					default: $player->sendTip($send); break;
				}
			}
		}
	}

	/**
	 * @priority HIGHEST
	 *
	 * @ignoreCancelled true
	 */
	public function handlePlayerChat(PlayerChatEvent $event){
		$message = $event->getMessage();
		if(preg_match('/{.+}/', $message)){
			foreach($this->serverInfoReplacerList as $replacer){
				if($replacer->canReplace($message)){
					$message = $replacer->replace($message, $this->getServer());
				}
			}
			foreach($this->worldInfoReplacerList as $replacer){
				if($replacer->canReplace($message)){
					$message = $replacer->replace($message, $event->getPlayer()->getLevel());
				}
			}
			foreach($this->playerInfoReplacerList as $replacer){
				if($replacer->canReplace($message)){
					$message = $replacer->replace($message, $event->getPlayer());
				}
			}
			$event->setMessage($message);
		}
	}
}
