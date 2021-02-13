<?php

namespace App\Http\Controllers;

use App\Rules\dnivalidator;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FormularioController extends Controller
{
    function formulario(Request $request){
        $client = new Client(['verify' => false]);
        $response = $client->request('POST', 'http://dev-dental.mulhacensoft.com/ihealth/pais/get');
        $countrysJson = json_decode($response->getBody(), true);

        return view("formulario", [
            'countrys' => $countrysJson
        ]);
    }

    function storeResponse(Request $request)
    {
        $input = $request->all();
        foreach($input['country'] as $country){
            $countryArray = explode('-', $country);
            if($countryArray[0] == 1) {
                $rules = [
                    'dni' => new dnivalidator(),
                ];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator);
                }
            }
            $arrayFormated[$countryArray[0]] = $countryArray[1];
        }

        return view("response", [
            'countrys' => $arrayFormated,
            'nombre' => $input['nombre'],
            'apellidos' => $input['apellidos'],
            'dni' => $input['dni']
        ]);;
    }
}
