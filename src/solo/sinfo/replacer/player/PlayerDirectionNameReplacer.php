<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;
use solo\sinfo\SInfo;

class PlayerDirectionNameReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{DIRECTIONNAME}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{DIRECTIONNAME}", SInfo::getDirectionString($player->getDirection()), $input);
  }
}
