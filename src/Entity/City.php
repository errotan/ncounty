<?php

/*
 * Copyright (c) 2019 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string",nullable=false)
     */
    private $name;

    /**
     * @var County
     *
     * @ORM\ManyToOne(targetEntity="County")
     * @ORM\JoinColumn(name="countyId",nullable=false,onDelete="CASCADE")
     */
    private $county;

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of county
     *
     * @return County
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set the value of county
     *
     * @param County $county
     *
     * @return self
     */
    public function setCounty(County $county)
    {
        $this->county = $county;

        return $this;
    }
}
