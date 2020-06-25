<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (request $request) {
		 $path = public_path('documents');
		 $files = collect(File::files($path)); //->where ( 'filename', 'LIKE', '%sachin%' )
		 $page = (int) $request->input('page') ?: 1;
		 $onPage = 2;
		 $slice = $files->slice(($page-1)* $onPage, $onPage);
    	 $paginator = new \Illuminate\Pagination\LengthAwarePaginator($slice, $files->count(), $onPage);
     
 		 $paginator->setPath('');

        return view('filelisting.list')->with('files', $paginator);


});

Route::any('/search', function (request $request) {
 		$q = $request->input( 'q' );
		$path = public_path('documents');
		if($q != ""){
			$files = collect(preg_grep('%'.$q.'%', File::files($path))); 
			$page = (int) $request->input('page') ?: 1;
			$onPage = 2;
			$slice = $files->slice(($page-1)* $onPage, $onPage);
	    	$paginator = new \Illuminate\Pagination\LengthAwarePaginator($slice, $files->count(), $onPage);
	     
			$paginator->appends ( array (
			    'q' => $request->input( 'q' ) 
			  ) );
			$paginator->setPath('');
			 
	  			return view ( 'filelisting.list' )->with('files', $paginator)->withQuery ( $q );
	 		 
		}else{
			 $files = collect(File::files($path)); //->where ( 'filename', 'LIKE', '%sachin%' )
			 $page = (int) $request->input('page') ?: 1;
			 $onPage = 2;
			 $slice = $files->slice(($page-1)* $onPage, $onPage);
	    	 $paginator = new \Illuminate\Pagination\LengthAwarePaginator($slice, $files->count(), $onPage);
	     
	 		 $paginator->setPath('');

       		 return view('filelisting.list')->with('files', $paginator);
		}
	 
  
} );

Route::post('/upload', function (Request $request) {
 

	$request->validate([
            'file' => 'required|mimes:txt,doc,docx,pdf,png,jpeg,jpg,gif|max:2048',
        ]);
  
        $fileName = time().'.'.$request->file->extension();  
        $request->file->move(public_path('documents'), $fileName);
   

   
        return back()
            ->with('success','You have successfully upload file.')
            ->with('file',$fileName);
		


});

Route::post('/delete', function (request $request) {

				  $filename= $request->input('id');

				return    unlink(public_path('documents').'/'.$filename);
		
    	   
});
