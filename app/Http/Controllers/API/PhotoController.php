<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\PhotoLike;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class PhotoController extends Controller
{
    public function index(Request $request){
        $data = Photo::selectRaw('id,path,file_name,caption,tags,user_id')
                ->with('author:id,name')
                ->withCount('likes')
                ->simplePaginate($request->paginate??10);

        return response()->json($data);
    }

    public function show($id){

        $data = Photo::selectRaw('id,path,file_name,caption,tags,user_id')
                ->with('author:id,name')
                ->withCount('likes')->find($id);

        return response()->json($data);
    }

    public function store(Request $request){
        $request->validate([
            'file'    => 'required|image|max:2048',
            'caption' => 'required|max:500',
            'tags'    => 'nullable|array'
        ]);
        $path = 'public/'.md5(auth()->id());

        $request->file('file')->store($path);

        $photo = new Photo();
        $photo->path = $path;
        $photo->file_name = $request->file('file')->hashName();
        $photo->size = $request->file('file')->getSize()/1024;
        $photo->caption=$request->caption;
        $photo->tags=$request->tags;
        $photo->user_id=auth()->id();
        $photo->save();

        return response()->json($photo, 201);
    }

    public function update(Request $request, $id){
        $request->validate([
            'caption' => 'required|max:500',
            'tags'    => 'nullable|array'
        ]);

        $photo = Photo::find($id);
        $photo->caption=$request->caption;
        $photo->tags=$request->tags;
        $photo->save();

        return response()->json($photo, 200);
    }

    public function destroy($id){
        try {
            $photo = Photo::find($id);
            unlink(storage_path('app/'.$photo->path.'/'.$photo->file_name));
            $photo->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->noContent();
    }

    public function like($id){
        $photoLike = new PhotoLike();
        $photoLike->photo_id = $id;
        $photoLike->user_id = auth()->id();
        $photoLike->save();

        return response()->json($photoLike, 201);
    }

    public function unlike($id){
        PhotoLike::where('photo_id', $id)
                                ->where('user_id', auth()->id())
                                ->delete();
                                
        return response()->noContent();
    }
}
