<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArchiveResource;
use App\Models\Archive;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ArchiveController extends Controller
{

    public function index(Request $request)
    {
        $query = Archive::query();
        $size = $request->query('size');
        $archives = $query->get();
        if ($size) {
            $archives = $query->paginate($size);
        }
        return ArchiveResource::collection($archives);
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "name" => 'required|string|min:3|max:50|unique:archives',
                "idEvent" => 'required|numeric',
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        $archive = Archive::create($request->all());
        if ($archive) {
            return new ArchiveResource($archive);
        }
        throw new Exception('Unexpected Error');
    }

    public function show(Archive $archive)
    {
        return new ArchiveResource($archive);
    }

    public function getByName($name)
    {
        $archive = Archive::where('name', $name)->first();
        if (! $archive) {
            return response()->json(['error' => 'name'], 400);
        }
        return new ArchiveResource($archive);
    }

    public function getByDate($registeredDate)
    {
        $archive = Archive::where('registeredDate','like', '%'.$registeredDate.'%')->first();
        if (! $archive) {
            return response()->json(['error' => 'registeredDate'], 400);
        }
        return new ArchiveResource($archive);
    }

    public function update(Request $request, Archive $archive)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "id" => 'required|numeric|unique:archives'. $archive->id,
                "name" => 'required|string|min:3|max:50|unique:archives',
                "idEvent" => 'required|numeric',
            ]);

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        if ($archive->update($request->all())) {
            $archive->flash();
            return new ArchiveResource($archive);
        }

        throw new Exception('Unexpected Error');
    }


    public function destroy(Archive $archive)
    {
        if ($archive->delete()) {
            return ['data' => $archive->id];
        }
        throw new Exception('Unexpected Error');
    }
}
