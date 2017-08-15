<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;

class PlayerHealthReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{HEALTH}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{HEALTH}", $player->getHealth(), $input);
  }
}
