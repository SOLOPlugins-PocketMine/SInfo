<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;

class PlayerHealthBarReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{HEALTHBAR}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{HEALTHBAR}", "§c" . str_repeat('|', $player->getHealth()) . "§0" . str_repeat('|', $player->getMaxHealth() - $player->getHealth()), $input);
  }
}
