<?php

namespace DogAndDev\ChangelogGenerator\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ChangelogService
{
    protected string $markdownPath;
    protected array $gitConfig;

    public function __construct()
    {
        $this->markdownPath = base_path(config('changelog-generator.markdown_path', 'CHANGELOG.md'));
        $this->gitConfig = config('changelog-generator.git', []);
    }

    public function generateMarkdown(array $data): string
    {
        $date = Carbon::parse($data['date'])->format('Y-m-d');
        $markdown = [];

        if (!File::exists($this->markdownPath)) {
            $markdown[] = "# Changelog\n";
            $markdown[] = "All notable changes to this project will be documented in this file.\n";
            $markdown[] = "The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),";
            $markdown[] = "and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).\n";
        }

        $markdown[] = "\n## [" . $data['version'] . "] - " . $date;

        foreach (['added' => 'Added', 'changed' => 'Changed', 'fixed' => 'Fixed'] as $key => $title) {
            if (!empty($data['sections'][$key])) {
                $markdown[] = "\n### " . $title;
                foreach ($data['sections'][$key] as $item) {
                    $markdown[] = "- " . $item;
                }
            }
        }

        return implode("\n", $markdown);
    }

    public function updateChangelog(array $data): void
    {
        $newContent = $this->generateMarkdown($data);
        
        if (File::exists($this->markdownPath)) {
            $existingContent = File::get($this->markdownPath);
            // Insert new version after the header
            $pattern = "/# Changelog.*?\n(?=\n## \[|$)/s";
            if (preg_match($pattern, $existingContent, $matches)) {
                $header = $matches[0];
                $newContent = $header . $newContent . "\n" . str_replace($header, '', $existingContent);
            }
        }

        File::put($this->markdownPath, $newContent);

        if ($this->shouldHandleGit()) {
            $this->handleGitOperations($data['version']);
        }
    }

    protected function shouldHandleGit(): bool
    {
        return $this->gitConfig['enabled'] ?? false;
    }

    protected function handleGitOperations(string $version): void
    {
        if ($this->gitConfig['auto_commit']) {
            $this->gitCommit($version);
        }

        if ($this->gitConfig['auto_push']) {
            $this->gitPush();
        }
    }

    protected function gitCommit(string $version): void
    {
        $message = str_replace(
            '{version}',
            $version,
            $this->gitConfig['commit_message'] ?? 'docs: update changelog for version {version}'
        );

        $this->runCommand(['git', 'add', $this->markdownPath]);
        $this->runCommand(['git', 'commit', '-m', $message]);
    }

    protected function gitPush(): void
    {
        $remote = $this->gitConfig['remote'] ?? 'origin';
        $branch = $this->gitConfig['branch'] ?? 'main';
        
        $this->runCommand(['git', 'push', $remote, $branch]);
    }

    protected function runCommand(array $command): void
    {
        $process = new Process($command, base_path());
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
} 