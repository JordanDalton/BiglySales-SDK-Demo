<?php

use BiglySales\BiglySalesAiSdk\BiglySalesAi;
use BiglySales\BiglySalesAiSdk\Enums\AutoResponderType;
use BiglySales\BiglySalesAiSdk\Requests\ObtainTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('start', function(){

    $ip = request()->ip();

    //return \Illuminate\Support\Facades\Cache::remember($ip, (60*60*24), function(){

        $sdk = app('bigly');

        $client_reference_id = uniqid();

        $files = [
            [
                'path'     => resource_path('knowledge/SourceOfTruth.txt'),
                'filename' => 'SourceOfTruth.txt'
            ],
        ];

        $client = $sdk->clients()->create($client_reference_id, $files)->json('data');

        $chat_reference_id = uniqid();

        $auto_responder = $sdk->clientAutoResponders($client['id'])->create($chat_reference_id, AutoResponderType::CHATBOT)->json();

        return compact('client', 'auto_responder', 'chat_reference_id');

    //});
});

Route::post('chat', function(Request $request){

    $request->validate([
        'client_id'         => 'required|int',
        'auto_responder_id' => 'required|int',
        'chat_reference_id' => 'required|string',
        'question' => 'required|string',
    ]);

    $file = File::get(resource_path('knowledge/SourceOfTruth.txt'));

    $prompt = <<<EOT
    You are a helpful chatbot which can answer any question based on the following knowledge document:
    """
    {$file}
    """
    
    If yo don't know the answer simply respond with "I don't know"
    EOT;

    return app('bigly')
            ->clientAutoResponders($request->client_id)
            ->chat(
                $request->auto_responder_id,
                $request->question,
                $prompt
            )->json();
});



Route::post('email-completion', function(Request $request){

    $request->validate([
        'pre_prompt' => 'required|string',
        'rules'      => 'required|string',
        'payload'    => 'required|string',
    ]);

    return app('bigly')
            ->emailCompletions()
            ->create(
                $request->pre_prompt,
                $request->rules,
                json_decode($request->payload, true)
            )->json();
});


Route::post('sms-completion', function(Request $request){

    $request->validate([
        'pre_prompt' => 'required|string',
        'rules'      => 'required|string',
        'payload'    => 'required|string',
    ]);

    return app('bigly')
        ->smsCompletions()
        ->create(
            $request->pre_prompt,
            $request->rules,
            json_decode($request->payload, true)
        )->json();
});