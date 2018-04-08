<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LessonTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateLesson()
    {
        $admin = factory('App\User', 'admin')->create();
        $lesson = factory('App\Lesson')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $lesson) {
            $browser->loginAs($admin)
                ->visit(route('admin.lessons.index'))
                ->clickLink('Add new')
                ->select("course_id", $lesson->course_id)
                ->type("title", $lesson->title)
                ->type("slug", $lesson->slug)
                ->attach("lesson_image", base_path("tests/_resources/test.jpg"))
                ->type("short_text", $lesson->short_text)
                ->type("full_text", $lesson->full_text)
                ->type("position", $lesson->position)
                ->check("free_lesson")
                ->check("published")
                ->select("section_id", $lesson->section_id)
                ->press('Save')
                ->assertRouteIs('admin.lessons.index')
                ->assertSeeIn("tr:last-child td[field-key='course']", $lesson->course->title)
                ->assertSeeIn("tr:last-child td[field-key='title']", $lesson->title)
                ->assertSeeIn("tr:last-child td[field-key='slug']", $lesson->slug)
                ->assertVisible("img[src='" . env("APP_URL") . "/" . env("UPLOAD_PATH") . "/thumb/" . \App\Lesson::first()->lesson_image . "']")
                ->assertSeeIn("tr:last-child td[field-key='short_text']", $lesson->short_text)
                ->assertSeeIn("tr:last-child td[field-key='full_text']", $lesson->full_text)
                ->assertSeeIn("tr:last-child td[field-key='position']", $lesson->position)
                ->assertChecked("free_lesson")
                ->assertChecked("published")
                ->assertSeeIn("tr:last-child td[field-key='section']", $lesson->section->title);
        });
    }

    public function testEditLesson()
    {
        $admin = factory('App\User', 'admin')->create();
        $lesson = factory('App\Lesson')->create();
        $lesson2 = factory('App\Lesson')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $lesson, $lesson2) {
            $browser->loginAs($admin)
                ->visit(route('admin.lessons.index'))
                ->click('tr[data-entry-id="' . $lesson->id . '"] .btn-info')
                ->select("course_id", $lesson2->course_id)
                ->type("title", $lesson2->title)
                ->type("slug", $lesson2->slug)
                ->attach("lesson_image", base_path("tests/_resources/test.jpg"))
                ->type("short_text", $lesson2->short_text)
                ->type("full_text", $lesson2->full_text)
                ->type("position", $lesson2->position)
                ->check("free_lesson")
                ->check("published")
                ->select("section_id", $lesson2->section_id)
                ->press('Update')
                ->assertRouteIs('admin.lessons.index')
                ->assertSeeIn("tr:last-child td[field-key='course']", $lesson2->course->title)
                ->assertSeeIn("tr:last-child td[field-key='title']", $lesson2->title)
                ->assertSeeIn("tr:last-child td[field-key='slug']", $lesson2->slug)
                ->assertVisible("img[src='" . env("APP_URL") . "/" . env("UPLOAD_PATH") . "/thumb/" . \App\Lesson::first()->lesson_image . "']")
                ->assertSeeIn("tr:last-child td[field-key='short_text']", $lesson2->short_text)
                ->assertSeeIn("tr:last-child td[field-key='full_text']", $lesson2->full_text)
                ->assertSeeIn("tr:last-child td[field-key='position']", $lesson2->position)
                ->assertChecked("free_lesson")
                ->assertChecked("published")
                ->assertSeeIn("tr:last-child td[field-key='section']", $lesson2->section->title);
        });
    }

    public function testShowLesson()
    {
        $admin = factory('App\User', 'admin')->create();
        $lesson = factory('App\Lesson')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $lesson) {
            $browser->loginAs($admin)
                ->visit(route('admin.lessons.index'))
                ->click('tr[data-entry-id="' . $lesson->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='course']", $lesson->course->title)
                ->assertSeeIn("td[field-key='title']", $lesson->title)
                ->assertSeeIn("td[field-key='slug']", $lesson->slug)
                ->assertSeeIn("td[field-key='short_text']", $lesson->short_text)
                ->assertSeeIn("td[field-key='full_text']", $lesson->full_text)
                ->assertSeeIn("td[field-key='position']", $lesson->position)
                ->assertNotChecked("free_lesson")
                ->assertNotChecked("published")
                ->assertSeeIn("td[field-key='section']", $lesson->section->title);
        });
    }

}
