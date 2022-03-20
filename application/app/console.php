<?php

require_once __DIR__ . '/../vendor/autoload.php';

$class  = $argv[1];
$params = json_decode($argv[2], true);

try {
    $objectReflection = new ReflectionClass($class);
    $object           = $objectReflection->newInstanceArgs();

    if (!$object instanceof \App\Infrastructure\Command\AbstractCommand) {
        throw new \Exception('Class must be instance of \App\Infrastructure\Command\AbstractCommand');
    }

    $method = new ReflectionMethod($object, 'run');
    $result = $method->invoke($object, $params);

    echo json_encode($result);
} catch (ReflectionException|\Exception $e) {
    echo $e->getMessage();
    exit(1);
}