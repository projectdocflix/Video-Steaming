<?php

namespace App\Http\Services;

use App\Models\User;

class EmailSendService
{
    public function sendPreviewEmail($slug, $email)
    {
        $emailData = getEmailTemplate($slug, []);
        return commonEmailSend($email, $emailData, 1);
    }

    public function sendVerifyEmail($user, $link): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{LINK}}' => $link,
        ];

        $emailData = getEmailTemplate('verify-email', $viewData);
        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData, 1);
        }

        return true;
    }

    public function sendForgetPasswordEmail($user, $code): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{VERIFICATION_CODE}}' => $code,
        ];

        $emailData = getEmailTemplate('forget-password', $viewData);
        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData, 1);
        }
        return true;
    }

    public function sendInstructorRequestToAdmin($targetUrl, $isInstructor = true): bool
    {
        $users = $this->allAdminUsers();
        $email = $users->pluck('email');
        $viewData = [
            '{{URL}}' => $targetUrl,
        ];

        if ($isInstructor) {
            $emailData = getEmailTemplate('instructor-request-to-admin', $viewData);
        } else {
            $emailData = getEmailTemplate('organization-request-to-admin', $viewData);
        }

        if ($emailData['status']) {
            return commonEmailSend($email, $emailData);
        }

        return true;
    }

    public function sendNewEnrollEmailToInstructor($user_id, $course, $targetUrl): bool
    {
        $user = User::where('id', $user_id)->first();
        if (!is_null($user)) {
            $viewData = [
                '{{USER_NAME}}' => $user->name,
                '{{URL}}' => $targetUrl,
                '{{COURSE_TITLE}}' => $course->title,
            ];

            $emailData = getEmailTemplate('new-student-enroll-to-instructor', $viewData);

            if ($emailData['status']) {
                return commonEmailSend($user->email, $emailData);
            }
        }
        return true;
    }

    public function sendNewEnrollEmailToAdmin($course): bool
    {
        $users = $this->allAdminUsers();
        $email = $users->pluck('email');
        $viewData = [
            '{{COURSE_TITLE}}' => $course->title,
        ];

        $emailData = getEmailTemplate('new-student-enroll-to-admin', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($email, $emailData);
        }
        return true;
    }

    public function sendNewEnrollEmailToStudent($user, $course, $url): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{COURSE_TITLE}}' => $course->title,
            '{{URL}}' => $url,
        ];

        $emailData = getEmailTemplate('new-student-enroll-to-student', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendBankPendingOrderToAdmin($order, $url): bool
    {
        $users = $this->allAdminUsers();
        $email = $users->pluck('email');
        $viewData = [
            '{{ORDER_NUMBER}}' => $order->order_number,
            '{{URL}}' => $url,
        ];

        $emailData = getEmailTemplate('course-buy-pending-admin', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($email, $emailData);
        }
        return true;
    }

    public function sendBankPendingOrderToStudent($user, $order): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{ORDER_NUMBER}}' => $order->order_number
        ];

        $emailData = getEmailTemplate('course-buy-pending-student', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendSubscriptionPurchasePendingEmailToAdmin($url): bool
    {
        $users = $this->allAdminUsers();
        $email = $users->pluck('email');
        $viewData = [
            '{{URL}}' => $url,
        ];

        $emailData = getEmailTemplate('subscription-purchase-pending-admin', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($email, $emailData);
        }
        return true;
    }

    public function sendSubscriptionPurchaseEmailToAdmin($url): bool
    {
        $users = $this->allAdminUsers();
        $email = $users->pluck('email');
        $viewData = [
            '{{URL}}' => $url,
        ];

        $emailData = getEmailTemplate('subscription-purchase-complete-admin', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($email, $emailData);
        }
        return true;
    }

    public function sendSubscriptionPurchaseEmailToStudent($user): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
        ];

        $emailData = getEmailTemplate('subscription-purchase-complete-student', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendInstructorRefundRequest($user, $link): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{LINK}}' => $link
        ];

        $emailData = getEmailTemplate('instructor-refund-request', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function allAdminUsers()
    {
        return User::where('role', USER_ROLE_ADMIN)->get();
    }

    public function sendCoInstructorRequestApproved($user_id, $instructor): bool
    {
        $user = User::where('id', $user_id)->first();
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{INSTRUCTOR_NAME}}' => $instructor->name
        ];

        $emailData = getEmailTemplate('multi-instructor-request-approved', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendCoInstructorRequestRejected($user_id, $instructor): bool
    {
        $user = User::where('id', $user_id)->first();
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{INSTRUCTOR_NAME}}' => $instructor->name
        ];

        $emailData = getEmailTemplate('multi-instructor-request-rejected', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendWithdrawalRequestToAdmin($link): bool
    {
        $users = $this->allAdminUsers();
        $email = $users->pluck('email');
        $viewData = [
            '{{URL}}' => $link,
        ];

        $emailData = getEmailTemplate('withdrawal-request-to-admin', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($email, $emailData);
        }

        return true;
    }

    public function sendWithdrawalRequestToUser($user, $link): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{LINK}}' => $link
        ];

        $emailData = getEmailTemplate('withdrawal-request-to-user', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function walletRechargeToAdmin($link): bool
    {
        $users = $this->allAdminUsers();
        $email = $users->pluck('email');
        $viewData = [
            '{{URL}}' => $link,
        ];

        $emailData = getEmailTemplate('wallet-recharge-complete-admin', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($email, $emailData);
        }
        return true;
    }

    public function walletRechargePendingToAdmin($link): bool
    {
        $users = $this->allAdminUsers();
        $email = $users->pluck('email');
        $viewData = [
            '{{URL}}' => $link,
        ];

        $emailData = getEmailTemplate('wallet-recharge-pending-admin', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($email, $emailData);
        }
        return true;
    }

    public function walletRechargeToUser($user, $link): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{LINK}}' => $link
        ];

        $emailData = getEmailTemplate('wallet-recharge-complete-user', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendRefundRequestRejectedToUser($user, $feedback): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{FEEDBACK}}' => $feedback
        ];

        $emailData = getEmailTemplate('refund-request-rejected-student', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendRefundRequestAcceptedToUser($user): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name
        ];

        $emailData = getEmailTemplate('refund-request-accepted-student', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendAffiliateStatusChange($user, $status): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name
        ];

        if($status){
            $emailData = getEmailTemplate('affiliate-request-approved', $viewData);
        }else{
            $emailData = getEmailTemplate('affiliate-request-rejected', $viewData);
        }

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendNewNoticeToStudent($user_ids, $link): bool
    {
        $emails = User::whereIn('id', $user_ids)->select('email')->pluck('email')->toArray();
        $viewData = [
            '{{LINK}}' => $link
        ];

        $emailData = getEmailTemplate('new-notice-created-student', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($emails, $emailData);
        }
        return true;
    }

    public function sendConsultationBookingRequestCancelToUser($user, $link, $feedback): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{LINK}}' => $link,
            '{{FEEDBACK}}' => $feedback
        ];

        $emailData = getEmailTemplate('consultation-booking-cancel-student', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendNewLiveClassToStudent($user_ids, $link): bool
    {
        $emails = User::whereIn('id', $user_ids)->select('email')->pluck('email')->toArray();
        $viewData = [
            '{{LINK}}' => $link,
        ];

        $emailData = getEmailTemplate('live-class-added-student', $viewData);

        if ($emailData['status']) {
            return commonEmailSend($emails, $emailData);
        }
        return true;
    }

    public function sendCommonUserAndLink($user, $link, $template): bool
    {
        $viewData = [
            '{{USER_NAME}}' => $user->name,
            '{{LINK}}' => $link,
        ];

        $emailData = getEmailTemplate($template, $viewData);

        if ($emailData['status']) {
            return commonEmailSend($user->email, $emailData);
        }
        return true;
    }

    public function sendCommonLink($user_ids, $link, $template): bool
    {
        $emails = User::whereIn('id', $user_ids)->select('email')->pluck('email')->toArray();
        $viewData = [
            '{{LINK}}' => $link,
        ];

        $emailData = getEmailTemplate($template, $viewData);

        if ($emailData['status']) {
            return commonEmailSend($emails, $emailData);
        }
        return true;
    }


}
