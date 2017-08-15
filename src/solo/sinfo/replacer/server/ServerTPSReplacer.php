<?php

namespace solo\sinfo\replacer\server;

use pocketmine\Server;

class ServerTPSReplacer extends ServerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{TPS}") !== false;
  }

  public function replace(string $input, Server $server) : string{
    return str_ireplace("{TPS}", $server->getTicksPerSecond(), $input);
  }
}
