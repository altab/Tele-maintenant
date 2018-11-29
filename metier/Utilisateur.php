<?php


class Utilisateur {
    
    private $id, $nom, $prenom, $email, $password, $icone, $role;
    
    function __construct($id, $nom, $prenom, $email, $password, $icone, $role) {
        
        $this->setId($id);
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setIcone($icone);
        $this->setRole($role);
        
    }
    
    
    /*
     * Accesseurs
     */
    
    
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $nom
     */
    private function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @param mixed $prenom
     */
    private function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @param mixed $email
     */
    private function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $password
     */
    private function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $icone
     */
    private function setIcone($icone)
    {
        $this->icone = $icone;
    }

    /**
     * @param mixed $role
     */
    private function setRole($role)
    {
        $this->role = $role;
    }


    
}