<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class TestTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateTest()
    {
        $admin = factory('App\User', 'admin')->create();
        $test = factory('App\Test')->make();

        $relations = [
            factory('App\Question')->create(), 
            factory('App\Question')->create(), 
        ];

        $this->browse(function (Browser $browser) use ($admin, $test, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.tests.index'))
                ->clickLink('Add new')
                ->select("course_id", $test->course_id)
                ->select("lesson_id", $test->lesson_id)
                ->type("title", $test->title)
                ->type("description", $test->description)
                ->select('select[name="questions[]"]', $relations[0]->id)
                ->select('select[name="questions[]"]', $relations[1]->id)
                ->check("published")
                ->press('Save')
                ->assertRouteIs('admin.tests.index')
                ->assertSeeIn("tr:last-child td[field-key='course']", $test->course->title)
                ->assertSeeIn("tr:last-child td[field-key='lesson']", $test->lesson->title)
                ->assertSeeIn("tr:last-child td[field-key='title']", $test->title)
                ->assertSeeIn("tr:last-child td[field-key='description']", $test->description)
                ->assertSeeIn("tr:last-child td[field-key='questions'] span:first-child", $relations[0]->question)
                ->assertSeeIn("tr:last-child td[field-key='questions'] span:last-child", $relations[1]->question)
                ->assertChecked("published");
        });
    }

    public function testEditTest()
    {
        $admin = factory('App\User', 'admin')->create();
        $test = factory('App\Test')->create();
        $test2 = factory('App\Test')->make();

        $relations = [
            factory('App\Question')->create(), 
            factory('App\Question')->create(), 
        ];

        $this->browse(function (Browser $browser) use ($admin, $test, $test2, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.tests.index'))
                ->click('tr[data-entry-id="' . $test->id . '"] .btn-info')
                ->select("course_id", $test2->course_id)
                ->select("lesson_id", $test2->lesson_id)
                ->type("title", $test2->title)
                ->type("description", $test2->description)
                ->select('select[name="questions[]"]', $relations[0]->id)
                ->select('select[name="questions[]"]', $relations[1]->id)
                ->check("published")
                ->press('Update')
                ->assertRouteIs('admin.tests.index')
                ->assertSeeIn("tr:last-child td[field-key='course']", $test2->course->title)
                ->assertSeeIn("tr:last-child td[field-key='lesson']", $test2->lesson->title)
                ->assertSeeIn("tr:last-child td[field-key='title']", $test2->title)
                ->assertSeeIn("tr:last-child td[field-key='description']", $test2->description)
                ->assertSeeIn("tr:last-child td[field-key='questions'] span:first-child", $relations[0]->question)
                ->assertSeeIn("tr:last-child td[field-key='questions'] span:last-child", $relations[1]->question)
                ->assertChecked("published");
        });
    }

    public function testShowTest()
    {
        $admin = factory('App\User', 'admin')->create();
        $test = factory('App\Test')->create();

        $relations = [
            factory('App\Question')->create(), 
            factory('App\Question')->create(), 
        ];

        $test->questions()->attach([$relations[0]->id, $relations[1]->id]);

        $this->browse(function (Browser $browser) use ($admin, $test, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.tests.index'))
                ->click('tr[data-entry-id="' . $test->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='course']", $test->course->title)
                ->assertSeeIn("td[field-key='lesson']", $test->lesson->title)
                ->assertSeeIn("td[field-key='title']", $test->title)
                ->assertSeeIn("td[field-key='description']", $test->description)
                ->assertSeeIn("tr:last-child td[field-key='questions'] span:first-child", $relations[0]->question)
                ->assertSeeIn("tr:last-child td[field-key='questions'] span:last-child", $relations[1]->question)
                ->assertNotChecked("published");
        });
    }

}
