<?php

namespace Tests\Concerns;

use Carbon\Carbon;
use DateTimeInterface;

/**
 * Trait WithFakeDateTime
 *
 * Help test with fake Carbon
 *
 * @package     Tests\Concerns
 * @author      Oanh Nguyen <oanhnn.bk@gmail.com>
 * @license     The MIT license
 */
trait WithFakeDateTime
{
    /**
     * Setting up faked DateTime.
     *
     * @return void
     */
    protected function setUpFakeDateTime()
    {
        $date = null;
        if (method_exists($this, 'fakeDateTime')) {
            $date = $this->fakeDateTime();
        } elseif (property_exists($this, 'fakeDateTime')) {
            $date = $this->fakeDateTime;
        }

        if (is_int($date)) {
            $date = Carbon::createFromTimestamp($date);
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        if ($date instanceof DateTimeInterface) {
            Carbon::setTestNow($date);
        }
    }
}
