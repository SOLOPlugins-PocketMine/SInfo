<?php

namespace solo\sinfo\replacer;

abstract class Replacer{

  abstract public function canReplace(string $input) : bool;

}
