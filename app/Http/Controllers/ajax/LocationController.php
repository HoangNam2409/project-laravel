<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $districtRepository;
    protected $provinceRepository;

    public function __construct(
        ProvinceRepository $provinceRepository,
        DistrictRepository $districtRepository,
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
    }

    // Get Location
    public function getLocation(Request $request)
    {
        $getData = $request->input();
        $html = '';

        if ($getData['target'] == 'districts') {
            $province = $this->provinceRepository->findById($getData['data']['location_id'], ['name', 'code'], ['districts']);
            $districts = $province->districts;
            $html = $this->renderHtml($districts);
        } elseif ($getData['target'] == 'wards') {
            $district = $this->districtRepository->findById($getData['data']['location_id'], ['name', 'code'], ['wards']);
            $wards = $district->wards;
            $html = $this->renderHtml($wards, '[Chọn Phường/Xã]');
        };

        $response = [
            'html' => $html,
        ];

        return response()->json($response);
    }

    // Render HTML
    public function renderHtml($locations, $root = '[Chọn Quận/Huyện]')
    {
        $html = '<option value="0">' . $root . '</option>';
        foreach ($locations as $location) {
            $html .= '<option value="' . $location->code . '">' . $location->name . '</option>';
        }
        return $html;
    }
}
