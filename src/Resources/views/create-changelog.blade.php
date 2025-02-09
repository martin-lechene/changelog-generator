<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
            <div class="max-w-md mx-auto">
                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Create Changelog') }}</h2>

                        @if (session()->has('message'))
                            <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form wire:submit.prevent="saveChangelog" class="space-y-6">
                            <div>
                                <label for="version" class="block text-sm font-medium text-gray-700">{{ __('Version') }}</label>
                                <input type="text" id="version" wire:model="version"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="1.0.0">
                                @error('version')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">{{ __('Release Date') }}</label>
                                <input type="date" id="date" wire:model="date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="added" class="block text-sm font-medium text-gray-700">{{ __('Added Features') }}</label>
                                <div class="mt-1">
                                    <textarea id="added" wire:model="added" rows="3"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="{{ __('Enter new features (one per line)') }}"></textarea>
                                </div>
                                @error('added')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="changed" class="block text-sm font-medium text-gray-700">{{ __('Changed Features') }}</label>
                                <div class="mt-1">
                                    <textarea id="changed" wire:model="changed" rows="3"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="{{ __('Enter changed features (one per line)') }}"></textarea>
                                </div>
                                @error('changed')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fixed" class="block text-sm font-medium text-gray-700">{{ __('Fixed Issues') }}</label>
                                <div class="mt-1">
                                    <textarea id="fixed" wire:model="fixed" rows="3"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="{{ __('Enter fixed issues (one per line)') }}"></textarea>
                                </div>
                                @error('fixed')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-5">
                                <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Create Changelog') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 