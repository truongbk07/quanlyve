<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BambooAirways</title>
    <link rel="icon" type="image/png" href="https://www.bambooairways.com/vn-vi/wp-content/themes/bamboo/resources/assets/images/favicon@2x.png" sizes="32x32">
    <style type="text/css" media="all">

        body{
            font-family:Calibri,Sans-serif;
            font-size: 11px;
            color: #000000;
            background-color: #ffffff;
        }
        
        table{
            padding-left:0px;
            padding-right:0px;
            margin-top:3px;
            margin-bottom:8px;
            font-size:11px;
            empty-cells:show;
            border:1px #FFFFFF;
            width:100%;
        }

        th{
            font-style:normal;
            font-weight:bold;
            font-size:14px;
            padding:3px;
            padding-left:5px;
            padding-right:5px;
            text-align:left;
            background-color:rgba(40, 40, 40, 0.5);
            color:#FFFFFF;
        }

        td{
            /*background-color:rgba(195, 195, 195, 0.5);*/
            padding-left:0px;
            padding-right:0px;
            align:left;
            font-size:14px;
        }

        .tdbackground-none td{
            background-color:#FFF;
        }
        h1{
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            padding: 1px 0px;
            margin: 5px 0px;
            color:#5ab535;  
        }
        h2{
            font-size : 20px;
            margin: 0px 0px;
            color:#ffffff;
            background :#5ab535;
            font-weight:bold;
            padding-left:10px;
            padding-right:10px;
        }

        h3{
            font-size: 20px;
            text-align: left;
        }
        
        h4{
            font-size: 20px;
            color: #fff;
        }
        
        .content{
            width:800px;
        }
        </style>
</head>
<body>
    <div style="margin:0 auto;width:800px;">
    <div style="clear:both;"></div>
    <div class="content">
    <!-- CONTENT -->
    <!--DONE-->
    <h1>VÉ ĐIỆN TỬ VÀ XÁC NHẬN HÀNH TRÌNH</h1>
    
    <h2>Mã đặt chỗ:</h2>
    <table style="margin-top: 10px;">		
        <tr class="tdbackground-none">
            <td style="text-align: center;background-color: #c3c3c380;"><span style="font-size:25px;color:#5ab535;text-align:center;">{{ $macode->code }}</span></td>
            <td colspan=3 align="right"style="padding-right: 50px">
                <img src="https://www.bambooairways.com/vn-vi/wp-content/themes/bamboo/resources/assets/images/logo-bas-big.png"/>
            </td>  
        </tr>
    </table>
    <h2> 1. Thông tin đặt chỗ</h2>
    <table>
        <tr align="left">	    
             
            <th style = "background:#58585a;color:#ffffff;">Trạng thái đặt chỗ</th>
            <td>Đã xác nhận</td>
    
             <th style = "background:#58585a;color:#ffffff;">Liên hệ:</th>
            <td>0934824414 (mobile)</td>
        </tr>
        <tr align="left">
            <th style = "background:#58585a;color:#ffffff;">Ngày đặt:</th>
            <td>{{ date("d/m/Y") }}</td>
            <th style = "background:#58585a;color:#ffffff;">Email</th>
            <td>phongvethanhan247@gmail.com</td>
        </tr>
    </table>
    <h2> 2. Thông tin hành khách</h2>
    <table>
       <tr> 
          <th style = "background:#58585a;color:#ffffff;" >Tên hành khách</th>
       </tr>
       @foreach ($ten as $ten)
       <tr>
          <td><b><span style="font-size:25px">{{ $ten->ten }}</span></b><br /></td>
       </tr>
       @endforeach
    </table>
    <h2> 3. Thông tin chuyến bay </h2>
    <table cellspacing="0px">
      <thead>
        <th style = "background:#58585a;color:#ffffff;" >Chuyến bay</th>
        <th style = "background:#58585a;color:#ffffff;" >Ngày bay</th>
        <th style = "background:#58585a;color:#ffffff;" >Khởi hành</th>
        <th style = "background:#58585a;color:#ffffff;" >Đến</th>
      </thead>
      <tbody>
        @foreach ($hanhtrinh as $ht) 
        <tr>
            <td>{{$ht->chuyenbay}}</td>
            <td>{{$ht->ngaybay}}</td>
            <td>{{$ht->giobay.'-'.$ht->noidi}}</td>
            <td>{{$ht->gioden.'-'.$ht->noiden}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>