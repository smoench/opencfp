<?php

namespace OpenCFP\Test\Http\Controller\Admin;

use OpenCFP\Domain\Model\User;
use OpenCFP\Test\RefreshDatabase;
use OpenCFP\Test\WebTestCase;

/**
 * Class SpeakersControllerTest
 *
 * @package OpenCFP\Test\Http\Controller\Admin
 * @group db
 */
class SpeakersControllerTest extends WebTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function viewActionDisplaysCorrectly()
    {
        $user = factory(User::class, 1)->create()->first();

        $this->asAdmin()
            ->get('/admin/speakers/' . $user->id)
            ->assertSee($user->first_name)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function viewActionRedirectsOnNonUser()
    {
        $this->asAdmin()
            ->get('/admin/speakers/7679')
            ->assertNotSee('Other Information')
            ->assertRedirect()
            ->assertFlashContains('Error');
    }
}
