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
    /**
     * Display a listing of the notifications.
     *
     * @return View The view for displaying the notifications.
     */
    public function index(): View
    {
        return view('notifications.index', [
            'notifications' => Auth::user()
                ->notifications()
                ->paginate(10)
        ]);
    }

    /**
     * Display a single notification.
     *
     * @param DatabaseNotification $notification The notification to be displayed.
     * @return View The view for displaying a single notification.
     */
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
