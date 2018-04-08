<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

/**
 * Class Lesson
 *
 * @package App
 * @property string $course
 * @property string $title
 * @property string $slug
 * @property string $lesson_image
 * @property text $short_text
 * @property text $full_text
 * @property integer $position
 * @property tinyInteger $free_lesson
 * @property tinyInteger $published
 * @property string $section
*/
class Lesson extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['title', 'slug', 'lesson_image', 'short_text', 'full_text', 'position', 'free_lesson', 'published', 'course_id', 'section_id'];
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCourseIdAttribute($input)
    {
        $this->attributes['course_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPositionAttribute($input)
    {
        $this->attributes['position'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setSectionIdAttribute($input)
    {
        $this->attributes['section_id'] = $input ? $input : null;
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withTrashed();
    }
    
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id')->withTrashed();
    }
    
}
