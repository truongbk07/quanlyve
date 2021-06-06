<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class TestController extends Controller
{
    public function Test()
    {
        $client = Client::account('default');
        $client->connect();

        //Lấy email từ folder INBOX
        $Folder = $client->getFolder("INBOX");

        //Lấy email vietjet
        $aMessage = $Folder->query()->text('A4A9UP')->get();

        foreach($aMessage as $oMessage) 
        {
            
            //Lấy nội dung trong email
            $noi_dung_email = $oMessage->getHTMLBody();
            $noi_dung = str_get_html($noi_dung_email);
            //echo $noi_dung;
            break;
        }
            // Lấy nội dung chứa tên
            $ten = [];
            foreach ($noi_dung->find('[style="cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:16px;line-height:22px;;text-align:left;"]') as $e) {
                $ten[] = Str::before($e->plaintext, '&nbsp;');
            }
        
            //Lấy thông tin hành trình
            if($noi_dung->find('td[style="padding:0px 0px 0px 20px;border-collapse: collapse;cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:12px;font-weight:normal;line-height:16px;"]'))
            {
                //Bao hanh trinh qua view
                $khu_hoi=1;
                $chuyen_bay_di_s = $noi_dung->find('div>div[style="cursor:auto;color:#848EA3;font-family:trebuchet, sans-serif;font-size:12px;line-height:16px;"]');
                foreach($chuyen_bay_di_s as $chuyen_bay_di)
                {
                    $so_hieu_cb = $chuyen_bay_di->plaintext;
                    $so_hieu_cb = Str::after($so_hieu_cb, 'Số hiệu chuyến bay: ');
                    break;
                }

                $chuyen_bay_ve_s = $noi_dung->find('div[style="cursor:auto;color:#848EA3;font-family:trebuchet, sans-serif;font-size:12px;padding-bottom:10px;line-height:16px;display:inline"]');
                foreach($chuyen_bay_ve_s as $chuyen_bay_ve)
                {
                    $so_hieu_cb_ve = $chuyen_bay_ve->plaintext;
                    $so_hieu_cb_ve = Str::after($so_hieu_cb_ve, 'Số hiệu chuyến bay: ');
                    break;
                }

                $ngay_bay_di_s = $noi_dung->find('td[style="border-collapse: collapse;cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:12px;font-weight:normal;line-height:16px;"]');
                foreach($ngay_bay_di_s as $ngay_bay_di)
                {
                    $ngay_bay = $ngay_bay_di->plaintext;
                    break;
                }

                $ngay_bay_ve_s = $noi_dung->find('td[style="padding:0px 0px 0px 20px;border-collapse: collapse;cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:12px;font-weight:normal;line-height:16px;"]');
                foreach($ngay_bay_ve_s as $ngay_bay_ve)
                {
                    $ngay_bay_ve = $ngay_bay_ve->plaintext;
                    break;
                }

                $hanh_trinh=[];
                $content = $noi_dung->find('td[style="text-align:left;vertical-align:top;font-size:1px;padding:10px 20px 20px 20px;"]');
                foreach($content as $iteam)
                {
                    foreach($iteam->find('div[style="cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:12px;line-height:16px;"]') as $tam)
                    {
                        $hanh_trinh[]=$tam->plaintext;
                    }
                  
                }
                if($hanh_trinh!=null)
                {
                 //Day thong tin qua view
                return view('mat_ve.qh',compact('khu_hoi','ten','so_hieu_cb','so_hieu_cb_ve','ngay_bay','ngay_bay_ve','hanh_trinh'));
                }
                
            }

            else
            {
                $khu_hoi = 0;
                //Lấy số hiệu chuyến bay
                $ma_may_bay = $noi_dung->find('div>div[style="cursor:auto;color:#848EA3;font-family:trebuchet, sans-serif;font-size:12px;line-height:16px;"]','0')->plaintext;
                $so_hieu_cb = Str::after($ma_may_bay, 'Số hiệu chuyến bay: ');

                //Lấy ngày bay 
                $ngay_bay = $noi_dung->find('td[style="border-collapse: collapse;cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:12px;font-weight:normal;line-height:16px;"]','0')->plaintext;

                //Lấy hành trình
                $hanh_trinh = [];
                $content = $noi_dung->find('td[style="text-align:left;vertical-align:top;font-size:1px;padding:10px 20px 20px 20px;"]');
                foreach($content as $iteam)
                {
                    foreach ($iteam->find('div[style="cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:12px;line-height:16px;"]') as $ht)
                    { 
                        $hanh_trinh[] = $ht->plaintext;
                    }
                }
                //print_r($hanh_trinh);
                //Day thong tin qua view
                return view('mat_ve.qh',compact('khu_hoi','ten','so_hieu_cb','ngay_bay','hanh_trinh'));
            }
        
    }
}
