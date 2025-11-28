<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FieldDataOutOfRange extends Notification
{
    use Queueable;

    private $fieldData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fieldData)
    {
        $this->fieldData = $fieldData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $latestHistory = $this->fieldData->fieldDataHistories()
            ->latest('created_at')
            ->first();

        $minimum = $this->fieldData->field->minimum ?? 'N/A';
        $maximum = $this->fieldData->field->maximum ?? 'N/A';
        $userName = optional($latestHistory->user)->full_name ?? 'Unknown User';

        $message = <<<EOT
            User '$userName' entered value '{$this->fieldData->value}' for '{$this->fieldData->field->name}' on page
            '{$this->fieldData->field->page->name} ({$this->fieldData->page_date})'. This is out of range
            ($minimum-$maximum).
            EOT;

        return [
            'field_data_id' => $this->fieldData->id,
            'maximum' => $this->fieldData->field->maximum,
            'message' => $message,
            'minimum' => $this->fieldData->field->minimum,
            'page_id' => $this->fieldData->field->page_id,
            'page_date' => $this->fieldData->page_date,
            'value' => $this->fieldData->value,
            'user_id' => $latestHistory->user_id,
        ];
    }
}
