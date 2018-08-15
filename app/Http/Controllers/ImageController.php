<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->validate($request, [
            'url' => 'required'
        ]);
        header('Content-type: image/jpeg');
        header("Cache-Control: private, max-age=108000, pre-check=108000");
        header("Pragma: private");
        header("Expires: " . date(DATE_RFC822,strtotime(" 60 day")));
        try {
            echo file_get_contents($request->get('url'));
        } catch (\Exception $e) {
            echo '';
        }
    }
}
