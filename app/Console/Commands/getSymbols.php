<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Symbol;

class getSymbols extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_symbols';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* dd (\ccxt\Exchange::$exchanges); */
        $kucoin = new \ccxt\binance();
        $symbols = $kucoin->loadMarkets();

        $insertData = [];
        $symbolsArr = [];
        foreach ($symbols as $symbol) {
            if ($symbol['quote'] == 'USDT') {
                $symbolStr = $symbol['info']['symbol'];
                $symbolsArr[] =  $symbolStr;
                $insertData[] = [
                    'symbol' =>  $symbolStr,
                    'base' => $symbol['baseId'],
                    'quote' => $symbol['quoteId'],
                ];
            }
        }

        try {
            Symbol::upsert($insertData, ['symbol' ], ['base', 'quote']);
            Symbol::whereNotIn('symbol', $symbolsArr)->delete();
        } catch (QueryException $e) {
            echo $e;
        }

        return 0;
    }
}
