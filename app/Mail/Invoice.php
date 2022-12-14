<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Auth;
use Illuminate\Queue\SerializesModels;
ini_set("allow_url_fopen", 1);
class Invoice extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = Auth::user();
        $order_number = $this->details[0]->orderId;
        $this->orderCSV($this->details);
          $path = asset('/public/mail/'.$this->details[0]->orderId.'.csv');
        return $this->subject("Order # $order_number from $user->username")
            ->view('emails.invoice',['maildata'=>$this->details])->attach($path);
    }
    
    public function orderCSV($maildata) {
        
    $path = public_path('/mail/'.$maildata[0]->orderId.'.csv');

    $file = fopen($path, 'w');
    $columns = array(
        'Sku',
        'Item', 
        'Category',
        'Price',
        'Quantity',
        'Totals'
        );

    fputcsv($file, $columns);
    foreach ( $maildata as $line ) {
         $data = [
                'Sku' => $line->product_sku,  
                'Item' => $line->product_name,  
                'Category' => $line->product_category,   
                'Price' => '$'.$line->unit_price,  
                'Quantity' => $line->quantity,  
                'Totals' => '$'.$line->price,
            ];
     fputcsv($file, $data);
    }
    $data = [
                 'Sku' => "",  
                'Item' => "",  
                'Category' => "",   
                'Price' => "",  
                'Quantity' => "",  
                'Totals' => '$'.$line->amount,
            ];
     fputcsv($file, $data);
  
    fclose($file);
}
    
    
    
    
    
}
