<div class="flex space-x-2">
    <a href="{{ route('employees.show', $employee) }}" 
       class="text-blue-600 hover:text-blue-900 font-medium">
        View
    </a>
    <a href="{{ route('employees.edit', $employee) }}" 
       class="text-indigo-600 hover:text-indigo-900 font-medium">
        Edit
    </a>
    <form action="{{ route('employees.destroy', $employee) }}" 
          method="POST" 
          class="inline-block"
          onsubmit="return confirm('Are you sure you want to delete this employee?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
            Delete
        </button>
    </form>
</div>