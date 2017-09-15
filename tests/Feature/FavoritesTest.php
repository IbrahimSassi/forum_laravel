<?php

namespace Tests\Feature;

use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */
    function guestsCanNotFavoriteAnything()
    {

        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');

    }

    /** @test */
    public function anAuthenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);

    }
    
    
    /** @test */
    function anAuthentitedUserMayOnlyFavoriteOnce(){
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);

    }
}
