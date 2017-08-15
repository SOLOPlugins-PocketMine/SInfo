<?php

namespace solo\sinfo\replacer\server;

use pocketmine\Server;

class MaxPlayersCountReplacer extends ServerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{MAXPLAYERS}") !== false;
  }

  public function replace(string $input, Server $server) : string{
    return str_ireplace("{MAXPLAYERS}", $server->getMaxPlayers(), $input);
  }
}
