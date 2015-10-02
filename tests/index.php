<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../src/C2iS/Component/Json/JsonIterator.php';

    echo "<pre>";

    $data = exampleData(false);
    echo 'Data : '.$data.'<br />';

    $iter = new C2iS\Component\Json\JsonIterator($data,"$..name");

    echo 'JsonPath : '.$iter->getJsonPath().'<br \>';

    var_dump($iter->current());

    for($i=0; $i<$iter->count()-1; $i++)
    {
        $iter->next();
        var_dump($iter->current());
    }

    echo 'count : '.$iter->count().'<br />';


    echo "</pre>";

    function exampleData($asArray = true)
    {
        $data = [
            'name'        => 'Major League Baseball',
            'abbr'        => 'MLB',
            'conferences' => [
                [
                    'name'  => 'Western Conference',
                    'abbr'  => 'West'
                ],
                [
                    'name'  => 'Eastern Conference',
                    'abbr'  => 'East'
                ],
                [
                    'name'  => 'nortern Conference',
                    'abbr'  => 'north'
                ],
                [
                    'name'  => 'bobtern Conference',
                    'abbr'  => 'bob'
                ]
            ]
        ];

        return $asArray ? $data : json_encode($data);

    }

?>