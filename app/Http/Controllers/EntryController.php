<?php

namespace App\Http\Controllers;

use App\Models\Entry; 
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Entry::select('*');
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('entries.edit', $row->id);
                    $deleteUrl = route('entries.destroy', $row->id);
                    return '<a href="' . $editUrl . '" class="btn btn-primary btn-sm">Edit</a> 
                            <a href="' . $deleteUrl . '" class="btn btn-danger btn-sm delete-entry">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('entries.index');
    }

    public function create()
    {
        return view('entries.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Entry::create($request->all());

        return redirect()->route('entries.index')
            ->with('success', 'Entry created successfully.');
    }

    public function edit(Entry $entry)
    {
        return view('entries.edit', compact('entry'));
    }

    public function update(Request $request, Entry $entry)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $entry->update($request->all());

        return redirect()->route('entries.index')
            ->with('success', 'Entry updated successfully.');
    }

    public function destroy(Entry $entry)
    {
        $entry->delete();

        return redirect()->route('entries.index')
            ->with('success', 'Entry deleted successfully.');
    }
}