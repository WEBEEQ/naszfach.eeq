<?php
// src/AppBundle/Entity/MainForm.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class MainForm
{
    /**
     * @Assert\NotBlank()
     */
    protected $comment;

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getComment()
    {
        return $this->comment;
    }
}
