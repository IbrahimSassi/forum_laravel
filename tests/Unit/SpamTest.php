<?php

namespace Tests\Unit;

use Tests\TestCase;

class SpamTest extends TestCase
{


    /** @test */
    public function is_validates_spam()
    {
        $spam = new \App\Inspections\Spam();
        $this->assertFalse($spam->detect('Innocent reply here'));
    }

    /** @test */
    public function checks_for_any_key_held_down()
    {
        $spam = new \App\Inspections\Spam();
        $this->expectException(\Exception::class);
        $spam->detect('hello wordls aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
    }

}
