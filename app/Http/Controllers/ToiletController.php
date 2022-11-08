<?php

namespace App\Http\Controllers;

use App\Models\ToiletData;
use App\Models\ToiletQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ToiletController extends Controller
{
    public function storeToiletData(Request $request)
    {
        $toiletData = new ToiletData([
            'motion'      => $request->boolean('motion'),
            'tamper'      => $request->boolean('tamper'),
            'battery'     => $request->input('bat'),
            'lux'         => $request->input('lux'),
            'temperature' => $request->input('temp'),
        ]);

        $toiletData->save();

        if ($toiletData->motion === false) {
            $inLine = ToiletQueue::query()->limit(1)->get();

            if ($inLine->isEmpty()) {
                return;
            }

            $token = config('toilet.slack_bot_token');

            Http::withToken($token)->asForm()->post('https://slack.com/api/chat.postMessage', [
                'channel'    => $inLine->first()->channel_id,
                'text'       => 'Het toilet is weer vrij ' . $inLine->first()->user_name . '! :white_check_mark:',
            ]);

            DB::table('toilet-queue')->where('id', $inLine->first()->id)->delete();
        }
    }

    public function showToiletData(Request $request)
    {
        $latestToiletData = ToiletData::latest()->first();

        return response()->json([
            'data' => [
                'motion'      => $latestToiletData->motion,
                'tamper'      => $latestToiletData->tamper,
                'battery'     => $latestToiletData->battery,
                'lux'         => $latestToiletData->lux,
                'temperature' => $latestToiletData->temperature,
            ],
        ]);
    }

    public function canUseToilet(Request $request)
    {
        $latestToiletData = ToiletData::latest()->first();

        if ($latestToiletData->motion === false && $latestToiletData->tamper === false) {
            return response()->json([
                'blocks' => [
                    [
                        'type' => 'section',
                        'text' => [
                            'type'          => 'mrkdwn',
                            'text'          => 'Ja! Je kan pissen! :tada: :toilet:',
                        ],
                    ],
                ],
            ]);
        }

        $toiletQueue = new ToiletQueue([
            'channel_id' => $request->input('channel_id'),
            'user_name'  => $request->input('user_name'),
        ]);

        $toiletQueue->save();

        return response()->json([
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type'          => 'mrkdwn',
                        'text'          => 'Nee, het toilet is bezet. :cry: Ik geef aan wanneer het vrij is.',
                    ],
                ],
            ],
        ]);
    }
}
