<?php

namespace solo\sinfo\replacer\server;

use pocketmine\Server;

class ServerMotdReplacer extends ServerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{MOTD}") !== false;
  }

  public function replace(string $input, Server $server) : string{
    return str_ireplace("{MOTD}", $server->getMotd(), $input);
  }
}
