<?php


namespace App\Http\Controllers;



use App\Http\Controllers\lib\PlagiumResolver;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PlagiumController extends Controller
{
    public function index()
    {
        return view("index");
    }

    public function check(Request $request)
    {
        ini_set('max_execution_time', 300);
        $plagium = new PlagiumResolver();


        $resultLink = new Collection();
        $resultPercent = new Collection();

        //Sometimes when the intire paragraph end with '.' it put paragraph with length 0 and this modify the percentage
        $subtraction =0;

        //We're separating the text by Full Stop
        $lines = $plagium->splitByFullStop($request->text);

        //A loop to search all Frases separated by Full Stop
        // Takes paragraph by paragraph

        $sum =0;
        foreach($lines as $line){
            if(strlen($line) ==0 || $line ==' '){
                $subtraction++;
                continue;
            }

            $links = $plagium->searchGoogleAPI($line);

            $percentage =0;
            $usedlink ="";

            if(count($links) ==1){
                foreach ($links as $text=>$link){
                    $percentage =100;
                    $usedlink =$link;
                }
            }else{
                foreach ($links as $text=>$link){
                    $text = str_replace('\n', '', $text);
                    $newpercentage = $plagium->verifyPlagium($line, $text);
                    if($newpercentage>$percentage){
                        $percentage =$newpercentage;
                        $usedlink = $link;
                    }
                }
            }

            $sum+=$percentage;
            $percentage = round($percentage, 2);
            $resultPercent->put($line, $percentage);

            $usedlink =urldecode($usedlink);

            $designedlink = $usedlink;
            $designedlink =str_replace('http://','',$designedlink);
            $designedlink =str_replace('https://','',$designedlink);
            $designedlink =str_replace('/',' > ',$designedlink);


            $resultLink->put($usedlink,$designedlink);


        }
        $percentage = $sum/(count($lines)-$subtraction);
        return view('result', ['resultLinks'=>$resultLink, 'resultPercentage'=>$resultPercent, 'totalpercentage'=>$percentage, 'count'=>1, 'count1'=>1, 'try'=>false]);

    }
}
