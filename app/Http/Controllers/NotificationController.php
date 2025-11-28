<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldData;
use App\Models\Page;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        return view('notifications.index', [
            'notifications' => Auth::user()
                ->notifications()
                ->paginate(10)
        ]);
    }

    public function show(DatabaseNotification $notification): View
    {
        $notification->markAsRead();

        $fieldData = FieldData::find($notification->data['field_data_id']);

        return view('notifications.show', [
            'field' => Field::find($fieldData->field_id),
            'notification' => $notification,
            'page' => Page::find($notification->data['page_id'])
        ]);
    }
}
