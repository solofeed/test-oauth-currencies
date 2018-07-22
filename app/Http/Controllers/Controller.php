<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use Illuminate\View\View;
use InvalidArgumentException;

class Controller extends BaseController
{
    public function authorize(): RedirectResponse
    {

        $authorizeURL = 'https://testing.e-id.cards/';

        $params = [
            'client_id'    => 'ek_token_ico',
            'redirect_uri' => 'api.local/auth/code',
            'scope'        => 'firstname+surname+email+phone+pwhash+viber+skype+wechat+trust_level+otp+totp_secret',
        ];

        return redirect($authorizeURL . '?' . http_build_query($params));
    }

    public function code(Request $request): RedirectResponse
    {
        $params = [
            'client_id'     => 'ek_token_ico',
            'client_secret' => 'iequ2EeH7r',
            'scope'         => 'firstname+surname+email+phone+pwhash+viber+skype+wechat+trust_level+otp+totp_secret',
            'code'          => $request->input('code'),
            'grant_type'    => 'authorization_code'
        ];

        $http = new Client(['base_uri' => 'https://testing-new.e-id.cards/oauth']);

        $response = $http->post('/client', ['form_params' => $params]);
        $accessToken = json_decode($response->getBody(), true)['access_token'];

        $response = $http->get('/data', [
            'headers' => ['Authorization: Bearer ' . $accessToken]
        ]);
        $userData = json_decode($response->getBody());

        return redirect()->route('currencies', ['userData' => $userData, 'accessToken' => $accessToken]);
    }

    public function currencies(Request $request): View
    {
        $http = new Client([
            'base_uri' => 'https://testing.bb.yttm.work:5000/v1/',
            'headers'  => ['Authorization: Bearer ' . $request->input('access_token')]
        ]);

        $response = $http->post('oauth_auth', ['form_params' => $request->input('userData')]);

        $sid = json_decode($response->getBody(), true)['sid'];

        $currencies = json_decode($http->get('get_currencies', ['headers' => ['sid' => $sid]])->getBody(), true)['currencies'];
        $rates = json_decode($http->get('get_currency_rates', ['headers' => ['sid' => $sid]])->getBody(), true)['rates'];

        $currencyRates = $this->makeCurrencyRates($currencies, $rates);

        return view('currencies', ['currencyRates' => $currencyRates]);
    }

    public function makeCurrencyRates(array $currencies, array $rates): array
    {
        foreach ($currencies as $index => $currency) {
            foreach ($rates as $rate) {
                if ($currency['curr_id'] === $rate['from']) {
                    $currencyRate = [
                        'curr_code' => $this->getCurrCodeByCurrId($currencies, $rate['to']),
                        'rate'      => $rate['rate']
                    ];

                    $currencies[$index]['rates'][] = $currencyRate;
                }
            }
        }

        return $currencies;
    }

    public function getCurrCodeByCurrId(array $currencies, int $currId): string
    {
        foreach ($currencies as $currency) {
            if ($currency['curr_id'] == $currId) {
                return $currency['curr_code'];
            }
        }

        throw new InvalidArgumentException('invalid curr id');
    }
}
