<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role {
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\ManyToMany(targetEntity="App\Entity\Account", inversedBy="roles")
   */
  private $accounts;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $symbol;

  /**
   * @ORM\Column(type="text", nullable=true)
   */
  private $description;

  public function __construct() {
    $this->accounts = new ArrayCollection();
  }

  public function getId(): ?int {
    return $this->id;
  }

  /**
   * @return Collection|Account[]
   */
  public function getAccounts(): Collection {
    return $this->accounts;
  }

  public function addAccount(Account $account): self {
    if (!$this->accounts->contains($account)) {
      $this->accounts[] = $account;
    }

    return $this;
  }

  public function removeAccount(Account $account): self {
    if ($this->accounts->contains($account)) {
      $this->accounts->removeElement($account);
    }

    return $this;
  }

  public function getSymbol(): ?string {
    return $this->symbol;
  }

  public function setSymbol(string $symbol): self {
    $this->symbol = $symbol;

    return $this;
  }

  public function getDescription(): ?string {
    return $this->description;
  }

  public function setDescription(string $description): self {
    $this->description = $description;

    return $this;
  }
}
