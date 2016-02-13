<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller {

    public function getQuestion($id) {
        return Question::findOrFail($id);
    }

    public function addQuestion(Request $request) {
        $validator = \Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
        ]);

        if ($validator->passes()) {
            $question = Question::where('question_id', $request->input('question'))->where('answer', $request->input('answer'))->first();

            if ($question) {
                $question->increment('agreements');
            } else {
                Question::create([
                    'question_id' => $request->input('question'),
                    'answer' => $request->input('answer')
                ]);
            }

            return response("OK", 200);
        }

        return response("Bad", 400);

    }

}
