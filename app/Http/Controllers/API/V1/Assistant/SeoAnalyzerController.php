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
            if ($request->has('html_input') && $request->has('url')) {
                $inspection = $this->validateUrl($request->input('url'));
                if ($inspection !== true) return $inspection;
            }
            $result = $this->seoAnalyzerService->analyzer($request);
            $responseData = [];
            if (isset($result['response'])) {
                $responseData['response'] = $result['response'];
            }
            if (isset($result['title'])) {
                $responseData['title'] = $result['title'];
            }
            if (isset($result['prompt'])) {
                $responseData['prompt'] = $result['prompt'];
            }
            if (isset($result['raw_response'])) {
                $responseData['raw_response'] = $result['raw_response'];
            }
           
            return ApiHelper::successResponse('SEO analysis completed successfully', new SeoAnalyzerResource($responseData));
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
