<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Topic extends Entity{

    private $id;
    private $title;
    private $user;
    private $category;
    private $creationDate;
    private $statut;

    public function __construct($data){         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle(){
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser(){
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user){
        $this->user = $user;
        return $this;
    }
    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }
    public function getCategoryID(){
     return $this->category->getId();
    }
    
    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

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
    public function getStatut(){
        return $this->statut;
    }
    public function setStatut($statut){
        $this->statut = $statut;
        return $this;
    }
    

    public function __toString(){
        return $this->title;
    }

}