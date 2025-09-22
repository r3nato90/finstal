<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateRequest;
use App\Models\EmailSmsTemplate;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{

    /**
     * @return View
     */
    public function template(): View
    {
        $setTitle = __('admin.setting.page_title.template');
        $templates = EmailSmsTemplate::latest()->paginate(getPaginate());

        return view('admin.notification.templates', compact(
            'setTitle',
            'templates'
        ));

    }

    /**
     * @param int|string $id
     * @return View
     */
    public function edit(int|string $id): View
    {
        $setTitle =  __('admin.setting.page_title.template_update');
        $template = EmailSmsTemplate::find($id);

        return view('admin.notification.edit', compact(
            'setTitle',
            'template'
        ));
    }


    /**
     * @param TemplateRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(TemplateRequest $request, $id): RedirectResponse
    {
        $template = EmailSmsTemplate::findOrFail($id);
        $template->update($request->validated());

        return back()->with('notify', [['success', __('admin.setting.notify.notification.update')]]);
    }
}
