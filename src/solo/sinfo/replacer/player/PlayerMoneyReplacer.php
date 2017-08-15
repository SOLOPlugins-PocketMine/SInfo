<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;
use solo\sinfo\SInfo;

class PlayerMoneyReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{MONEY}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{MONEY}", (SInfo::isExistEconomyAPI()) ? SInfo::getMoney($player) : "ERROR", $input);
  }
}
