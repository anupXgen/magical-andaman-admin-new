<?php

namespace Modules\Faqs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index(Request $request)
    // {
    //      //DB::enableQueryLog();

    //    $data = DB::table('faq')->where('status','=',0)->get();

    //      if (!empty($request->input('search_txt'))) {
    //          $search = $request->input('search_txt');
    //          $data->where('faq.questions', 'LIKE', "%$search%");
    //          $data->orwhere('faq.answers', 'LIKE', "%$search%");
    //      }
    //      $data = $data->paginate(config('app.pagination_count'));
    //      //dd(DB::getQueryLog());
    //      return view('faqs::index', compact('data'))
    //          ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    // }

    public function index(Request $request)
    {
        $search_text = $request->input('search_txt');
        $perPage = 5;

        if ($search_text) {
            $data = DB::table('faq')
                ->where('status', 0)
                ->where(function ($query) use ($search_text) {
                    $query->where('questions', 'like', '%' . $search_text . '%')->orWhere('answers', 'like', '%' . $search_text . '%');
                })
                ->paginate($perPage);
        } else {
            $data = DB::table('faq')->where('status', 0)->orderBy('id', 'DESC')->paginate($perPage);
        }

        return view('faqs::index', compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faqs::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'questions' => 'required',
            'answers' => 'required',
            'related_module' => 'required',
        ]);

        $input = $request->all();
        $insertarray = [
            'questions' => $input['questions'],
            'answers' => $input['answers'],
            'related_module' => $input['related_module'],
        ];

        DB::table('faq')->insert($insertarray);

        return redirect()->route('faqs.index')->with('success', 'Faq created successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $faq = DB::table('faq')->find($id)->get()->toArray();
        return view('faqs::show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $faq = DB::table('faq')->where('id', $id)->first();
        return view('faqs::edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'questions' => 'required',
            'answers' => 'required',
            'related_module' => 'required',
        ]);

        $input = $request->all();
        $updateArray = [
            'questions' => $input['questions'],
            'answers' => $input['answers'],
            'related_module' => $input['related_module'],
        ];

        DB::table('faq')->where('id', $id)->update($updateArray);
        return redirect()->route('faqs.index')->with('success', 'Faq updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $faq =  DB::table('faq')->where('id', $id);
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'Faq deleted successfully');
    }
}
