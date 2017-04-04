<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use Exception;

class ReportController extends Controller
{
    public function send(Request $request, MailController $mail) {
        $email = $request->input('email');
        $event_id = $request->input('event_id');
        $guilty_id = $request->input('guilty_id');
        $text = $request->input('message');
        $reason = $request->input('reason');

        try {
            $mail->send_report($email, $event_id, $guilty_id, $text, $reason);
        } catch (Exception $e) {
            $response = [];
            $response['status'] = 'fail';
            $response['message'] = 'Что то пошло не так...';
            return json_encode($response);
        }

        $response = [];
        $response['status'] = 'success';
        $response['message'] = 'Жалоба отправленна!';
        $response['close_modal'] = true;
        return json_encode($response); 
    }
}
