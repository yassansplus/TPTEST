<?php

namespace App\Entity;

use App\Repository\TodoListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TodoListRepository::class)
 * @ORM\Table(name="`user`")
 */
class TodoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="todolist", cascade={"persist", "remove"})
     */
    private $userEntity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUserEntity(): ?User
    {
        return $this->userEntity;
    }

    public function setUserEntity(?User $userEntity): self
    {
        // unset the owning side of the relation if necessary
        if ($userEntity === null && $this->userEntity !== null) {
            $this->userEntity->setTodolist(null);
        }

        // set the owning side of the relation if necessary
        if ($userEntity !== null && $userEntity->getTodolist() !== $this) {
            $userEntity->setTodolist($this);
        }

        $this->userEntity = $userEntity;

        return $this;
    }
}
