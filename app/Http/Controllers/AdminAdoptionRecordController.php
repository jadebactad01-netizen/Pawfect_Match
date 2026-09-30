<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class AdminAdoptionRecordController extends Controller
{
    /**
     * Show evaluated adoption applications.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = AdoptionApplication::with([
            'user',
            'pet',
            'compatibilityAssessment',
        ])
            ->whereHas('compatibilityAssessment')
            ->whereIn('status', [
                'Approved',
                'Rejected',
            ]);

        if (in_array($status, ['Approved', 'Rejected'])) {
            $query->where('status', $status);
        }

        $records = $query
            ->latest()
            ->get();

        return view(
            'admin.adoption-records.index',
            compact('records', 'status')
        );
    }


    /**
     * Show one adoption record.
     */
    public function show(AdoptionApplication $application)
    {
        if (! in_array(
            $application->status,
            ['Approved', 'Rejected']
        )) {
            abort(404);
        }

        $application->load([
            'user.adopterProfile',
            'pet',
            'compatibilityAssessment',
        ]);

        return view(
            'admin.adoption-records.show',
            compact('application')
        );
    }
}