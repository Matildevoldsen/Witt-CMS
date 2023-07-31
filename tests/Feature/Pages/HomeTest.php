<?php

namespace Tests\Feature\Pages;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_home_page_renders()
    {
        $this->get(route('home'))
            ->assertInertia(fn(Assert $page) => $page
                ->component('Home')
                ->has('cart')
            );
    }
}
