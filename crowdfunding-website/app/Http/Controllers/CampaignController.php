<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::paginate(6);

        $data['campaigns'] = $campaigns;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data campaigns berhasil ditampilkan',
            'data' => $data
        ], 200);
    }

    public function detail($id)
    {
        $campaign = Campaign::findOrFail($id);
        $data['campaign'] = $campaign;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data campaign berhasil ditampilkan',
            'data' => $data
        ], 200);
    }

    public function random($count)
    {
        $campaigns = Campaign::select('*')
            ->inRandomOrder()
            ->limit($count)
            ->get();

        $data['campaigns'] = $campaigns;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data campaigns berhasil ditampilkan',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
            'address' => 'required',
            'required' => 'required'
        ]);

        $campaign = Campaign::create([
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'required' => $request->required,
            'collected' => 0
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $campaign->id . "." . $image_extension;
            $image_folder = '/photos/campaign/';
            $image_location = $image_folder . $image_name;

            try {
                $image->move(public_path($image_folder), $image_name);

                $campaign->update([
                    'image' => $image_location
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'Photo campaign gagal diupload',
                    'data' => $campaign
                ]);
            }

            $data['campaign'] = $campaign;

            return response()->json([
                'response_code' => '00',
                'response_message' => 'Berhasil menambahkan campaign',
                'data' => $data
            ]);
        }
    }

    public function search($keyword)
    {
        $campaigns = Campaign::select('*')
            ->where('title', 'LIKE', '%' . $keyword . '%')
            ->get();

        $data['campaigns'] = $campaigns;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data campaigns berhasil ditampilkan',
            'data' => $data
        ], 200);
    }
}
