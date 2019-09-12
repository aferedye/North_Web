<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
 */
class Devis
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('email', new Assert\Regex([
            'pattern' => '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',
            'message' => 'Votre adresse e-mail n\'est pas valide',
        ]));

        $metadata->addPropertyConstraint('telephone', new Assert\Regex([
            'pattern' => '/^[0-9\.\-\(\)\/\+\s]*$/',
            'message' => 'Votre n° de téléphone n\'est pas valide',
        ]));

        $metadata->addPropertyConstraint('nom', new Assert\Regex([
            'pattern' => '/^([A-Z]|[a-z])[a-z]*(-)?[a-z]+$/',
            'message' => 'Votre nom n\'est pas valide',
        ]));

        $metadata->addPropertyConstraint('prenom', new Assert\Regex([
            'pattern' => '/^([A-Z]|[a-z])[a-z]*(-)?[a-z]+$/',
            'message' => 'Votre prénom n\'est pas valide',
        ]));

    }
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

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Date;

    /**
     * @ORM\Column(type="integer")
     */
    private $horstaxe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomprojet;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getHorstaxe(): ?int
    {
        return $this->horstaxe;
    }

    public function setHorstaxe(int $horstaxe): self
    {
        $this->horstaxe = $horstaxe;

        return $this;
    }

    public function getNomprojet(): ?string
    {
        return $this->nomprojet;
    }

    public function setNomprojet(?string $nomprojet): self
    {
        $this->nomprojet = $nomprojet;

        return $this;
    }
}
