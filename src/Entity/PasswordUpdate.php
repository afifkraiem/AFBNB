<?php

namespace App\Entity;

use App\Repository\PasswordUpdateRepository;
use Doctrine\ORM\Mapping as ORM;
use SYmfony\component\Validator\Constraints as Assert;

class PasswordUpdate
{
 

    private $oldPassword;

    /**
     
    * @Assert\Regex(
    * pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/i",message="Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole.")
     */
    private $newPassword;
/**
     * @Assert\EqualTo(propertyPath="newPassword", message=" les deux mots de passes ne sont pas identiques ")
     */
    private $confirmPassword;

    

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
