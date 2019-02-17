<?php

/*
 * Copyright (c) 2019 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace App\Service;

use App\Entity\City;
use App\Entity\County;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CityCreateService extends AbstractSaveService
{
    protected function prepare(): void
    {
        $this->entity = new City();
        $this->entity->setName(htmlspecialchars($this->request->request->get('name'))); // TODO: remove script tag only

        $county = $this->em->getRepository(County::class)->find($this->request->request->get('countyId'));

        if (null === $county) {
            throw new BadRequestHttpException('Invalid county id specified!');
        }

        $this->entity->setCounty($county);
    }
}
