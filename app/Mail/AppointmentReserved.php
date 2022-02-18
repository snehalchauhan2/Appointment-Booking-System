<?php

namespace LaraBooking\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use LaraBooking\Models\Appointment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentReserved extends Mailable
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
        $subject = 'A new appointment was reserved';
        // Get the company email (or the default email)
        $companyEmail = settings('company_email', config('mail.from.address'));

        return $this->from($companyEmail)
                    ->to($companyEmail)
                    ->subject($subject)
                    ->view('emails.appointments.reserved');
    }
}
