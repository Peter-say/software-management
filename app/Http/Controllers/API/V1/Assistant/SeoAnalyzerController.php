<?php

namespace App\Http\Controllers\API\V1\Assistant;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AI\V1\Assistant\SeoAnalyzerResource;
use App\Services\API\V1\Assistant\SeoAnalyzer;
use App\Services\SiteInspector\SiteInspectorService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SeoAnalyzerController extends Controller
{
    protected $seoAnalyzerService;
    protected $inspector;

    public function __construct(SeoAnalyzer $seoAnalyzerService, SiteInspectorService $inspector)
    {
        $this->seoAnalyzerService = $seoAnalyzerService;
        $this->inspector = $inspector;
    }

    public function analyze(Request $request)
    {
        try {
             set_time_limit(360);
            // $inspection = $this->validateUrl($request->input('url'));
            // if ($inspection !== true) return $inspection;

            $result = $this->seoAnalyzerService->analyzer($request);

            return ApiHelper::successResponse('SEO analysis completed successfully', new SeoAnalyzerResource([
                'title' => $result['title'],
                'prompt' => $result['prompt'],
                'response' => $result['response'],
                'raw_response' => $result['raw_response'] ?? null,
            ]));
        } catch (ValidationException $e) {
            return ApiHelper::validationErrorResponse($e->errors());
        } catch (\Exception $e) {
            return ApiHelper::errorResponse('An unexpected error occurred: ' . $e->getMessage(), 500);
        }
    }

    protected function validateUrl(?string $url)
    {
        if (!$url) return true; // If no URL is provided, skip
        $result = $this->inspector->inspect($url);

        if ($result['error']) {
            return ApiHelper::validationErrorResponse($result['message']);
        }
        return true;
    }
}
