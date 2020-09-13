<?php


namespace App\Http\Controllers\lib;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Collection;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;

class PlagiumResolver
{
   private $googleLink ='https://search.yahoo.com/search?p=';

    /**
     * The Yahoo Search are made by
     * replacing the 'space' with the '+'
     * e.g: @https://www.yahoo.com/search?q=how+to+program+in+php
     */
    public function makeGoogleSearchType($line)
    {
        str_replace(' ', '+', $line);
        return  '"'.$line.'"';
    }


    public function splitByFullStop($text)
    {
        //Here im removing all paragraph
        $text = str_replace('\n', ' ', $text);

        //Here i'm separating By full Stops
        $lines = explode('.', $text);
        return $lines;
    }

    public function searchGoogleAPI($text)
    {
        $fulltext = new LaravelGoogleCustomSearchEngine();
        $parameters = array(
            'start' => 1, // start from the 10th results,
            'num' => 10, // number of results to get, 15 is maximum and also default value
            'lr'=>'lang_en',
            'exactTerms'=>$text,
        );

        $number =0;
        try {
            $results ='Not';
            while (is_string($results) && $number<8){

                $collection = new Collection();
                $results = $fulltext->getResults('"'.$text.'"', $parameters,$number);

                foreach ($results as $key=>$value){
                    $snippet =$value->snippet;
                    $link = $value->link;

                    return [$snippet=>$link];
                }
                if($collection->isEmpty()){
                    $parameters = array(
                        'start' => 1, // start from the 10th results,
                        'num' => 10, // number of results to get, 15 is maximum and also default value
                        'lr'=>'lang_en'
                    );
                    $results = $fulltext->getResults( $text, $parameters, $number);
                    foreach ($results as $key=>$value){
                        $snippet =$value->snippet;
                        $link = $value->link;
                        $collection->put($snippet, $link);
                    }
                }

                $number++;
            }

        } catch (\Exception $e) {
            return view('result',['try'=>true]);
        }
        //$collection = $this->removeGoogleYoutubeLinks($collection);
        return $collection;
    }

    public function plagium($paragrah, $text)
    {
        if(strpos($text, $paragrah) !== FALSE){
            return 100;
        }
        else
            return 0;
    }
/**
    public function searchYahoo($text)
    {
        $seachtext = $this->makeGoogleSearchType($text);
        $goutteClient = new Client();
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'verify' => false,

        ));
        $goutteClient->setClient($guzzleClient);

        $crawler = $goutteClient->request('GET', $this->googleLink . $seachtext);
        $links=collect($crawler->filter('div[class="dd algo algo-sr Sr"]')->each(function ($node) {

            try{
                $text = $node->filter('p')->text();
                $link = $node->filter('a')->attr('href');
                dump($text);
                return [$text=>$link];
            }catch (\InvalidArgumentException $exception){
                $exception->getMessage();
            }
            return null;
        })) ;

        $links = $links->reject(function ($key, $value){
           return empty($key);
        });
        $links = $links->collapse();
        //Removing Google and Youtube Links

        return $links;
    }

    public function takeAbsoluteLink($absoluteLink)
    {
        $stingSeparator = '=';
        $stingAfterSA = 'sa=';

         * All the links that come from Google
         * It cames in format
         * /url?q=https:://realLink&sa
         * Here im taking the index of '=' to take only
         * https://realLink&sa

        $urlindex = strpos($absoluteLink,$stingSeparator );
        $absoluteLink = substr($absoluteLink, $urlindex+1);

        // And here cut the part since &sa= and take the entire link
        $urlindex = strpos($absoluteLink,$stingAfterSA );
        $link = substr($absoluteLink, 0, $urlindex-5);
        return $link;

    }
*/
    /*
     * This method is used to remove the
     * Youtube and Google Links
     * Because when you make a search there's some Google links
     * Like @accounts.google.com/ServiceLogin%
     * Or Youtube video Links
     * @return Collection
     */
    public function removeGoogleYoutubeLinks($links)
    {
        $wordGoogle = 'google';
        $wordTube = 'youtube';
        $updatedLinks = new Collection();

        foreach ($links as $text=>$link){
            //If it's not a Google or Youtube link
            if(strpos($link, $wordGoogle) !== FALSE || strpos($link, $wordTube) !== FALSE)
                continue;
            $updatedLinks->put($text, $link);
        }

        return $updatedLinks;

    }

    public function verifyPlagium($paragraph, $text)
    {
        // Minimum percentage
        $minpecenting =0;
        //Minimum Plagio
        $minPecentingPlagio = 40;

        $plagiumVick = $this->plagium($paragraph, $text);
        $paragraph = str_replace('"', '',$paragraph);
        if($plagiumVick ==100)
            return $plagiumVick;

        if($text == "" || $text ==" " || strlen($text) ==0)
            return $minpecenting;


        $lenghtWords = $this->countWords($paragraph);
        if($lenghtWords ==0)
            return $minpecenting;

        $arrayWordsPragraph  = $this->words($paragraph);
        $matchedWods =0;
        //First check if you have 50% of the words searched in the text
        for($i=0; $i<$lenghtWords; $i++){
            if(!empty($arrayWordsPragraph[$i]))
                if(strpos($text, $arrayWordsPragraph[$i]) !==false)
                    $matchedWods++;
        }

        $percentage = ($matchedWods*100)/$lenghtWords;

        /**
         * If there is at least 40% of the words in the text,
         * there is no way to have been plagiarism.
         * This 40% can be changed by changing the
         * @var  $minPecentingPlagio
         * */

        if($percentage<$minPecentingPlagio)
            return $percentage;

        //Now we know that it passed 40%, now let's check if it is really plagiarism
        /**
         * Oh my God
         * This check is being done at a time when I don't have many ideas
         * What I'm going to do here only God knows
         * I will group the tokens in sequence and find out if there are any strings found
         *
         * First, group sequentially and then jump one by one
         * */

        $percentageSequencial = $this->verifyPlagiumSequencial($arrayWordsPragraph, $lenghtWords, $text);
        $percentageJumpWord = $this->verifyPlagiumJumping($arrayWordsPragraph, $lenghtWords, $text);

        if($percentageSequencial>$percentageJumpWord)
            return $percentageSequencial;
        else
            return $percentageJumpWord;
    }

    /**
     * @param array
     * @param String
     * @return integer
     * */

    private function verifyPlagiumSequencial($paragraphArray, $lenghtArray, $text)
    {

        $i=0;
        $newarray = array();
        while ($i<$lenghtArray-1){
            $newarray[$i] = $paragraphArray[$i].' '.$paragraphArray[$i+1];
            $i++;
        }

        $matched =0;
        for ($j=0; $j<count($newarray); $j++){
            if(strpos($text, $newarray[$j])!== FALSE)
                $matched++;
        }
        if($matched ==0)
            return 0;

        $percentage = ($matched*100)/count($newarray);
        return $percentage;


    }
    private function verifyPlagiumJumping($paragraphArray, $lenghtArray, $text)
    {
        $i=0;
        $newarray = array();
        while ($i<$lenghtArray-2){
            $newarray[$i] = $paragraphArray[$i].' '.$paragraphArray[$i+2];
            $i++;
        }

        $matched =0;
        for ($j=0; $j<count($newarray); $j++){
            if(strpos($text, $newarray[$j])!== FALSE)
                $matched++;
        }

        if($matched ==0)
            return 0;

        $percentage = ($matched*100)/count($newarray);
        return $percentage;
    }

    /**
     * @param String
     * @return integer
     * */
    public function countWords($text)
    {
        $arrayWords = explode(' ', $text);
        return count($arrayWords);
    }


    /**
     * @param String
     * @return array
     *
     * Return the words in an array
     * */
    public function words($text)
    {
        return explode(' ', $text);
    }


}
