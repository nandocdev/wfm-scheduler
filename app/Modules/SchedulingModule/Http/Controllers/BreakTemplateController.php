<?php

namespace App\Modules\SchedulingModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchedulingModule\Models\BreakTemplate;
use Illuminate\Contracts\View\View;

class BreakTemplateController extends Controller {
    public function create(): View {
        $this->authorize('create', BreakTemplate::class);

        return view('scheduling::create-break-template');
    }
}
