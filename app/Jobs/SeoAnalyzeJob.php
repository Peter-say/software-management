<?php

namespace App\Jobs;

use App\Services\API\V1\Assistant\SeoAnalyzer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Request;

class SeoAnalyzeJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(SeoAnalyzer $seoAnalyzerService): void
    {
         $seoAnalyzerService->analyzer(new Request($this->data));
    }
}
