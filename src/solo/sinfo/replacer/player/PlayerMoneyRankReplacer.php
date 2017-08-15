<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;
use solo\sinfo\SInfo;

class PlayerMoneyRankReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{MONEYRANK}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{MONEYRANK}", (SInfo::isExistRankMethod()) ? SInfo::getRank($player) : "ERROR", $input);
  }
}
