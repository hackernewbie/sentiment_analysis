<?php

namespace App\Http\Controllers;

use Sentiment\Analyzer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function analyse(Request $request){
        $analyzer = new Analyzer();
        $output_text = $analyzer->getSentiment($request->text_to_analyze);

        $mood        = '';

        if($output_text['neg'] > 0 && $output_text['neg'] < 0.49){
            $mood = 'Somewhat Negative ';
        }
        elseif($output_text['neg'] > 0.49){
            $mood = 'Mostly Negative';
        }

        if($output_text['neu'] > 0 && $output_text['neg'] < 0.49){
            $mood = 'Somewhat neutral ';
        }
        elseif($output_text['neu'] > 0.49){
            $mood = 'Mostly neutral';
        }

        if($output_text['pos'] > 0 && $output_text['pos'] < 0.49){
            $mood = 'Somewhat positive ';
        }
        elseif($output_text['pos'] > 0.49){
            $mood = 'Mostly positive';
        }
        //dd('Negative: ' . $output_text['neg'] . ' Positive: ' . $output_text['pos'] . ' Neutral: '. $output_text['neu']);
        return view('welcome')->with('text',$mood);
    }
}
