<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SectionTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateSection()
    {
        $admin = factory('App\User', 'admin')->create();
        $section = factory('App\Section')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $section) {
            $browser->loginAs($admin)
                ->visit(route('admin.sections.index'))
                ->clickLink('Add new')
                ->select("course_id", $section->course_id)
                ->type("title", $section->title)
                ->type("descripition", $section->descripition)
                ->attach("image", base_path("tests/_resources/test.jpg"))
                ->press('Save')
                ->assertRouteIs('admin.sections.index')
                ->assertSeeIn("tr:last-child td[field-key='course']", $section->course->title)
                ->assertSeeIn("tr:last-child td[field-key='title']", $section->title)
                ->assertSeeIn("tr:last-child td[field-key='descripition']", $section->descripition)
                ->assertVisible("img[src='" . env("APP_URL") . "/" . env("UPLOAD_PATH") . "/thumb/" . \App\Section::first()->image . "']");
        });
    }

    public function testEditSection()
    {
        $admin = factory('App\User', 'admin')->create();
        $section = factory('App\Section')->create();
        $section2 = factory('App\Section')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $section, $section2) {
            $browser->loginAs($admin)
                ->visit(route('admin.sections.index'))
                ->click('tr[data-entry-id="' . $section->id . '"] .btn-info')
                ->select("course_id", $section2->course_id)
                ->type("title", $section2->title)
                ->type("descripition", $section2->descripition)
                ->attach("image", base_path("tests/_resources/test.jpg"))
                ->press('Update')
                ->assertRouteIs('admin.sections.index')
                ->assertSeeIn("tr:last-child td[field-key='course']", $section2->course->title)
                ->assertSeeIn("tr:last-child td[field-key='title']", $section2->title)
                ->assertSeeIn("tr:last-child td[field-key='descripition']", $section2->descripition)
                ->assertVisible("img[src='" . env("APP_URL") . "/" . env("UPLOAD_PATH") . "/thumb/" . \App\Section::first()->image . "']");
        });
    }

    public function testShowSection()
    {
        $admin = factory('App\User', 'admin')->create();
        $section = factory('App\Section')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $section) {
            $browser->loginAs($admin)
                ->visit(route('admin.sections.index'))
                ->click('tr[data-entry-id="' . $section->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='course']", $section->course->title)
                ->assertSeeIn("td[field-key='title']", $section->title)
                ->assertSeeIn("td[field-key='descripition']", $section->descripition);
        });
    }

}
