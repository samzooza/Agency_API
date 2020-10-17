<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Sample;

class SampleController extends Controller
{
    #region Constructors
    public function __construct(){ }
    #endregion

    #region Public Methods
    #region Gets
    public function get(){
        return response()->json(Sample::all());
    }

    public function getById($id){
        return response()->json(Sample::find($id));
    }
    #endregion

    #region Create/Update/Delete
    public function create(Request $request){
        $this->validation($request);

        // create record
        $article = Sample::create($request->all());
        return response()->json($article, 201);
    }

    public function update($id, Request $request){
        $this->validation($request);

        // update record
        $article = Sample::findOrFail($id);
        $article->update($request->all());
        return response()->json($article, 200);
    }

    public function delete($id){
        // delete record
        Sample::findOrFail($id)->delete();
        return response('Deleted successfully', 200);
    }
    #endregion
    #endregion

    #region Private Methods
    #region Validations
    private function validation($request){
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]); 
    }
    #endregion
    #endregion
}
