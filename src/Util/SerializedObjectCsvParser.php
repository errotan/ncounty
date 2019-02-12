<?php

/*
 * Copyright (c) 2019 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace App\Util;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * Reads csv file and deserializes lines as array of objects.
 */
final class SerializedObjectCsvParser
{
    /**
     * @var string
     */
    private $csvPath;

    /**
     * @var string
     */
    private $baseObjectName;

    /**
     * @var string
     */
    private $csvContent;

    public function __construct(string $csvPath, string $baseObjectName)
    {
        $this->csvPath = $csvPath;
        $this->baseObjectName = $baseObjectName;
    }

    /**
     * @return array
     */
    public function parse(): array
    {
        $this->readCsv();

        return $this->parseToArray();
    }

    /**
     * @return void
     */
    private function readCsv(): void
    {
        $this->csvContent = file_get_contents($this->csvPath);
    }

    /**
     * @return array
     */
    private function parseToArray(): array
    {
        $encoders = [new CsvEncoder()];
        $normalizers = [new ArrayDenormalizer(), new GetSetMethodNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->deserialize($this->csvContent, $this->baseObjectName.'[]', 'csv');
    }
}
