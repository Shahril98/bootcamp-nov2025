<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-4">Edit Expense</h1>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="p-4 mb-4 bg-red-100 text-red-700 border border-red-400 rounded">
                <ul class="ml-4 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('expenses.update', $expense) }}" method="POST">
            @csrf
            @method('PATCH')

            <label class="block">Title</label>
            <input type="text" name="title" value="{{ old('title', $expense->title) }}"
                class="w-full mb-4 p-2 border rounded">

            <label class="block">Description</label>
            <input type="text" name="description" value="{{ old('description', $expense->description) }}"
                class="w-full mb-4 p-2 border rounded">

            <label class="block">Amount</label>
            <input type="number" name="amount" step="0.01" value="{{ old('amount', $expense->amount) }}"
                class="w-full mb-4 p-2 border rounded">

            <label class="block">Category</label>
            <input type="text" name="category" value="{{ old('category', $expense->category) }}"
                class="w-full mb-4 p-2 border rounded">

            <label class="block">Spent At</label>
            <input type="date" name="spent_at" value="{{ old('spent_at', $expense->spent_at->format('Y-m-d')) }}"
                class="w-full mb-4 p-2 border rounded">

            <label class="block">Notes</label>
            <textarea name="notes" class="w-full mb-4 p-2 border rounded">{{ old('notes', $expense->notes) }}</textarea>

            <div class="flex justify-between">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-300 rounded">
                    Cancel
                </a>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Update
                </button>
            </div>
        </form>

    </div>
</x-app-layout>