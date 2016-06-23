<?php

include '../../vendor/autoload.php';


$docBlock = <<<TEXT
    /**
    * @Ion\Orm\Column('string', length=15)
    * @Ion\Validation\Assert\Email
    *
    * @Ion\Serializer\Group({'first', 'second'})
    */
    
    some stuff thats not interesting..
TEXT;

$reader = new \Ion\Reader\StringReader($docBlock);

$reader->readSpaces();

if (!$reader->peekString('/**'))
    exit('No docblock!');

$reader->consume();

$docBlock = $reader->readUntil(function($tok) {

    return $tok === '*/';
}, 2);

$reader = new \Ion\Reader\StringReader($docBlock);

$annotations = [];
while ($reader->hasLength()) {

    if ($id = $reader->readIdentifier('@', '\\')) {

        $args = [];
        if ($reader->peekChar('(')) {

            $reader->consume();
            $expr = $reader->readExpression([')']);

            $args[] = $expr;

            if (!$reader->peekChar(')'))
                die('Unclosed parameter block for '.$id);

            $reader->consume();
        }

        $annotations[$id] = $args;
    }

    $reader->consume(1);
}

var_dump($annotations);