<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     */
    public function index(): View
    {
        $companies = Company::query()
            ->latest()
            ->paginate(10);

        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create(): View
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created company.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'address' => [
                'required',
                'string',
                'max:1000',
            ],

            'contact_person' => [
                'nullable',
                'string',
                'max:255',
            ],

            'contact_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        Company::create($validated);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company): View
    {
        return view('admin.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company): View
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified company.
     */
    public function update(
        Request $request,
        Company $company
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'address' => [
                'required',
                'string',
                'max:1000',
            ],

            'contact_person' => [
                'nullable',
                'string',
                'max:255',
            ],

            'contact_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $company->update($validated);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified company.
     */
    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}