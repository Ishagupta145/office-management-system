<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * List employees (Datatables + filters)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Employee::with(['company', 'manager'])
                ->select([
                    'employees.id',
                    'employees.first_name',
                    'employees.last_name',
                    'employees.email',
                    'employees.phone',
                    'employees.company_id',
                    'employees.manager_id',
                    'employees.position'
                ]);

            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }

            if ($request->filled('position')) {
                $query->where('position', 'like', '%' . $request->position . '%');
            }

            return DataTables::of($query)
                ->addColumn('full_name', fn ($e) => $e->full_name)
                ->addColumn('company_name', fn ($e) => $e->company->name ?? 'N/A')
                ->addColumn('manager_name', fn ($e) => $e->manager?->full_name ?? 'N/A')
                ->addColumn('action', function ($employee) {
                return view('employees.partials.actions', compact('employee'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $companies = Company::all();
        $positions = Employee::distinct()->pluck('position');

        return view('employees.index', compact('companies', 'positions'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }

    /**
     * Store employee
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email',
            'phone'      => 'nullable|string|max:20',
            'position'   => 'required|string|max:255',
            'salary'     => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:employees,id',
            'country'    => 'nullable|string',
            'state'      => 'nullable|string',
            'city'       => 'nullable|string',
            'hire_date'  => 'nullable|date',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully!');
    }

    /**
     * Show employee
     */
    public function show(Employee $employee)
    {
        $employee->load(['company', 'manager', 'subordinates']);
        return view('employees.show', compact('employee'));
    }

    /**
     * Edit employee
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all();
        $managers = Employee::where('company_id', $employee->company_id)
            ->where('id', '!=', $employee->id)
            ->get();

        return view('employees.edit', compact('employee', 'companies', 'managers'));
    }

    /**
     * Update employee
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email,' . $employee->id,
            'phone'      => 'nullable|string|max:20',
            'position'   => 'required|string|max:255',
            'salary'     => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:employees,id',
            'country'    => 'nullable|string',
            'state'      => 'nullable|string',
            'city'       => 'nullable|string',
            'hire_date'  => 'nullable|date',
        ]);

        if (($validated['manager_id'] ?? null) == $employee->id) {
            return back()->withErrors([
                'manager_id' => 'An employee cannot be their own manager.',
            ]);
        }

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Delete employee
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }

    /**
     * Get managers by company (AJAX dropdown)
     */
    public function getManagersByCompany($companyId)
    {
        try {
            $managers = Employee::where('company_id', $companyId)
                ->select('id', 'first_name', 'last_name')
                ->orderBy('first_name')
                ->get()
                ->map(fn ($e) => [
                    'id'   => $e->id,
                    'name' => $e->first_name . ' ' . $e->last_name,
                ]);

            return response()->json($managers);

        } catch (\Exception $e) {
            Log::error('Manager fetch error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
}
