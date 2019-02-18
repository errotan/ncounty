<?php

/*
 * Copyright (c) 2019 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class AbstractEntitySaveService
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
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var \HTMLPurifier
     */
    protected $purifier;

    /**
     * @var Object
     */
    protected $entity;

    public function __construct(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, \HTMLPurifier $purifier)
    {
        $this->request = $request;
        $this->em = $em;
        $this->validator = $validator;
        $this->purifier = $purifier;
    }

    public function save()
    {
        $this->prepare();
        $this->validate();
        $this->store();
    }

    abstract protected function prepare(): void;

    protected function validate(): void
    {
        $errors = $this->validator->validate($this->entity);

        if (0 !== count($errors)) {
            $errorsString = '';

            foreach ($errors as $error) {
                $errorsString .= '['.$error->getPropertyPath().']: '.$error->getMessage();
            }

            throw new BadRequestHttpException($errorsString);
        }
    }

    protected function store(): void
    {
        $this->em->persist($this->entity);
        $this->em->flush();
    }
}
