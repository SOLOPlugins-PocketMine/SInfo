<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;
use solo\sinfo\SInfo;

class PlayerGamemodeReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{GAMEMODE}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{GAMEMODE}", SInfo::getGamemodeString($player->getGamemode()), $input);
  }
}
