<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Metal;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Carbon\CarbonPeriod;

class ShowController extends Controller
{
    use GeneralTrait;

    protected $metal_names;
    const oz_to_gm = "28.3495";

    public function __construct()
    {
        $this->metal_names = config("yaffet.metal_name");
    }

	
	private function getPricePerformance($request , $code , $unit){
		$date = date('Y-m-d');
		$dates = $this->getStartAndEndDates($date);
		
		$data = array();
		
		//day 
		
		 $day_metals = Metal::select("metalName", "metalPrice", "date")
                ->where("metalName", $code)
			  // ->whereBetween("date", [$dates['day']['start'], $dates['day']['end']])
			  // ->orderBy('metalPrice', 'desc')
                ->latest()
                ->first();
		
		
				$price = ($unit == 'gm') ? $day_metals->metalPrice / self::oz_to_gm :$day_metals->metalPrice ;
		         $data['day']['price'] = $price;
		         $data['day']['value'] = $price;
		         $data['day']['percent'] = $price;
		
		
		
		//week
		 $week_metals = Metal::select("metalName", "metalPrice", "date")
                ->where("metalName", $code)
			   ->whereBetween("date", [$dates['week']['start'], $dates['week']['end']])
			   ->orderBy('metalPrice', 'desc')
                ->latest()
                ->first();
						$price = ($unit == 'gm') ? $week_metals->metalPrice / self::oz_to_gm :$week_metals->metalPrice ;

		         $data['week']['price'] = $price;
		         $data['week']['value'] = $price;
		         $data['week']['percent'] = $price;
		
		
		
		//month
		 $month_metals = Metal::select("metalName", "metalPrice", "date")
                ->where("metalName", $code)
			   ->whereBetween("date", [$dates['month']['start'], $dates['month']['end']])
			   ->orderBy('metalPrice', 'desc')
                ->latest()
                ->first();
						$price = ($unit == 'gm') ? $month_metals->metalPrice / self::oz_to_gm :$month_metals->metalPrice ;

		         $data['month']['price'] = $price;
		         $data['month']['value'] = $price;
		         $data['month']['percent'] = $price;
		
		
		//year
		 $year_metals = Metal::select("metalName", "metalPrice", "date")
                ->where("metalName", $code)
			   ->whereBetween("date", [$dates['year']['start'], $dates['year']['end']])
			   ->orderBy('metalPrice', 'desc')
                ->latest()
                ->first();
				$price = ($unit == 'gm') ? $year_metals->metalPrice / self::oz_to_gm :$year_metals->metalPrice ;

		         $data['year']['price'] = $price;
		         $data['year']['value'] = $price;
		         $data['year']['percent'] = $price;
		
		
		
		//all
		
		 $all_metals = Metal::select("metalName", "metalPrice", "date")
                ->where("metalName", $code)
			   ->orderBy('metalPrice', 'desc')
                ->latest()
                ->first();
				$price = ($unit == 'gm') ? $all_metals->metalPrice / self::oz_to_gm :$all_metals->metalPrice ;

		         $data['all']['price'] = $price;
		         $data['all']['value'] = $price;
		         $data['all']['percent'] = $price;
		
		
		return $data;
	}
		
	private function getDataSet($request , $code  , $unit){
		$period = $request->get("period", "day");
		
		$prices = ['price'];
		

		if($period != 'all'){
			
		
		
		$date = date('Y-m-d');
		$dates = $this->getStartAndEndDates($date);
		
		
        $start_date = $dates[$period]['start'];
        $end_date = $dates[$period]['end'];
		
		}else{
			$days = ['days'];
			  $results = Metal::where("metalName", $code)
				->distinct()
                ->get();
			foreach($results as $result){
				
				  array_push($days , $result->date);
				
				
				$price = ($unit == 'gm') ? $result->metalPrice / self::oz_to_gm :$result->metalPrice ;
					
				
				
				array_push($prices , $price);

		}
			return [$days , $prices];
		}
		
			
		if($period == 'day'){
			 $days = ['times'];
			  $results = Metal::where("metalName", $code)
                  ->whereBetween("date", [$start_date, $end_date])
				  
				->distinct()->get();
			foreach($results as $result){
				
				$timeString = \Carbon\Carbon::parse($result->date)->format('H:i:s');
	            array_push($days , $timeString);
				
				$price = ($unit == 'gm') ? $result->metalPrice / self::oz_to_gm :$result->metalPrice ;
					
				
				array_push($prices , $price);

				
			}
			
			return [$days , $prices];
			
		
		}
		
		
		if($period == 'week' || $period == 'month'){
			 $days = ['days'];
			  $results = Metal::where("metalName", $code)
                ->whereBetween("date", [$start_date, $end_date])
				->distinct()
                ->get();
			foreach($results as $result){
				
				  array_push($days , $result->date);
				
				
				$price = ($unit == 'gm') ? $result->metalPrice / self::oz_to_gm :$result->metalPrice ;
					
				
				array_push($prices , $price);


				
			}
			
			return [$days , $prices];
		}
		
	
		
		return [];
		
		
		
	}
	
    public function getMetalPriceHistory(Request $request)
    {
        $metalName = $request->get("metal", "gold");
        $metal_names = config("yaffet.metal_name");
		
	
        $start_date = $request->get('start_date' , null);
        $end_date = $request->get('end_date' , null);
		
        if (!in_array($metalName, $metal_names)) {
            return $this->returnError("404", "invalid metals");
        }
        $code = config("yaffet.metal_codes")[$metalName];

        if ($start_date == null || $end_date == null) {
            $result = Metal::where("metalName", $code)->get();
        } else {
			
            $startDate = Carbon::createFromFormat(
                "Y-m-d",
                $start_date
            )->startOfDay();
			
            $endDate = Carbon::createFromFormat("Y-m-d", $end_date)->endOfDay();

            $result = Metal::where("metalName", $code)
                ->whereBetween("created_at", [$startDate, $endDate])
                ->get();
        }

        if ($result) {
            return $this->returnData(
                $metalName,
                $result,
                "There are all Prices of " . $metalName . " for a period time",
                "201"
            );
        } else {
            return $this->returnError("404", "there is no metals");
        }
    }

    private function getStartAndEndDates($date)
    {
        $day_start = date("Y-m-d 00:00:00", strtotime($date));
        $day_end = date("Y-m-d 23:59:59", strtotime($date));

        $week_start = date(
            "Y-m-d 00:00:00",
            strtotime("last Monday", strtotime($date))
        );
        $week_end = date(
            "Y-m-d 23:59:59",
            strtotime("next Sunday", strtotime($date))
        );

        $month_start = date("Y-m-01 00:00:00", strtotime($date));
        $month_end = date("Y-m-t 23:59:59", strtotime($date));

        $year_start = date("Y-01-01 00:00:00", strtotime($date));
        $year_end = date("Y-12-31 23:59:59", strtotime($date));

        $dates = [
            "day" => ["start" => $day_start, "end" => $day_end],
            "week" => ["start" => $week_start, "end" => $week_end],
            "month" => ["start" => $month_start, "end" => $month_end],
            "year" => ["start" => $year_start, "end" => $year_end]
        ];

        return $dates;
    }
    // get last price for metals ( GOLD , SELVER , PLATINUM )
    public function getLastprice(Request $request)
    {
        $metalName = $request->get("metal", null);

        $unit = $request->get("unit", "oz");

        $currency = $request->get("currency", "USD");

		
        
		
		

        if ($metalName == null || !in_array($metalName, $this->metal_names)) {
            $metals = Metal::select("metalName", "metalPrice", "date")
                ->latest()
                ->take(3)
                ->get();
            $response = [];
            if ($unit == "gm") {
                foreach ($metals as $metal) {
                    array_push($response, [
                        "metalName" => $metal->metalName,
                        "metalPrice" => $metal->metalPrice / self::oz_to_gm,
                        "date" => $metal->date,
                    ]);
                }

                return $response;
            }

            return $metals;
        } else {
            $metalcode = config("yaffet.metal_codes")[$metalName];
			
			$dataset = $this->getDataSet($request , $metalcode , $unit);
			$performance = $this->getPricePerformance($request , $metalcode , $unit);
	
            $metals = Metal::select("metalName", "metalPrice", "date" , "id")
                ->where("metalName", $metalcode)
                ->latest()
                ->first();
			
			
			$yesterday = date('Y-m-d',strtotime("-1 days"));
			//$yesterday = "2023-02-13";
		//	dd($yesterday);
            $highestPrice = Metal::whereDate('date', $yesterday)
            ->orderBy('metalPrice', 'desc')
			->where("metalName", $metalcode)
            ->first();
			
			$last_price = $highestPrice->metalPrice;
			$current_price = $metals->metalPrice;
			
			$status = 'N/A';
			if($last_price > $current_price){
				$status = "DOWN";
			}else{
				$status = "UP";
			}
			
			if($last_price == $current_price){
				$status = 'EQUAL';
			}
			
		
			
            if ($unit == "gm") {
				
				$value = ($last_price - $current_price  ) / self::oz_to_gm;
				
				
				$current_price = $current_price / self::oz_to_gm;
                return [
                    "metalName" => $metals->metalName,
                    "metalPrice" => $metals->metalPrice / self::oz_to_gm,
                    "date" => $metals->date,
					"status"=>$status,
					"value"=>$value,
					"percent"=> ($value / $current_price) * 100,
					"dataset"=>$dataset,
					'performance'=>$performance
                ];
            }else{
				$value = $last_price - $current_price ;
				return [
					
					 "metalName" => $metals->metalName,
                    "metalPrice" => $metals->metalPrice,
                    "date" => $metals->date,
					"status"=>$status,
					"percent"=> ($value / $current_price) * 100,
						"dataset"=>$dataset,
					'performance'=>$performance
					];
				
			}

            return $metals;
        }
    }

    // get historical price for all metals
    public function getHistPrice($metalName)
    {
        $metal_names = config("yaffet.metal_name");
        if (!in_array($metalName, $metal_names)) {
            return $this->returnError("404", "invalid metals");
        }
        $code = config("yaffet.metal_codes")[$metalName];

        $result = Metal::where("metalName", $code)->get();
        if ($result) {
            return $this->returnData(
                $metalName,
                $result,
                "There are all Prices of " . $metalName . " for a period time",
                "201"
            );
        } else {
            return $this->returnError("404", "there is no metals");
        }
    }

    // get last price for different currency
    public function getLastCurrency()
    {
        $lastCurrency = Currency::select("currency_code", "price_rate")
            ->latest()
            ->get()
            ->unique("currency_code");
        if ($lastCurrency) {
            return $lastCurrency;
        } else {
            return "there is no different currency";
        }
    }

    public function getLatestMetalPrice(Request $request)
    {
        $metal_names = config("yaffet.metal_name");

        $metalName = $request->get("metal", "gold");
        $currencyName = $request->get("currency", "USD");
        if (!in_array($metalName, $metal_names)) {
            return $this->returnError("404", "invalid metals");
        }
        $metalcode = config("yaffet.metal_codes")[$metalName];

        $currency = $request->get("currency", "gold");
        $url = config("yaffet.saveLastMetals") . "&base=$currency";

        $response = Http::get($url);
        return json_decode($response, true);
    }

    //get last price based on date

    public function getMetalBasedOnDate(Request $request)
    {
        $metal_names = config("yaffet.metal_name");

        $metalName = $request->get("metal", "gold");
        $currencyName = $request->get("currency", "USD");
        if (!in_array($metalName, $metal_names)) {
            return $this->returnError("404", "invalid metals");
        }
        $metalcode = config("yaffet.metal_codes")[$metalName];

        $url =
            config("yaffet.saveHistoricalMetals") .
            "&start_date=" .
            $request->get("start_date") .
            "&end_date=" .
            $request->get("end_date") .
            "&symbols=" .
            $metalcode .
            "&base=$currencyName";

        $response = Http::get($url);
        return json_decode($response, true);
        dd($metal);

        if ($metal["success"]) {
            foreach ($metal["rates"] as $key => $value) {
                $metal = new Metal();
                $metal->metalPrice = 1 / $value[$metalcode];
                $metal->date = $key . " 12:00:00";
                $metal->metalName = $metalcode;
                $metal->save();
            }
            return $this->returnSuccessMessage(
                "Metals saved successfully",
                "201"
            );
        } else {
            return $this->returnError("404", "error api");
        }
    }
	
	
	public function getHighestPrice(Request $request){
		
		
		
		$metal = $request->get('metal','gold');
		
		if($metal == 'silver'){
			$date = new \DateTime('2011-04-06 00:00:00', new \DateTimeZone('America/New_York'));
		
				
		return array(
		'price'=>49.51,
		'metal'=>'silver',
		'unit'=>'oz',
			'currency'=>"USD",
		'date'=> $date->format(' F, Y ')
		);
				
		}
		$date = new \DateTime('2020-08-06 00:00:00', new \DateTimeZone('America/New_York'));
		return array(
		'price'=>2070.05,
	     'metal'=>'gold',
			'currency'=>"USD",
		'unit'=>'oz',
		'date'=> $date->format('F j, Y ')
		);
	}
}
