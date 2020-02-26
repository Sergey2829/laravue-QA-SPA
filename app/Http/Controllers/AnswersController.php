<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Question $question)
    {
        $question->answers()->create($request->validate([
            'body' => 'required'
        ]) + ['user_id' => Auth::id()]);

        return back()->with('success', 'Your answer has been submitted successfully');

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        if($request->expectsJson()) {
            return response()->json([
                'message' => 'Answer has been updated',
                'body_html' => $answer->body_html
            ]);
        }

//        return redirect()->route('questions.show', $question->slug)->with('success', 'Answer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();

        if(\request()->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been removed'
            ]);
        }

        return back()->with('success', 'Your answer has been removed');
    }
}
