<?php

namespace solo\sinfo\replacer\server;

use pocketmine\Server;

class PlayersCountReplacer extends ServerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{PLAYERS}") !== false;
  }

  public function replace(string $input, Server $server) : string{
    return str_ireplace("{PLAYERS}", count($server->getOnlinePlayers()), $input);
  }
}
