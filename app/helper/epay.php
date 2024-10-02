<?php

function epay_post($path, $data) {
    $url = config('epay.base_url').$path;
    \Illuminate\Support\Facades\Log::info('$url:'.$url);
    $data['timestamp'] = time();
    $data['api_id'] = config('epay.id');
    $data['sign'] = _epay_sign($data);
    \Illuminate\Support\Facades\Log::info('$data', $data);
    $resp = \Illuminate\Support\Facades\Http::withOptions([
        'debug' => false,
    ])->post($url, $data);
    return $resp->json();
}

function _epay_sign($data = array())
{
    ksort($data);
    $list = [];
    foreach ($data as $k => $v) {
        if ('sign' == $k) {
            continue;
        }
        $list[] = $k . '=' . $v;
    }

    $toSign = implode('&', $list).config('epay.key');
    \Illuminate\Support\Facades\Log::info('$toSign:'.$toSign);
    return sha1($toSign);
}

