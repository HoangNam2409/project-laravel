<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberManagementController extends Controller
{
    protected $userService;
    public function __construct() {}

    // changeStatus
    public function changeStatus(Request $request)
    {
        $post = $request->input();

        $serviceInterfaceNamespace = '\App\Services\\' . ucfirst($post['model']) . 'Service';
        if (class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
        }

        $flag = $serviceInstance->updateStatus($post);

        return response()->json([
            'flag' => $flag,
        ]);
    }

    // Change Status All
    public function changeStatusAll(Request $request)
    {
        $post = $request->input();

        $serviceInterfaceNamespace = '\App\Services\\' . ucfirst($post['model']) . 'Service';
        if (class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
        }

        $flag = $serviceInstance->updateStatusAll($post);

        return response()->json([
            'flag' => $flag,
        ]);
    }
}