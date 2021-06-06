<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;

class ImapController extends Controller
{
    public function getEmail()
    {
        $so_chang = 2;
        //Connect to the IMAP Server
        $client = Client::account('default');
        $client->connect();

        //Lấy email từ folder INBOX
        $Folder = $client->getFolder("INBOX");

        //Lấy email vietjet
        $aMessage = $Folder->query()->text('Reservation #MQZ4FH')->get();

        foreach($aMessage as $oMessage) 
        {
            
            //Lấy nội dung trong email
            $noi_dung_email = $oMessage->getHTMLBody();
            $noi_dung = str_get_html($noi_dung_email);
            
            // Lấy nội dung chứa tên
            $ten = [];
            foreach ($noi_dung->find('td>b>span') as $e) {
                $ten[] = $e->plaintext;
            }
        
            //Lấy thông tin hành trình
            $html = [];       
            foreach ($noi_dung->find('table[cellspacing]>tbody>tr>td') as $hanh_trinh)
            { 
                $html[] = $hanh_trinh->plaintext;
            }
        }
            
        //return view('mat_ve.vj',compact('ten','html','so_chang'));
        
    
    }
}
