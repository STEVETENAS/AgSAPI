<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();
        $size = $request->query('size');
        $events = $query->get();
        if ($size) {
            $events = $query->paginate($size);
        }
        return EventResource::collection($events);
    }

    public function store(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                "title" => 'required|string|min:3|max:50',
                "details" => 'required|string',
                "idCategory" => 'required|numeric',
                "idUser" => 'required|numeric',
                "dateFin" => 'required|date',
                "dateDebut" => 'date',
                "public" => 'boolean',
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        $event = Event::create($request->all());
        if ($event) {
            return new EventResource($event);
        }
        throw new Exception('Unexpected Error');
    }

    public function show(Event $event)
    {
        return new EventResource($event);
    }

    public function getByStartDate($dateDebut)
    {
        $event = Event::where('dateDebut','like', '%'.$dateDebut.'%')->first();
        if (! $event) {
            return response()->json(['error' => 'dateDebut'], 400);
        }
        return new EventResource($event);
    }

    public function getByEndDate($dateFin)
    {
        $event = Event::where('dateFin', $dateFin)->first();
        if (! $event) {
            return response()->json(['error' => 'dateFin'], 400);
        }
        return new EventResource($event);
    }

    public function update(Request $request, Event $event)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "id" => 'required|numeric|unique:events'. $event->id,
                "title" => 'required|string|min:3|max:50',
                "details" => 'required|text|min:5',
                "idCategory" => 'required|numeric',
                "idUser" => 'required|numeric',
                "dateFin" => 'required|timestamp',
                "dateDebut" => 'timestamp',
                "public" => 'boolean',
            ]);

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        if ($event->update($request->all())) {
            $event->flash();
            return new EventResource($event);
        }

        throw new Exception('Unexpected Error');
    }

    public function destroy(Event $event)
    {
        if ($event->delete()) {
            return ['data' => $event->id];
        }
        throw new Exception('Unexpected Error');
    }
}
