<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProcessRecordingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'video' => 'required', //   max file size as needed max:102400
        ]);

        // Check if the request contains a file
        if ($request->hasFile('video')) {
            // Get the uploaded file
            $video = $request->file('video');

            // Move the uploaded file to the storage path
            $videoPath = Storage::put("public/screen-recordings", $video);

            // trim file path to store in db
            $videoPath = str_replace('public', '', $videoPath);

             $video = Video::create([
                 'uid' => Str::uuid()->toString(),
                 'path' => $videoPath,
             ]);


            // Construct the new URL with the desired format
            $newUrl = URL::to('/') . '/view-recording?uid=' . $video->uid ;

            // Return a response indicating success
            return response()->json(['message' => 'Video uploaded successfully', 'video_path' => $newUrl], 200);
        }

        // Return a response indicating failure if no file is uploaded
        return response()->json(['error' => 'No video file uploaded'], 400);
    }

}
