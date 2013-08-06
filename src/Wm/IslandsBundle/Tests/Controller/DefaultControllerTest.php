<?php

namespace Wm\IslandsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();

        $json = $client->request('POST', '/oprokidnev.ru.default', array(
            'phone'=>'+7-912-22-22-222',
            'name'=>'Опрокиднев Андрей Алексеевич',
        ));

        $this->assertTrue(is_array(json_decode($json,true)));
    }

}
