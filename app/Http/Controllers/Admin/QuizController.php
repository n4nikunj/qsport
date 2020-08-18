<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Quiz;


class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:quiz-list', ['only' => ['index','show']]);
        $this->middleware('permission:quiz-create', ['only' => ['create','store']]);
        $this->middleware('permission:quiz-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('quiz.plural');
        $levels = level::all();
        $quiz = Quiz::all();
        // print_r($level);die;
        return view('admin.quiz.index',compact('quiz', 'levels', 'page_title'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('quiz.add_new');
        $levels = level::all();
        return view('admin.quiz.create', compact('page_title', 'levels'));
    }

    /**
     * Store a newly created item in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $validator= $request->validate([
            'question:ar' => 'required|max:150',
            'question:en' => 'required|max:150',
            'option1:ar' => 'required|max:150',
            'option1:en' => 'required|max:150',
            'option2:ar' => 'required|max:150',
            'option2:en' => 'required|max:150',
            'option3:ar' => 'required|max:150',
            'option3:en' => 'required|max:150',
            'option4:ar' => 'required|max:150',
            'option4:en' => 'required|max:150',
            'level_id' => 'required',
            'correct_answer' => 'required',
        ]);

        // checking no of question limit for selected Level
        $level = Level::find($request->level_id);
        $no_of_questions = Quiz::where(['level_id'=> $request->level_id, 'status' => 'active'])->count();
        if($level->no_of_question <= $no_of_questions){
            return redirect()->route('quiz.create')->with('error',trans('quiz.level_noq_limit_crossed'));
        }

        $data = $request->all();
        $quiz = Quiz::create($data);
   
        if($quiz) {
            return redirect()->route('quiz.index')->with('success',trans('quiz.added'));
        } else {
            return redirect()->route('quiz.index')->with('error',trans('common.something_went_wrong'));
        }
    }

    /**
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $page_title = trans('quiz.show');
        $quiz = Quiz::find($id);
        $levels = level::all();
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.quiz.show',compact('quiz', 'page_title', 'levels'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = trans('quiz.edit');
        $quiz = Quiz::find($id);
        $levels = level::all();
        return view('admin.quiz.edit',compact('quiz', 'page_title', 'levels'));
    }

    /**
     * Update the specified itm in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator= $request->validate([
            'question:ar' => 'required|max:150',
            'question:en' => 'required|max:150',
            'option1:ar' => 'required|max:150',
            'option1:en' => 'required|max:150',
            'option2:ar' => 'required|max:150',
            'option2:en' => 'required|max:150',
            'option3:ar' => 'required|max:150',
            'option3:en' => 'required|max:150',
            'option4:ar' => 'required|max:150',
            'option4:en' => 'required|max:150',
            'level_id' => 'required',
            'correct_answer' => 'required',
        ]);

        $data = $request->all();
        $quiz = Quiz::find($id);

        if($quiz->update($data)){
            return redirect()->route('quiz.index')->with('success',trans('quiz.updated'));
        } else {
            return redirect()->route('quiz.index')->with('error',trans('common.something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $quiz = Quiz::find($id);

        if($quiz->delete()){
            return redirect()->route('quiz.index')->with('success',trans('quiz.deleted'));
        }else{
            return redirect()->route('quiz.index')->with('error',trans('common.something_went_wrong'));
        }
    }
}
