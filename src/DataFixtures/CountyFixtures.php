<?php

/*
 * Copyright (c) 2019 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace App\DataFixtures;

use App\Entity\County;
use App\Util\SerializedObjectCsvParser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CountyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $parser = new SerializedObjectCsvParser('fixtures/county.csv', County::class);
        $counties = $parser->parse();

        foreach ($counties as $county) {
            $manager->persist($county);
        }

        $manager->flush();
    }
}
