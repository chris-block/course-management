<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Section
 *
 * @package App
 * @property string $course
 * @property string $title
 * @property text $descripition
 * @property string $image
*/
class Section extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'descripition', 'image', 'course_id'];
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCourseIdAttribute($input)
    {
        $this->attributes['course_id'] = $input ? $input : null;
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withTrashed();
    }
    
}
