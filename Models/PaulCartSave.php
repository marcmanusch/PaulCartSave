<?php

namespace PaulCartSave\Models;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_plugin_save_cart")
 * @ORM\Entity(repositoryClass="Repository")
 */
class PaulCartSave extends ModelEntity
{
    /**
     * Primary Key - autoincrement value
     *
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $hash
     *
     * @ORM\Column(name="hash", type="text", nullable=false)
     */
    private $hash;

    /**
     * @var string $articles
     *
     * @ORM\Column(name="articles", type="text", nullable=false)
     */
    private $articles;

    /**
     * @var string $quantity
     * @ORM\Column(name="quantity", type="text", nullable=false)
     */
    private $quantity;

    /**
     * @var mixed $date;
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param string $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity(string $quantity)
    {
        $this->quantity = $quantity;
    }

}
