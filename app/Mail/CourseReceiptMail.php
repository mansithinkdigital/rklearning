<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $course;
    public $receiptPath;

    public function __construct($user, $course, $receiptPath)
    {
        $this->user = $user;
        $this->course = $course;
        $this->receiptPath = $receiptPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Course Enrollment Receipt - ' . $this->course->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.course_receipt',
        );
    }


    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path($this->receiptPath))
                ->as('Receipt_' . time() . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
