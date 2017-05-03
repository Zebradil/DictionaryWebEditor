<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeaningContext
 *
 * @ORM\Table(name="meaning_context")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeaningContextRepository")
 */
class MeaningContext
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @var Meaning
     *
     * @ORM\ManyToOne(targetEntity="Meaning", inversedBy="contexts")
     * @ORM\JoinColumn(name="meaning_id", referencedColumnName="id", nullable=false)
     */
    private $meaning;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return MeaningContext
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return MeaningContext
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set meaning
     *
     * @param \AppBundle\Entity\Meaning $meaning
     *
     * @return MeaningContext
     */
    public function setMeaning(\AppBundle\Entity\Meaning $meaning = null)
    {
        $this->meaning = $meaning;

        return $this;
    }

    /**
     * Get meaning
     *
     * @return \AppBundle\Entity\Meaning
     */
    public function getMeaning()
    {
        return $this->meaning;
    }
}
