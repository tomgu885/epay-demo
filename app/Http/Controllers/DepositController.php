<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    function bindAddress()
    {
        $uid = Auth::id();
        $user = Auth::getUser();
        $username = $user->name;
        Log::info('username:', [
            'username' => $username,
        ]);

        $resp = epay_post('/bind_address',[
            'username'  => $username,
        ]);
        Log::info('$resp', [$resp]);
        Log::info('address:'.$resp['data']['address']);
        $user->usdt_address = $resp['data']['address'];
        $user->save();

        return [
            'uid'   => $uid,
            'username' => $username,
            'address' => $resp['data']['address'],
        ];
    }

    function depositCallback(Request $request)
    {
        $data = $request->all();
        Log::info('depostData', $data);
        $_sign = _epay_sign($data);
        Log::info('sign:'.$_sign);
        if ($_sign != $data['sign']) {
            return 'sign failed';
        }
        $txid = $data['txid'];
        $exists = Deposit::where('txid', $txid)->first();
        if ($exists) {
            Log::info('order_already_exists', ['txid' => $txid]);
            return 'success';
        }

        $user = User::where('usdt_address', $data['to_address'])->first();
        if (empty($user)) {
            Log::info('user not found:', [
                'txid' => $txid,
                'name'  => $data['username'],
                'usdt_address' => $data['to_address'],
            ]);
            return 'success'; // stop notify again.
        }

        DB::transaction(function () use ($data, $txid, $user) {
          DB::table('deposits')->insert([
              'txid' => $txid,
              'paid_at' => $data['paid_at'],
              'amount' => $data['amount'],
              'to_address' => $data['to_address'],
              'from_address' => $data['from_address'],
              'user_id' => $user->id,

          ]);

          DB::table('users')->where('id', $user->id)->increment('balance', $data['amount']);

          DB::commit();
        });


        return 'success';
    }
}
