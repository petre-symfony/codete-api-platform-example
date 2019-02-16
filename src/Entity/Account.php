<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 */
class Account {
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank(message="Please provide username")
   */
  private $username;

  /**
   * @ORM\Column(type="boolean", options={"default" : false})
   */
  private $isActive;

  /**
   * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="accounts")
   * @ApiSubresource(maxDepth=1)
   */
  private $roles;

  public function __construct() {
    $this->roles = new ArrayCollection();
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getUsername(): ?string {
    return $this->username;
  }

  public function setUsername(string $username): self {
    $this->username = $username;

    return $this;
  }

  public function getIsActive(): ?bool {
    return $this->isActive;
  }

  public function setIsActive(bool $isActive): self {
    $this->isActive = $isActive;

    return $this;
  }

  /**
   * @return Collection|Role[]
   */
  public function getRoles(): Collection {
    return $this->roles;
  }

  public function addRole(Role $role): self {
    if (!$this->roles->contains($role)) {
      $this->roles[] = $role;
      $role->addAccount($this);
    }

    return $this;
  }

  public function removeRole(Role $role): self {
    if ($this->roles->contains($role)) {
      $this->roles->removeElement($role);
      $role->removeAccount($this);
    }

    return $this;
  }
}
