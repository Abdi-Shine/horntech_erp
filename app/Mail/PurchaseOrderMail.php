<?php

namespace App\Mail;

use App\Models\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PurchaseOrder $po) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Purchase Order ' . $this->po->po_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase_order',
        );
    }
}
