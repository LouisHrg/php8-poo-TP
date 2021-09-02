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
        $hp = $target->getHp();

        if($defense >= $attack) {
            $attack = 0;
        } else {
            $attack = $attack - $defense;
        }

        $result = $hp - $attack;
        $target->setHp($result);
    }

    public function attackTargetWithMagic($target)
    {
        $attack = $this->getMagicAttack();
        $defense = $target->getMagicDefense();
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

$player = new Character(10, 20, 0, 0, 50, 10);
$player2 = new Character(10, 20, 0, 0, 50, 10);

$player->attackTarget($player2);
echo $player2->getHp();
