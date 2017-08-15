<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;

class PlayerXReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{X}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{X}", round($player->x, 2), $input);
  }
}
