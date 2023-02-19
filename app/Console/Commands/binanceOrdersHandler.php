<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class binanceOrdersHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binance_orders';

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
        /* dump(env('BIN_API_KEY')); */
        /* dd(env('BIN_API_SECRET')); */
        $api = new \Binance\API(env('BIN_API_KEY'), env('BIN_API_SECRET'));
        $balanceUpdate = function ($api, $balances) {
            $this->onBalanceUpdate($api, $balances);
        };

        $orderUpdate = function ($api, $report) {
            $this->onOrderUpdate($api, $report);
        };

        $api->userData($balanceUpdate, $orderUpdate);
        return 0;
    }

    public function onBalanceUpdate($api, $balances)
    {
        dump($balances);
    }

    public function onOrderUpdate($api, $binOrder)
    {
        dump($binOrder);
        if ($binOrder['side'] == 'BUY') {
            if ($binOrder['executionType']  == "TRADE") {
                if ($binOrder['orderStatus'] == "FILLED") {
                    //$this->setSellLimitOrder($binOrder);
                }
            }
        }

        if ($binOrder['side'] == 'SELL') {
            if ($binOrder['executionType']  == "TRADE") {
                if ($binOrder['orderStatus'] == "FILLED") {
                    if ($binOrder['orderType'] != 'MARKET') {
                        //$this->completeOrder($binOrder);
                    }
                }
            }
        }

        if ($binOrder['orderStatus'] == "FILLED") {
            dump(['FILLED']);
            //$this->updateBalances();
        }
    }
}
