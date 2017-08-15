<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;

class PlayerHeartBarReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{HEARTBAR}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace(
      "{HEARTBAR}",
      "§c" . str_repeat('♥', floor($player->getHealth() / 2))
      . (($player->getHealth() / 2 - floor($player->getHealth() / 2) > 0) ? '♡' : '')
      . "§0" . str_repeat('♥', floor(($player->getMaxHealth() - $player->getHealth()) / 2)),
      $input
    );
  }
}
