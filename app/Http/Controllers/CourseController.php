<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();
        $size = $request->query('size');
        $courses = $query->get();
        if ($size) {
            $courses = $query->paginate($size);
        }
        return CourseResource::collection($courses);
    }

    public function getByName($name)
    {
        $course = Course::where('name', $name)->first();
        if (! $course) {
            return response()->json(['error' => 'name'], 400);
        }
        return new CourseResource($course);
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "name" => 'required|string|min:2|max:50|unique:courses'
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        $courses = Course::create($request->all());

        if ($courses) {
            return new CourseResource($courses);
        }

        throw new Exception('Unexpected Error');
    }

    public function show(Course $course)
    {
        return new CourseResource($course);
    }


    public function update(Request $request, Course $course)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "id" => 'required|numeric|unique:courses'. $course->id,
                "name" => 'required|string|min:2|max:50|unique:courses',
            ]);

        if ($validate->fails())
        {
            return response()->json($validate->failed(), 400);
        }

        if ($course->update($request->all())) {
            $course->flash();
            return new CourseResource($course);
        }
        throw new Exception('Unexpected Error');
    }

    public function destroy(Course $course)
    {
        if ($course->delete())
        {
            return ['data' => $course->id];
        }
        throw new Exception('Unexpected Error');
    }
}
