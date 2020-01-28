<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return view('studentform')->with('students', $students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $students = new Student;

        $students->fname = $request->input('fname');
        $students->lname = $request->input('lname');
        $students->course = $request->input('course');
        $students->section = $request->input('section');

        $students->save();
        return $students;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $students = Student::find($id);

        $students->fname = $request->input('fname');
        $students->lname = $request->input('lname');
        $students->course = $request->input('course');
        $students->section = $request->input('section');

        $students->save();
        return $students;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $students = Student::find($id);
        $students->delete();
        return $students;
    }

    public function refresh()
    {
        $students = Student::all();
        return $students;
    }
}
