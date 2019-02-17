<?php

/*
 * Copyright (c) 2019 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace App\Controller;

use App\Entity\City;
use App\Service\CityCreateService;
use App\Service\CityDeleteService;
use App\Service\CityUpdateService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CityController extends AbstractFOSRestController implements ClassResourceInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * @Get("/cities/county/{countyId}",name="get_city_county",requirements={"countyId"="\d+"})
     */
    public function getCountyAction(int $countyId): Response
    {
        $cities = $this->em->getRepository(City::class)->findBy(['county' => $countyId]);
        $view = $this->view($cities);

        return $this->handleView($view);
    }

    /**
     * @Get("/cities/{id}",name="get_city",requirements={"id"="\d+"})
     */
    public function getAction(City $city): Response
    {
        $view = $this->view($city);

        return $this->handleView($view);
    }

    /**
     * @RequestParam(name="name")
     * @RequestParam(name="countyId",requirements="\d+")
     */
    public function postAction(Request $request): Response
    {
        (new CityCreateService($request, $this->em, $this->validator))->save();

        $view = $this->view(['success' => true]);

        return $this->handleView($view);
    }

    /**
     * @Put("/cities/{id}",name="put_city",requirements={"id"="\d+"})
     */
    public function putAction(Request $request, int $id): Response
    {
        (new CityUpdateService($request, $this->em, $this->validator))->save();

        $view = $this->view(['success' => true]);

        return $this->handleView($view);
    }

    /**
     * @Delete("/cities/{id}",name="delete_city",requirements={"id"="\d+"})
     */
    public function deleteAction(Request $request, int $id): Response
    {
        (new CityDeleteService($request, $this->em))->delete();

        $view = $this->view(['success' => true]);

        return $this->handleView($view);
    }
}
