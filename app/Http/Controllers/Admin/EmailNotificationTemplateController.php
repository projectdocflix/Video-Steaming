<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\EmailSendService;
use App\Models\NotificationEmailTemplate;
use App\Tools\Repositories\Crud;
use App\Traits\General;
use App\Traits\ResponseTrait;
use Auth;
use Illuminate\Http\Request;

class EmailNotificationTemplateController extends Controller
{
    use ResponseTrait, General;

    protected $model;

    public function __construct(NotificationEmailTemplate $email_template)
    {
        $this->model = new Crud($email_template);
    }

    public function index()
    {
        if (!Auth::user()->can('email_notification_template')) {
            abort('403');
        } // end permission checking


        $data['title'] = 'Email Notification Template';
        $data['email_templates'] = $this->model->getOrderById('DESC', 25);
        $data['navEmailNotificationActiveClass'] = 'mm-active';
        return view('admin.email_notification_templates.index', $data);
    }

    public function edit($slug)
    {
        if (!Auth::user()->can('email_notification_template')) {
            abort('403');
        } // end permission checking

        $data['title'] = 'Email Notification Template';
        $data['navEmailNotificationActiveClass'] = 'mm-active';
        $data['template'] = $this->model->getRecordById($slug);
        return view('admin.email_notification_templates.edit', $data);
    }

    public function view($slug)
    {
        if (!Auth::user()->can('email_notification_template')) {
            return $this->error([], __('You dont have any permission'));
        } // end permission checking

        $data['title'] = 'Edit Email Template';
        $data['navEmailNotificationActiveClass'] = 'mm-active';
        $data['template'] = $this->model->getRecordById($slug);
        return view('admin.email_notification_templates.view', $data);
    }

    public function update(Request $request, $slug)
    {
        if (!Auth::user()->can('user_management')) {
            abort('403');
        } // end permission checking

        $this->model->updateBySlug($request->only($this->model->getModel()->fillable), $slug); // update tag
        $this->showToastrMessage('success', __('Updated Successful'));
        return redirect()->route('email-notification.index');
    }

    public function sendTestMail(Request $request, $slug)
    {
        if (!Auth::user()->can('user_management')) {
            return $this->error([], __('You dont have any permission'));
        } // end permission checking

        $email = $request->email;
        $sendMail = new EmailSendService();

        if($sendMail->sendPreviewEmail($slug, $email)){
            return $this->success([], __('Send Successfully'));
        }

        return $this->error([], __('Something went wrong!'));
    }
}
