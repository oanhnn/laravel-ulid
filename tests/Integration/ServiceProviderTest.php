<?php

namespace Tests\Integration;

use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

/**
 * Class ServiceProviderTest
 *
 * @package     Tests\Integration
 * @author      Oanh Nguyen <oanhnn.bk@gmail.com>
 * @license     The MIT license
 */
class ServiceProviderTest extends TestCase
{
    /**
     * Tests service provider register blueprint macro
     *
     * @test
     */
    public function it_provides_blueprint_macro()
    {
        $this->assertTrue(Blueprint::hasMacro('ulid'));
    }
}
