<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;

class PlayerZReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{Z}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{Z}", round($player->z, 2), $input);
  }
}
