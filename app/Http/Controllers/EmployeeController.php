<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Employee::with(['company', 'manager'])
                ->select('employees.*');

            // Apply company filter
            if ($request->has('company_id') && $request->company_id != '') {
                $query->where('company_id', $request->company_id);
            }

            // Apply position filter
            if ($request->has('position') && $request->position != '') {
                $query->where('position', 'like', '%' . $request->position . '%');
            }

            return DataTables::of($query)
                ->addColumn('full_name', function ($employee) {
                    return $employee->full_name;
                })
                ->addColumn('company_name', function ($employee) {
                    return $employee->company->name ?? 'N/A';
                })
                ->addColumn('manager_name', function ($employee) {
                    return $employee->manager ? $employee->manager->full_name : 'N/A';
                })
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

    public function create()
    {
        $companies = Company::all();
        $managers = Employee::all();
        return view('employees.create', compact('companies', 'managers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,NULL,id,deleted_at,NULL',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:employees,id',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'hire_date' => 'nullable|date'
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully!');
    }

    public function show(Employee $employee)
    {
        $employee->load(['company', 'manager', 'subordinates']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $companies = Company::all();
        $managers = Employee::where('id', '!=', $employee->id)->get();
        return view('employees.edit', compact('employee', 'companies', 'managers'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id . ',id,deleted_at,NULL',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:employees,id',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'hire_date' => 'nullable|date'
        ]);

        // Prevent employee from being their own manager
        if (isset($validated['manager_id']) && $validated['manager_id'] == $employee->id) {
            return back()->withErrors(['manager_id' => 'An employee cannot be their own manager.']);
        }

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }

    public function getManagersByCompany($companyId)
{
    $managers = Employee::where('company_id', $companyId)
        ->where('position', 'Manager')
        ->select('id', 'first_name', 'last_name')
        ->get()
        ->map(function ($m) {
            return [
                'id' => $m->id,
                'name' => $m->first_name . ' ' . $m->last_name
            ];
        });

    return response()->json($managers);
}
}

