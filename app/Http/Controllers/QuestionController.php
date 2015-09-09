<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class QuestionController extends Controller
{

    public function getQuestion($id)
    {
        return Question::findOrFail($id);
    }

    public function getQuestionByText(Request $request)
    {
        return Question::where('question', md5($request->input('question')))->first();
    }

    public function addQuestion(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
        ]);

        if($validator->passes())
        {
            $question = Question::where('question', md5($request->input('question')))->first();

            if($question)
            {
                $question->agreements++;

                $question->save();
            } else
            {
                Question::create([
                    'question' => md5($request->input('question')),
                    'answer' => $request->input('answer')
                ]);
            }
        }
    }

}
