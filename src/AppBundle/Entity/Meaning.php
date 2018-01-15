<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Meaning
 *
 * @ORM\Table(name="meaning")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeaningRepository")
 */
class Meaning
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
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="style", type="string", length=255, nullable=true)
     */
    private $style;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="meanings")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=false, onDelete="cascade")
     */
    private $article;

    /**
     * @var MeaningContext[]
     *
     * @ORM\OneToMany(targetEntity="MeaningContext", mappedBy="meaning", cascade={"persist"})
     */
    private $contexts;

    /**
     * Meaning constructor.
     */
    public function __construct()
    {
        $this->contexts = new ArrayCollection();
    }

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
     * Set code
     *
     * @param string $code
     *
     * @return Meaning
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set style
     *
     * @param string $style
     *
     * @return Meaning
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Meaning
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
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Meaning
     */
    public function setArticle(\AppBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Add context
     *
     * @param MeaningContext $context
     *
     * @return Meaning
     */
    public function addContext(MeaningContext $context)
    {
        $this->contexts[] = $context->setMeaning($this);

        return $this;
    }

    /**
     * Remove context
     *
     * @param MeaningContext $context
     */
    public function removeContext(MeaningContext $context)
    {
        $this->contexts->removeElement($context);
    }

    /**
     * Get contexts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContexts()
    {
        return $this->contexts;
    }
}
