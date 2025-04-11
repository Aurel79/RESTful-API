<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return new StudentResource($students, 'Success', 'List of students');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|filled',
            'name' => 'required|filled',
            'email' => 'required|filled',
            'address' => 'required|filled',
            'phone' => 'required|filled',
        ]);

        if ($validator->fails()) {
            return new studentResource(null, 'Failed', $validator->errors());
        }

        $student = Student::create($request->all());
        return new StudentResource($student, 'Success', 'Student created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if($student) {
            return new StudentResource($student, 'Success', 'Student found');
        } else {
            return new StudentResource(null, 'Failed', 'Student not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        if($student) {
            $student->update($request->all());
            return new StudentResource($student, 'Success', 'Student updated successfully');
        } else {
            return new StudentResource(null, 'Failed', 'Student not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        if($student) {
            $student->delete();
            return new StudentResource($student, 'Success', 'Student deleted successfully');
        } else {
            return new StudentResource(null, 'Failed', 'Student not found');
        }
    }
}
