<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Laravel\Ulid\Concerns\HasUlid;

/**
 * Class TestModel
 *
 * @package     Tests
 * @author      Oanh Nguyen <oanhnn.bk@gmail.com>
 * @license     The MIT license
 */
class TestModel extends Model
{
    use HasUlid;
}
