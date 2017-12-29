<?php
/**
 * Created by PhpStorm.
 * User: Mrs Trang
 * Date: 25/12/2017
 * Time: 04:59
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Input;
use App\User;
class SearchController extends Controller
{

    public function autocomplete(Request $request)
    {
        $term = $request->term;
        $input = explode(",",$term);
        $len = count($input);
        $findElement = trim($input[$len-1]," ");

       // var_dump($findElement);
        $results = array();
        $queries = User:: where('name', 'LIKE', '%' . $findElement . '%')
            ->take(5)->get();

        foreach ($queries as $query => $value) {
            $results[] = ['id' => $value->id, 'value' => $value->name."[".$value->user_id."]"];
        }
        return response()->json($results);
    }
}
