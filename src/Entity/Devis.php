<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
 */
class Devis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $maquette;

    /**
     * @ORM\Column(type="integer")
     */
    private $lvlgraphisme;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrpage;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrlangue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partieblog;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $formulaireinscritdevis;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $forum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $accesmembre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $gestionfichier;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cartedynamique;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $integrvideo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $assistance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaquette(): ?int
    {
        return $this->maquette;
    }

    public function setMaquette(int $maquette): self
    {
        $this->maquette = $maquette;

        return $this;
    }

    public function getLvlgraphisme(): ?int
    {
        return $this->lvlgraphisme;
    }

    public function setLvlgraphisme(int $lvlgraphisme): self
    {
        $this->lvlgraphisme = $lvlgraphisme;

        return $this;
    }

    public function getNbrpage(): ?int
    {
        return $this->nbrpage;
    }

    public function setNbrpage(int $nbrpage): self
    {
        $this->nbrpage = $nbrpage;

        return $this;
    }

    public function getNbrlangue(): ?int
    {
        return $this->nbrlangue;
    }

    public function setNbrlangue(int $nbrlangue): self
    {
        $this->nbrlangue = $nbrlangue;

        return $this;
    }

    public function getPartieblog(): ?int
    {
        return $this->partieblog;
    }

    public function setPartieblog(?int $partieblog): self
    {
        $this->partieblog = $partieblog;

        return $this;
    }

    public function getFormulaireinscritdevis(): ?int
    {
        return $this->formulaireinscritdevis;
    }

    public function setFormulaireinscritdevis(?int $formulaireinscritdevis): self
    {
        $this->formulaireinscritdevis = $formulaireinscritdevis;

        return $this;
    }

    public function getForum(): ?int
    {
        return $this->forum;
    }

    public function setForum(?int $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    public function getAccesmembre(): ?int
    {
        return $this->accesmembre;
    }

    public function setAccesmembre(?int $accesmembre): self
    {
        $this->accesmembre = $accesmembre;

        return $this;
    }

    public function getGestionfichier(): ?int
    {
        return $this->gestionfichier;
    }

    public function setGestionfichier(?int $gestionfichier): self
    {
        $this->gestionfichier = $gestionfichier;

        return $this;
    }

    public function getCartedynamique(): ?int
    {
        return $this->cartedynamique;
    }

    public function setCartedynamique(?int $cartedynamique): self
    {
        $this->cartedynamique = $cartedynamique;

        return $this;
    }

    public function getIntegrvideo(): ?int
    {
        return $this->integrvideo;
    }

    public function setIntegrvideo(?int $integrvideo): self
    {
        $this->integrvideo = $integrvideo;

        return $this;
    }

    public function getAssistance(): ?int
    {
        return $this->assistance;
    }

    public function setAssistance(?int $assistance): self
    {
        $this->assistance = $assistance;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
