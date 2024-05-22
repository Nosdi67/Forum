<?php

namespace Model\Entities;

use App\Entity;

final class Post extends Entity {

    private $id;
    private $text;
    private $creationDate;
    private $user;
   

  public function __construct($data){
    $this->hydrate($data);
  }



    /**
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        if ($this->creationDate instanceof \DateTime) {
            return $this->creationDate->format('d/m/Y H:i:s');
        }
        // Si creationDate est une chaîne de caractères, la convertir
        $date = new \DateTime($this->creationDate);
        return $date->format('d/m/Y H:i:s');
        
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        if (!$creationDate instanceof \DateTime) {
            $creationDate = new \DateTime($creationDate);
        }
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
?>