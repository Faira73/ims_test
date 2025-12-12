<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function index (){
        $categories = Category::pluck('name', 'id');
        $questions = QuestionBank::all();
        return view('questions.index', compact('questions', 'categories'));
    }

    public function store(Request $request){
        
        $validate = $request->validate([
            'text'=>['required', 'string'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        $validate['created_by_id'] = Auth::id();
        QuestionBank::create($validate);

        return redirect()->back()->with('success', 'Question added successfully!');
    }
}