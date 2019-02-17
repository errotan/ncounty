<?php

/*
 * Copyright (c) 2019 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractDeleteService
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var Object
     */
    protected $entity;

    public function __construct(Request $request, EntityManagerInterface $em)
    {
        $this->request = $request;
        $this->em = $em;
    }

    public function delete()
    {
        $this->load();
        $this->remove();
    }

    abstract protected function load(): void;

    protected function remove(): void
    {
        $this->em->remove($this->entity);
        $this->em->flush();
    }
}
