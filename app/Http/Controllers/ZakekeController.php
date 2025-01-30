<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ZakekeController extends Controller
{
    public function getAccessToken()
    {
        $client = new Client();
        $apiUrl = 'https://api.zakeke.com/token';
        $clientId = env('ZAKEKE_CLIENT_ID');
        $clientSecret = env('ZAKEKE_CLIENT_SECRET');

        try {
            $response = $client->post($apiUrl, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'scope' => 'read write',
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return response()->json(['access_token' => $body['access_token']]);
        } catch (\Exception $e) {
            Log::error('Error getting access token from Zakeke: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get access token'], 500);
        }
    }

    public function sendProductToZakeke(Request $request)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken || !isset($accessToken->original['access_token'])) {
            return response()->json(['error' => 'Failed to get Zakeke access token'], 500);
        }

        $client = new Client();
        $apiUrl = 'https://your-zakeke-endpoint.com/product'; // Update this with the correct API URL

        try {
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken->original['access_token']}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'description' => $request->input('description'),
                    'sku' => $request->input('sku'),
                ]
            ]);

            $zakekeResponse = json_decode($response->getBody()->getContents(), true);

            // Store the product in the database
            $product = Product::create([
                'zakeke_product_id' => $zakekeResponse['id'] ?? 'unknown', // Replace 'id' with actual Zakeke product ID field
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'thumbnail' => $request->input('thumbnail', ''), // Optional field
                'customizable' => $request->input('customizable', false),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product sent to Zakeke and saved successfully',
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending product to Zakeke: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send product to Zakeke'], 500);
        }
    }
}
