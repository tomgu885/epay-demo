<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EpayHello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:epay-hello {act?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试 hello';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $act = $this->argument('act');
        switch ($act) {
            case 'address':
                $this->getAddress();
                break;
            case 'price':
                $this->price();
                break;
            case 'hello':
            default:
                $this->hello();
        }

    }

    function getAddress()
    {
        $data = epay_post('/bind_address', [
            'username'  => 'test54',
        ]);

        echo json_encode($data, 320);
    }

    function createDepositCNY()
    {
        $orderResp = epay_post('/deposit/cny', [
            'amount'    => 1000,
            'username'  => 'jack1234',
            'order_sn'  => 'test'.time(),
        ]);


    }

    function price()
    {
        $resp = epay_post('/usdt_ratio', []);
        var_dump($resp);
    }

    function hello()
    {
        $data = [
            'name'  => 'jack',
            'age'   => 22,
        ];

        $resp = epay_post('/hello', $data);
        var_dump($resp);
    }
}
