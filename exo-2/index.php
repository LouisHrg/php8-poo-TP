<?php

interface CharacterInterface {
    public function getAttack(): int;
    public function setAttack(int $attack): self;
    public function getDefense(): int;
    public function setDefense(int $defense): self;
    public function getMagicAttack(): int;
    public function setMagicAttack(int $magicAttack): self;
    public function getMagicDefense(): int;
    public function setMagicDefense(int $magicDefense): self;
    public function getMana(): int;
    public function setMana(int $mana): self;
    public function getHp(): int;
    public function setHp(int $hp): self;
}

class Character implements CharacterInterface {

    public function __construct(
      private int $attack = 0,
      private int $defense = 0,
      private int $magicAttack = 0,
      private int $magicDefense = 0,
      private int $hp = 0,
      private int $mana = 0,
    ) {}

    public function attackTarget($target)
    {
        $attack = $this->getAttack();
        $defense = $target->getDefense();

        $this->dealDammage($target, $attack, $defense);
    }

    public function attackTargetWithMagic($target)
    {
        $attack = $this->getMagicAttack();
        $defense = $target->getMagicDefense();

        $this->dealDammage($target, $attack, $defense);
    }

    public function dealDammage($target, $attack, $defense) {
        $hp = $target->getHp();

        if($defense >= $attack) {
            $attack = 0;
        } else {
            $attack = $attack - $defense;
        }

        $result = $hp - $attack;
        $target->setHp($result);
    }

    public function getAttack(): int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }

    public function getMagicAttack(): int
    {
        return $this->magicAttack;
    }

    public function setMagicAttack(int $magicAttack): self
    {
        $this->magicAttack = $magicAttack;

        return $this;
    }

    public function getMagicDefense(): int
    {
        return $this->magicDefense;
    }

    public function setMagicDefense(int $magicDefense): self
    {
        $this->magicDefense = $magicDefense;

        return $this;
    }

    public function getMana(): int
    {
        return $this->mana;
    }

    public function setMana(int $mana): self
    {
        $this->mana = $mana;

        return $this;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }
}

class Sorcier extends Character {

    public function attackTarget($target)
    {
        $attack = $this->getAttack();
        $defense = $target->getDefense();

        // Sorcier : Les dégâts physiques sont 1,3 plus puissant sur le sorcier
        $attack = DiceRoll::attackEffect($target, $attack);

        // Voleur : 1 chance sur 30 de ne recevoir aucun dégâts de mêlée
        $attack = DiceRoll::defenseEffect($target, $attack);

        $this->dealDammage($target, $attack, $defense);

    }

    public function attackTargetWithMagic($target)
    {

      $attack = $this->getAttack();
      $defense = $target->getDefense();

      // Sorcier : 1 chance sur 10 de multiplier ses dégâts magique par 2
      $attack = DiceRoll::randomEffect(10, 2, $attack);

      // Soldat : Les dégâts magiques sont 1,3 plus puissant sur le soldat
      $attack = DiceRoll::magicAttackEffect($target, $attack);

      // Sorcier : 1 chance sur 20 d’annuler les dégâts d’attaque magique
      $attack = DiceRoll::magicDefenseEffect($target, $attack);

      $this->dealDammage($target, $attack, $defense);
    }

}

class Voleur extends Character {

  public function attackTarget($target)
  {
      $attack = $this->getAttack();
      $defense = $target->getDefense();

      // Voleur : 1 chance sur 3 de multiplier les dégâts par 1,2
      $attack = DiceRoll::randomEffect(3, 1.2, $attack);

      // Sorcier : Les dégâts physiques sont 1,3 plus puissant sur le sorcier
      $attack = DiceRoll::attackEffect($target, $attack);

      // Voleur : 1 chance sur 30 de ne recevoir aucun dégâts de mêlée
      $attack = DiceRoll::defenseEffect($target, $attack);


      $this->dealDammage($target, $attack, $defense);
  }

  public function attackTargetWithMagic($target)
  {
      $attack = $this->getAttack();
      $defense = $target->getDefense();

      // Soldat : Les dégâts magiques sont 1,3 plus puissant sur le soldat
      $attack = DiceRoll::magicAttackEffect($target, $attack);

      // Sorcier : 1 chance sur 20 d’annuler les dégâts d’attaque magique
      $attack = DiceRoll::magicDefenseEffect($target, $attack);

      $this->dealDammage($target, $attack, $defense);
  }
}

class Soldat extends Character {

  public function attackTarget($target)
  {
      $attack = $this->getAttack();
      $defense = $target->getDefense();

      // Soldat : 1 chance sur 150 de multiplier les dégâts par 10
      $attack = DiceRoll::randomEffect(150, 10, $attack);

      // Voleur : 1 chance sur 30 de ne recevoir aucun dégâts de mêlée
      $attack = DiceRoll::defenseEffect($target, $attack);

      // Sorcier : Les dégâts physiques sont 1,3 plus puissant sur le sorcier
      $attack = DiceRoll::attackEffect($target, $attack);

      $this->dealDammage($target, $attack, $defense);
  }

  public function attackTargetWithMagic($target)
  {
      $attack = $this->getAttack();
      $defense = $target->getDefense();

      // Soldat : Les dégâts magiques sont 1,3 plus puissant sur le soldat
      $attack = DiceRoll::magicAttackEffect($target, $attack);

      // Sorcier : 1 chance sur 20 d’annuler les dégâts d’attaque magique
      $attack = DiceRoll::magicDefenseEffect($target, $attack);

      $this->dealDammage($target, $attack, $defense);
  }
}


class DiceRoll {

    public static function randomEffect(
        $random, $multiplier, $stat
    ) {
        if(rand(0, $random) === 0) {
            return $stat = $stat * $multiplier;
        }
        return $stat;
    }

    public static function attackEffect($target, $attack) {
        if(get_class($target) === Sorcier::class) {
            return $attack * 1.3;
        }
        return $attack;
    }

    public static function magicAttackEffect($target, $attack) {
        if(get_class($target) === Soldat::class) {
            return $attack * 1.3;
        }

        return $attack;
    }

    public static function magicDefenseEffect($target, $attack) {
        # si sorcier 1/20 chance d'annuler tout les dégats magiques
        if(get_class($target) === Sorcier::class && rand(0, 20) === 0) {
            return 0;
        }
        return $attack;
    }

    public static function defenseEffect($target, $attack) {
        if(get_class($target) === Voleur::class && rand(0, 30) === 0) {
            return 0;
        }
        return $attack;
    }
}

$player1 = new Soldat(50, 100, 10, 20, 150, 20);
$player2 = new Sorcier(10, 20, 50, 100, 150, 20);

$player2->attackTargetWithMagic($player1);
echo $player1->getHp();
