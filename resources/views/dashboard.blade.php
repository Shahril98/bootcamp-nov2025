<x-layouts.app>

    <div x-data="{
        showEditModal: {{ isset($editingExpense) ? 'true' : 'false' }},
        editingExpense: {{ isset($editingExpense) ? $editingExpense : '{}' }},
        editUrl: '{{ isset($editingExpense) ? route('expenses.update', $editingExpense->id) : '' }}',
        init() {
            if (this.editingExpense.spent_at) {
                this.editingExpense.spent_at = this.editingExpense.spent_at.split('T')[0];
            }
        },
        openEditModal(expense) {
            this.editingExpense = expense;
            if (this.editingExpense.spent_at) {
                this.editingExpense.spent_at = this.editingExpense.spent_at.split('T')[0];
            }
            this.editUrl = '{{ route('expenses.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', expense.id);
            this.showEditModal = true;
        }
    }">
        {{-- Success Message --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded transition duration-500 ease-in-out">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Error --}}
        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded transition duration-500 ease-in-out">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Dashboard')}}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Welcome to the dashboard') }}</p>
        </div>

        <!-- Expense Form -->
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700 mb-6">
            <h1 class="text-lg font-bold gap-6">Expenses Form</h1>

            <form action="{{ route('expenses.store')}}" method="POST">
                @csrf
                <input name="title" type="text" placeholder="Expense Title"
                    class="w-full mb-4 p-2 border border-gray-300 rounded">
                <input name="description" type="text" placeholder="Description"
                    class="w-full mb-4 p-2 border border-gray-300 rounded">
                <input type="number" name="amount" placeholder="Amount"
                    class="w-full mb-4 p-2 border border-gray-300 rounded">
                <input name="category" type="text" placeholder="Category"
                    class="w-full mb-4 p-2 border border-gray-300 rounded">
                <input type="date" name="spent_at" placeholder="Date Spend At"
                    class="w-full mb-4 p-2 border border-gray-300 rounded">
                <textarea name="notes" placeholder="Notes"
                    class="w-full mb-4 p-2 border border-gray-300 rounded"></textarea>
                <button class="bg-blue-500 text-white px-4 py type=" submit">Save </button>
            </form>

            @foreach ($expenses as $expense)
                <div class="mt-4 p-4 border border-gray-300 rounded">
                    <h2 class="text-lg font-bold">{{ $expense->title }}</h2>
                    <p>{{ $expense->description }}</p>
                    <p>Amount: RM {{ $expense->amount }}</p>
                    <p>Category: {{ $expense->category }}</p>
                    <p>Spent At: {{ $expense->spent_at->format('Y-m-d') }}</p>
                    <p>Notes: {{ $expense->notes }}</p>
                </div>

                <form action="{{route('expenses.destroy', $expense)}}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                </form>

                <button @click="openEditModal({{ $expense }})" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Edit
                </button>

            @endforeach

        </div>

        <!-- Edit Modal -->
        <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div x-show="showEditModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    @click="showEditModal = false"></div>

                <div x-show="showEditModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full max-w-md">
                    <form :action="editUrl" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                Edit Expense
                            </h3>
                            <div class="mt-4">
                                <input x-model="editingExpense.title" name="title" type="text"
                                    placeholder="Expense Title" class="w-full mb-4 p-2 border border-gray-300 rounded">
                                <input x-model="editingExpense.description" name="description" type="text"
                                    placeholder="Description" class="w-full mb-4 p-2 border border-gray-300 rounded">
                                <input x-model="editingExpense.amount" type="number" name="amount" placeholder="Amount"
                                    class="w-full mb-4 p-2 border border-gray-300 rounded">
                                <input x-model="editingExpense.category" name="category" type="text"
                                    placeholder="Category" class="w-full mb-4 p-2 border border-gray-300 rounded">
                                <input x-model="editingExpense.spent_at" type="date" name="spent_at"
                                    placeholder="Date Spend At" class="w-full mb-4 p-2 border border-gray-300 rounded">
                                <textarea x-model="editingExpense.notes" name="notes" placeholder="Notes"
                                    class="w-full mb-4 p-2 border border-gray-300 rounded"></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" @click="showEditModal = false"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Update
                            </button>
                            <button type="button" @click="showEditModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Users') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">--</p>
                    <p class="text-xs text-gray-500 flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        {{ __('No data') }}
                    </p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 dark:text-blue-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Revenue') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">--</p>
                    <p class="text-xs text-gray-500 flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        {{ __('No data') }}
                    </p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 dark:text-green-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Orders') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">--</p>
                    <p class="text-xs text-gray-500 flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        {{ __('No data') }}
                    </p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500 dark:text-purple-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Visitors Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Visitors') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">--</p>
                    <p class="text-xs text-gray-500 flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        {{ __('No data') }}
                    </p>
                </div>
                <div class="bg-orange-100 dark:bg-orange-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500 dark:text-orange-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
        </div>
    </div> --}}

</x-layouts.app>