<?php

namespace DogAndDev\ChangelogGenerator\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use DogAndDev\ChangelogGenerator\Services\ChangelogService;
use Carbon\Carbon;

class CreateChangelog extends Component
{
    public string $version = '';
    public string $date = '';
    public string $added = '';
    public string $changed = '';
    public string $fixed = '';
    public string $message = '';

    protected array $rules = [
        'version' => 'required|regex:/^\d+\.\d+\.\d+$/',
        'date' => 'required|date',
        'added' => 'nullable|string',
        'changed' => 'nullable|string',
        'fixed' => 'nullable|string',
    ];

    protected array $messages = [
        'version.regex' => 'Version must be in format X.X.X (e.g., 1.0.0)',
    ];

    protected ChangelogService $changelogService;

    public function boot(ChangelogService $changelogService)
    {
        $this->changelogService = $changelogService;
    }

    public function mount(): void
    {
        $this->date = Carbon::now()->format('Y-m-d');
    }

    public function saveChangelog(): void
    {
        $this->validate();

        try {
            $changelog = [
                'version' => $this->version,
                'date' => $this->date,
                'sections' => array_filter([
                    'added' => $this->formatSection($this->added),
                    'changed' => $this->formatSection($this->changed),
                    'fixed' => $this->formatSection($this->fixed),
                ]),
            ];

            // Save as JSON for backup
            if (config('changelog-generator.format') === 'json') {
                $path = storage_path('app/changelogs');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }
                $filename = $path . '/changelog-' . $this->version . '.json';
                File::put($filename, json_encode($changelog, JSON_PRETTY_PRINT));
            }

            // Generate and update markdown file
            $this->changelogService->updateChangelog($changelog);

            $this->reset(['version', 'added', 'changed', 'fixed']);
            session()->flash('message', __('Changelog created successfully!'));
        } catch (\Exception $e) {
            session()->flash('error', __('Error creating changelog: ') . $e->getMessage());
        }
    }

    private function formatSection(?string $content): ?array
    {
        if (empty($content)) {
            return null;
        }

        return array_filter(array_map('trim', explode("\n", $content)));
    }

    public function render()
    {
        return view('changelog-generator::create-changelog');
    }
} 