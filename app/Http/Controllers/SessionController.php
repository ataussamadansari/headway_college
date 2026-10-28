<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSessionRequest;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Display a listing of the sessions.
     */
    public function index()
    {
        $sessions = Session::paginate(10);
        return view('sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new session.
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * Store a newly created session in storage.
     */
    public function store(StoreSessionRequest $request)
    {
        Session::create($request->validated());
        return redirect()->route('sessions.index')->with('success', 'Session created successfully!');
    }

    /**
     * Display the specified session.
     */
    public function show(Session $session)
    {
        return view('sessions.show', compact('session'));
    }

    /**
     * Show the form for editing the specified session.
     */
    public function edit(Session $session)
    {
        return view('sessions.edit', compact('session'));
    }

    /**
     * Update the specified session in storage.
     */
    public function update(StoreSessionRequest $request, Session $session)
    {
        $session->update($request->validated());
        return redirect()->route('sessions.index')->with('success', 'Session updated successfully!');
    }

    /**
     * Remove the specified session from storage.
     */
    public function destroy(Session $session)
    {
        $session->delete();
        return redirect()->route('sessions.index')->with('success', 'Session deleted successfully!');
    }
}
