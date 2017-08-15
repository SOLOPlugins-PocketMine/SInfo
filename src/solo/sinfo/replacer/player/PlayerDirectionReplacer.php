<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;
use solo\sinfo\SInfo;

class PlayerDirectionReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{DIRECTION}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{DIRECTION}", $player->getDirection(), $input);
  }
}
