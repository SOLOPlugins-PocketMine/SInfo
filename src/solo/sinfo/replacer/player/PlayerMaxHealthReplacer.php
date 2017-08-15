<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;

class PlayerMaxHealthReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{MAXHEALTH}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{MAXHEALTH}", $player->getMaxHealth(), $input);
  }
}
