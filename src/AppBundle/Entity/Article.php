<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="grammar", type="string", length=255, nullable=true)
     */
    private $grammar;

    /**
     * @var Dictionary
     *
     * @ORM\ManyToOne(targetEntity="Dictionary", inversedBy="articles")
     * @ORM\JoinColumn(name="dictionary_id", referencedColumnName="id", nullable=false)
     */
    private $dictionary;

    /**
     * @var Meaning[]
     *
     * @ORM\OneToMany(targetEntity="Meaning", mappedBy="article", cascade={"persist"})
     */
    private $meanings;

    /**
     * @var ArticleComment[]
     *
     * @ORM\OneToMany(targetEntity="ArticleComment", mappedBy="article", cascade={"persist"})
     */
    private $comments;

    /**
     * @var ArticleLink[]
     *
     * @ORM\OneToMany(targetEntity="ArticleLink", mappedBy="article", cascade={"persist"})
     */
    private $links;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->meanings = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->links = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
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
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set grammar
     *
     * @param string $grammar
     *
     * @return Article
     */
    public function setGrammar($grammar)
    {
        $this->grammar = $grammar;

        return $this;
    }

    /**
     * Get grammar
     *
     * @return string
     */
    public function getGrammar()
    {
        return $this->grammar;
    }

    /**
     * Set dictionary
     *
     * @param Dictionary $dictionary
     *
     * @return Article
     */
    public function setDictionary(Dictionary $dictionary = null)
    {
        $this->dictionary = $dictionary;

        return $this;
    }

    /**
     * Get dictionary
     *
     * @return Dictionary
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * Add meaning
     *
     * @param Meaning $meaning
     *
     * @return Article
     */
    public function addMeaning(Meaning $meaning)
    {
        $this->meanings[] = $meaning->setArticle($this);

        return $this;
    }

    /**
     * Remove meaning
     *
     * @param Meaning $meaning
     */
    public function removeMeaning(Meaning $meaning)
    {
        $this->meanings->removeElement($meaning);
    }

    /**
     * Get meanings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeanings()
    {
        return $this->meanings;
    }

    /**
     * Add comment
     *
     * @param ArticleComment $comment
     *
     * @return Article
     */
    public function addComment(ArticleComment $comment)
    {
        $this->comments[] = $comment->setArticle($this);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param ArticleComment $comment
     */
    public function removeComment(ArticleComment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add link
     *
     * @param ArticleLink $link
     *
     * @return Article
     */
    public function addLink(ArticleLink $link)
    {
        $this->links[] = $link->setArticle($this);

        return $this;
    }

    /**
     * Remove link
     *
     * @param ArticleLink $link
     */
    public function removeLink(ArticleLink $link)
    {
        $this->links->removeElement($link);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLinks()
    {
        return $this->links;
    }
}
