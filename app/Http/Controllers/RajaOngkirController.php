<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{
  public static function get_province()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: ".env('RAJAONGKIR_API')
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    return $response;
  }
  public function get_city(Request $request)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$request->id",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: ".env('RAJAONGKIR_API')
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    $result = json_decode($response, true)['rajaongkir']['results'];
    return response($result, 200)
      ->header("Content-Type", "application/json");
  }
  public function get_cost(Request $request)
  {
    $dataCost = $request->all()["dataCost"];
    $results = collect([]);
    foreach($dataCost["dataOrigin"] as $origin) {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$origin["origin_code"]."&destination=".$dataCost["destination"]."&weight=".$origin["origin_weight"]."&courier=".$dataCost['courier'],
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: ".env('RAJAONGKIR_API')
        ),
      ));
  
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl); 
      $temp = collect(json_decode($response, true)["rajaongkir"]["results"])->collapse();
      $temp["origin_name"] = $origin["origin_name"];
      $results->push($temp);
    }
    
    
// $results = [
//     [
//         "code" => "pos",
//         "name" => "POS Indonesia (POS)",
//         "costs" => [
//             [
//                 "service" => "REG",
//                 "description" => "Pos Reguler",
//                 "cost" => [["value" => 14500, "etd" => "2 HARI"]]
//             ],
//             [
//                 "service" => "KARGO",
//                 "description" => "Pos Kargo",
//                 "cost" => [["value" => 55000, "etd" => "7 -14 HARI"]]
//             ]
//         ],
//         "origin_name" => "Kota Bandung"
//     ],
//     [
//         "code" => "pos",
//         "name" => "POS Indonesia (POS)",
//         "costs" => [
//             [
//                 "service" => "REG",
//                 "description" => "Pos Reguler",
//                 "cost" => [["value" => 14500, "etd" => "2 HARI"]]
//             ],
//             [
//                 "service" => "KARGO",
//                 "description" => "Pos Kargo",
//                 "cost" => [["value" => 60000, "etd" => "7-14 HARI"]]
//             ]
//         ],
//         "origin_name" => "Kota Sukabumi"
//     ],
//     [
//         "code" => "pos",
//         "name" => "POS Indonesia (POS)",
//         "costs" => [
//             [
//                 "service" => "REG",
//                 "description" => "Pos Reguler",
//                 "cost" => [["value" => 15000, "etd" => "3 HARI"]]
//             ]
//         ],
//         "origin_name" => "Kabupaten Garut"
//     ]
// ];

    $services = collect($results)
    ->flatMap(function ($item) {
        return collect($item['costs'])
            ->map(function ($cost) use ($item) {
                return [
                    'service' => $cost['service'],
                    'description' => $cost["description"],
                    'origins' => [
                        [
                            'origin_name' => $item['origin_name'],
                            'value' => $cost['cost'][0]['value'],
                            'estimasi' => $cost['cost'][0]['etd']
                        ]
                    ]
                ];
            });
    })->groupBy('service')
    ->map(function ($item) {
        return [
            'service' => $item[0]['service'],
            'description' => $item[0]['description'],
            'origins' => $item->flatMap(function ($i) {
                return $i['origins'];
            })
        ];
    })->values();
    //Di filter karena tidak semua origin memiliki paket tersebut
    $max_count_origin = $services->map(fn($d) => count($d["origins"]))->max();
    $final_result = collect($services)->filter(fn($d) => count($d["origins"]) == $max_count_origin)->map(function( $item, $key) { 
      $item["total_cost"] = collect($item["origins"])->sum("value");
      return $item;
    })->toArray();
    return response($final_result, 200)
      ->header("Content-Type", "application/json");
  }
}


  // $services = [
//   [
//     "service" => "Pos Reguler",
//     "origins" => [
//       ["origin_name" => "Kota Bandung", "value" => 14500, "estimasi" => "2 HARI"],
//       ["origin_name" => "Kota Sukabumi", "value" => 14500, "estimasi" => "2 HARI"],
//       ["origin_name" => "Kabupaten Garut", "value" => 15000, "estimasi" => "3 HARI"],

//     ],
//       "total_cost" => 44000
//   ],
// ]
