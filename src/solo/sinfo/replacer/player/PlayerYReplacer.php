<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;

class PlayerYReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{Y}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{Y}", round($player->y, 2), $input);
  }
}
