<?php

class Sorcier extends Character {
  public function attackTarget($target)
  {
      $attack = $this->getAttack();
      $defense = $target->getDefense();

      echo 'ping';

      //self::dealDammage($target, $attack, $defense);
  }
}
