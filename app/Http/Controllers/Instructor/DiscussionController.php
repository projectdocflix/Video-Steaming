<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiscussionController extends Controller
{
    public function index(Request $request)
    {
        $data['navDiscussionActiveClass'] = "active";

        $courseIds = Discussion::leftJoin('course_instructor', function($join) {
            $join->on('discussions.course_id', '=', 'course_instructor.course_id')
                ->where('course_instructor.status', '=', 1);
        })
            ->join('courses', 'courses.id', '=', 'discussions.course_id')
            ->where(function ($q){
                $q->where('courses.user_id', auth()->id())
                    ->orWhere('course_instructor.instructor_id', auth()->id());
            })
            ->whereNull('parent_id')
            ->where('discussions.status', 1)
            ->NotView()
            ->select('discussions.course_id')
            ->groupBy('discussions.course_id') // Get distinct course_id values
            ->pluck('course_id')
            ->toArray();


        if($request->ajax()){
            $data['courses'] = Course::whereIn('id', $courseIds)->where('title', 'LIKE', "%{$request->search_title}%")->get();
            return view('instructor.discussion.render-discussion-course-list', $data);
        }

        $data['first_course_id'] = Course::whereIn('id', $courseIds)->select('id')->first();
        $data['courses'] = Course::whereIn('id', $courseIds)->get();

        return view('instructor.discussion.index', $data);
    }

    public function courseDiscussionList(Request $request)
    {
        $data['discussions'] = Discussion::whereCourseId($request->course_id)->whereNull('parent_id')->active()->NotView()->get();
        return view('instructor.discussion.render-discussion-list', $data);
    }

    public function instructorCourseDiscussionReply(Request $request, $discussion_id)
    {
        $discussion = new Discussion();
        $discussion->user_id = Auth::id();
        $discussion->course_id = $request->course_id;
        $discussion->comment = $request->commentReply;
        $discussion->status = 1;
        $discussion->parent_id = $discussion_id;
        $discussion->comment_as = 1;
        $discussion->save();

        Discussion::where('id', $discussion_id)
            ->update([
                'view' => 1
            ]);
        Discussion::where('parent_id', $discussion_id)->update([
           'view' => 1
        ]);

        $data['discussions'] = Discussion::whereCourseId($request->course_id)->whereNull('parent_id')->active()->NotView()->get();
        return view('instructor.discussion.render-discussion-list', $data);
    }
}
