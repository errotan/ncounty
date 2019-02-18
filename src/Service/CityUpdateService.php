<?php

/*
 * Copyright (c) 2019 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace App\Service;

use App\Entity\City;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CityUpdateService extends AbstractEntitySaveService
{
    protected function prepare(): void
    {
        $this->entity = $this->em->getRepository(City::class)->find($this->request->attributes->get('id'));

        if (null === $this->entity) {
            throw new BadRequestHttpException('Invalid city id specified!');
        }

        $this->entity->setName($this->purifier->purify($this->request->request->get('name')));
    }
}
