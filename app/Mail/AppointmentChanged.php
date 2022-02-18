<?php

namespace LaraBooking\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use LaraBooking\Models\Appointment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The appointment instance.
     *
     * @var Appointment
     */
    public $appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Your appointment with ' . settings('company_name') . ' has been modified';
        // Get the company email (or the default email)
        $fromEmail = settings('company_email', config('mail.from.address'));

        return $this->from($fromEmail)
                    ->subject($subject)
                    ->view('emails.appointments.changed');
    }
}
