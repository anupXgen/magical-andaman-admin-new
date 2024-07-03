<?php

namespace Modules\Faq\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Faq;
use App\Models\Faq_category;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:activity-list|activity-create|activity-edit|activity-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:activity-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:activity-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:activity-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Faq::orderBy('id', 'DESC')->with('faq_cat')->where('delete', 0)->where('status', 0);

        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('faq.questions', 'LIKE', "%$search%");
            $data->orwhere('faq.answers', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('faq::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }

    /**
     * Show the form for creating a new resource.
     */ 
    public function create()
    {
        $faq_category= Faq_category::where('delete', 0)->where('status', 0)->get();
        return view('faq::create', compact('faq_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'questions' => 'required',
            'answers' => 'required',
            'faq_category' => 'required',
            'related_module' => 'required',
        ]);
        $input = $request->all();
        $insertarray['questions'] = $input['questions'];
        $insertarray['answers'] = $input['answers'];
        $insertarray['faq_category'] = $input['faq_category'];
        $insertarray['related_module'] = $input['related_module'];
        $result = Faq::create($insertarray);
        $inserted_id = $result->id;
      
        return redirect()->route('faq.index')
            ->with('success', 'Faq created successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $faq = Faq::find($id)->with('faq_cat')->first()->toArray();
        return view('faq::show', compact('faq'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $faq = Faq::find($id);
        $faq_category= Faq_category::where('delete', 0)->where('status', 0)->get();
        return view('faq::edit', compact('faq', 'faq_category'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'questions' => 'required',
            'answers' => 'required',
            'faq_category' => 'required',
            'related_module' => 'required',
            //'banner_img' => 'required'
        ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        $insertarray['questions'] = $input['questions'];
        $insertarray['answers'] = $input['answers'];
        $insertarray['faq_category'] = $input['faq_category'];
        $insertarray['related_module'] = $input['related_module'];
        $result = Faq::find($id)->update($insertarray);
       
        return redirect()->route('faq.index')
            ->with('success', 'Faq created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $insertarray['delete'] = 1;
        Faq::where('id', $id)->update($insertarray);
       
        return redirect()->route('faq.index')
            ->with('success', 'Faq deleted successfully');
    }

}
