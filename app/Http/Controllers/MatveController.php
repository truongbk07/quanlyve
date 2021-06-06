<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Str;
use App\Models\Macode;
use App\Models\Ten;
use App\Models\HanhTrinh;

class MatveController extends Controller
{
    public function thong_tin_ve()
    {
        $ma_codes = Macode::join('tens','ma_codes.id','=','tens.macode_id')
                          ->join('hanh_trinhs','ma_codes.id','=','hanh_trinhs.macode_id')
                          ->select('ma_codes.id','ma_codes.code','tens.ten','hanh_trinhs.chuyenbay','hanh_trinhs.ngaybay','hanh_trinhs.noidi','hanh_trinhs.noiden')
                          ->orderby('ma_codes.id','DESC')
                          ->get();
        return view('tao_ve',compact('ma_codes'));
    }

    public function xu_ly_ve(Request $request)
    {
        $hang_bay = $request->hang_bay;
        $ma_code = $request->ma_code;
        $ma_code = Str::upper($ma_code);
        
        // Ket noi email
        $client = Client::account('default');
        $client->connect();

        //Lấy email từ folder INBOX
        $Folder = $client->getFolder("INBOX");

        //Lấy email vietjet
        $aMessage = $Folder->query()->text($ma_code)->get();
    
        if($aMessage->count()>0)
        {
            foreach($aMessage as $oMessage) 
            {
                
                //Lấy nội dung trong email
                $noi_dung_email = $oMessage->getHTMLBody();
                $noi_dung = str_get_html($noi_dung_email);
                break;
            }  
            
            if($hang_bay==1)
            {
                // Lấy nội dung chứa tên
                $ten = [];
                foreach ($noi_dung->find('td>b>span') as $e) {
                    $ten[] = $e->plaintext;
                }
                //Lấy thông tin hành trình
                $hanh_trinh = [];       
                foreach ($noi_dung->find('table[cellspacing]') as $iteam)
                { 
                    foreach($iteam->find('tr>td') as $ht)
                    {
                    $hanh_trinh[] = $ht->plaintext;
                    }
                    break;
                }
                //print_r($hanh_trinh);
                if(!empty($hanh_trinh[5]))
                {
                    // Luu du lieu vao db
                    if(Macode::where('code',$ma_code)->first()===null)
                    {
                        // Luu MaCode
                        $macode = new Macode;
                        $macode->code = $ma_code;
                        $macode->save();

                        // Luu Ten
                        for($i=0;$i<count($ten);$i++)
                        {
                            $tens = new Ten;
                            $tens->ten = $ten[$i];
                            $tens->macode_id = Macode::where('code',$ma_code)->value('id');
                            $tens->save();
                        }

                        // Luu hanh trinh
                        $hanhtrinhdi = new HanhTrinh;
                        $hanhtrinhdi->chuyenbay = $hanh_trinh[0];
                        $hanhtrinhdi->ngaybay = $hanh_trinh[1];
                        $hanhtrinhdi->giobay = Str::before($hanh_trinh[3],' -');
                        $hanhtrinhdi->noidi = Str::after($hanh_trinh[3],'- ');
                        $hanhtrinhdi->gioden = Str::before($hanh_trinh[4],' -');
                        $hanhtrinhdi->noiden = Str::after($hanh_trinh[4],'- ');
                        $hanhtrinhdi->macode_id = Macode::where('code',$ma_code)->value('id');
                        $hanhtrinhdi->save();

                        $hanhtrinhve = new HanhTrinh;
                        $hanhtrinhve->chuyenbay = $hanh_trinh[5];
                        $hanhtrinhve->ngaybay = $hanh_trinh[6];
                        $hanhtrinhve->giobay = Str::before($hanh_trinh[8],' -');
                        $hanhtrinhve->noidi = Str::after($hanh_trinh[8],'- ');
                        $hanhtrinhve->gioden = Str::before($hanh_trinh[9],' -');
                        $hanhtrinhve->noiden = Str::after($hanh_trinh[9],'- ');
                        $hanhtrinhve->macode_id = Macode::where('code',$ma_code)->value('id');
                        $hanhtrinhve->save();
                        return back();
                    }
                    else
                    {
                        echo "Macode da duoc them vao db";
                    }
                }
                else
                {
                    // Luu du lieu vao db
                    if(Macode::where('code',$ma_code)->first()===null)
                    {
                        // Luu MaCode
                        $macode = new Macode;
                        $macode->code = $ma_code;
                        $macode->save();

                        // Luu Ten
                        for($i=0;$i<count($ten);$i++)
                        {
                            $tens = new Ten;
                            $tens->ten = $ten[$i];
                            $tens->macode_id = Macode::where('code',$ma_code)->value('id');
                            $tens->save();
                        }

                        // Luu hanh trinh
                        $hanhtrinhs = new HanhTrinh;
                        $hanhtrinhs->chuyenbay = $hanh_trinh[0];
                        $hanhtrinhs->ngaybay = $hanh_trinh[1];
                        $hanhtrinhs->giobay = Str::before($hanh_trinh[3],' -');
                        $hanhtrinhs->noidi = Str::after($hanh_trinh[3],'- ');
                        $hanhtrinhs->gioden = Str::before($hanh_trinh[4],' -');
                        $hanhtrinhs->noiden = Str::after($hanh_trinh[4],'- ');
                        $hanhtrinhs->macode_id = Macode::where('code',$ma_code)->value('id');
                        $hanhtrinhs->save();
                        return back();
                    }
                    else
                    {
                        echo "Macode da duoc them vao db";
                    }
                }
            }

            if($hang_bay==3)
            {
                // Lấy nội dung chứa tên
                $ten = [];
                foreach ($noi_dung->find('[style="cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:16px;line-height:22px;;text-align:left;"]') as $e) {
                    $ten[] = Str::before($e->plaintext, '&nbsp;');
                }
            
                //Lấy thông tin hành trình
                if($noi_dung->find('td[style="padding:0px 0px 0px 20px;border-collapse: collapse;cursor:auto;color:#424853;font-family:trebuchet, sans-serif;font-size:12px;font-weight:normal;line-height:16px;"]'))
                {
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
                    // Luu du lieu vao db
                        if(Macode::where('code',$ma_code)->first()===null)
                        {
                            // Luu MaCode
                            $macode = new Macode;
                            $macode->code = $ma_code;
                            $macode->save();

                            // Luu Ten
                            for($i=0;$i<count($ten);$i++)
                            {
                                $tens = new Ten;
                                $tens->ten = Str::of($ten[$i])->trim();
                                $tens->macode_id = Macode::where('code',$ma_code)->value('id');
                                $tens->save();
                            }

                            // Luu hanh trinh
                            $hanhtrinhdi = new HanhTrinh;
                            $hanhtrinhdi->chuyenbay = Str::of($so_hieu_cb)->trim();
                            $hanhtrinhdi->ngaybay = Str::of($ngay_bay)->trim();
                            $hanhtrinhdi->giobay = Str::of($hanh_trinh[0])->trim();
                            $hanhtrinhdi->noidi = Str::of($hanh_trinh[1])->trim();
                            $hanhtrinhdi->gioden = Str::of($hanh_trinh[2])->trim();
                            $hanhtrinhdi->noiden = Str::of($hanh_trinh[3])->trim();
                            $hanhtrinhdi->macode_id = Macode::where('code',$ma_code)->value('id');
                            $hanhtrinhdi->save();

                            $hanhtrinhve = new HanhTrinh;
                            $hanhtrinhve->chuyenbay = Str::of($so_hieu_cb_ve)->trim();
                            $hanhtrinhve->ngaybay = Str::of($ngay_bay_ve)->trim();
                            $hanhtrinhve->giobay = Str::of($hanh_trinh[4])->trim();
                            $hanhtrinhve->noidi = Str::of($hanh_trinh[5])->trim();
                            $hanhtrinhve->gioden = Str::of($hanh_trinh[6])->trim();
                            $hanhtrinhve->noiden = Str::of($hanh_trinh[7])->trim();
                            $hanhtrinhve->macode_id = Macode::where('code',$ma_code)->value('id');
                            $hanhtrinhve->save();
                            return back();
                        }
                        else
                        {
                            echo "Macode da duoc them vao db";
                        }
                    }
                    
                }

                else
                {
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
                    
                    // Luu du lieu vao db
                    if(Macode::where('code',$ma_code)->first()===null)
                    {
                        // Luu MaCode
                        $macode = new Macode;
                        $macode->code = $ma_code;
                        $macode->save();

                        // Luu Ten
                        for($i=0;$i<count($ten);$i++)
                        {
                            $tens = new Ten;
                            $tens->ten = Str::of($ten[$i])->trim();
                            $tens->macode_id = Macode::where('code',$ma_code)->value('id');
                            $tens->save();
                        }

                        // Luu hanh trinh
                        $hanhtrinhs = new HanhTrinh;
                        $hanhtrinhs->chuyenbay = Str::of($so_hieu_cb)->trim();
                        $hanhtrinhs->ngaybay = Str::of($ngay_bay)->trim();
                        $hanhtrinhs->giobay = Str::of($hanh_trinh[0])->trim();
                        $hanhtrinhs->noidi = Str::of($hanh_trinh[1])->trim();
                        $hanhtrinhs->gioden = Str::of($hanh_trinh[2])->trim();
                        $hanhtrinhs->noiden = Str::of($hanh_trinh[3])->trim();
                        $hanhtrinhs->macode_id = Macode::where('code',$ma_code)->value('id');
                        $hanhtrinhs->save();
                        return back();
                    }
                    else
                    {
                        echo "Macode da duoc them vao db";
                    }
                }
            }
        }
        else
        {
            return back()->with('khong-co-code','Mã code không tồn tại trong Mail');
        }
    }

    public function mat_ve($id)
    {
        $macode = MaCode::where('id',$id)->first();
        $ten = Ten::where('macode_id',$id)->get();
        $hanhtrinh = HanhTrinh::where('macode_id',$id)->get();
        $hangbay = HanhTrinh::where('macode_id',$id)->value('chuyenbay');

        if(Str::substr($hangbay,0,2)=="VJ")
        {
            return view('mat_ve.vj',compact('macode','ten','hanhtrinh'));
        }

        if(Str::substr($hangbay,0,2)=="QH")
        {
            return view('mat_ve.qh',compact('macode','ten','hanhtrinh'));
        }

    }

}
