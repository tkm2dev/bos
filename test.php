<!DOCTYPE html>
<html>

<head>
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>สมัคร-อัพเดทข้อมูล</title>
   <script src="https://static.line-scdn.net/liff/edge/1.0/sdk.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
   </script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cascading-dropdown/1.2.9/jquery.cascadingdropdown.min.js"></script>

   <script>
      function getname(sel) {

         var select2 = sel.options[sel.selectedIndex].text;
         document.getElementById("txb_noname").value = select2;
         //alert(select2);
         // $("#txb_noname").text(select2);
      }


      $.ajax({
         type: "GET",
         // url: "https://javis-s.com/_service.php?s=get_position",
         url: "get_position.json",
         dataType: "JSON",
         success: function(data) {

            var s = '<option value="">เลือก</option>';
            for (var i = 0; i < data.length; i++) {
               s += '<option value="' + data[i].position_id + '">' + data[i].position_name_short_th +
                  '</option>';
            }
            $("#sig_position2").html(s);

         }
      });


      //init LIFF
      function initializeApp(data) {

         //取得用戶身分
         var userid = data.context.userId;
         console.log(userid);

         document.getElementById('txb_uid').value = userid;
         fetch('https://javis-s.com/_service.php?s=getuser&id=' + userid)
            .then(response => response.json())
            .then(data => {
               // Parse the JSON data and access the values
               const noname = data[0].noname;
               const name = data[0].name;
               const lname = data[0].lname;
               //const lname = data[0].lname;
               const uder = data[0].uder;
               const phone = data[0].phone;
               var uid = data[0].uid;
               // Set the values as the value of the text fields
               document.getElementById('txb_name').value = name;
               document.getElementById('txb_lname').value = lname;
               document.getElementById('txb_under').value = uder;
               document.getElementById('txb_phone').value = phone;

            });
      }


      function AddRecord(txb_noname, txb_name, txb_lname, txb_under, step1, step2, step3, txb_phone, booklist_kk_name, txb_province, txb_uid, sig_position2) {
         // 資料檢查

         if (txb_noname == '' || txb_name == '' || txb_lname == '' || txb_under == '' || step1 == '' || step2 == '' || step3 == '' || txb_phone == '' || booklist_kk_name == '' || txb_province == '') {
            alert('บันทึกข้อมูลไม่ครบ!');
            return;
         }



         // 構建請求的 URL
         const url = 'https://javis-s.com/_service.php?s=updateuser';

         // 構建請求的參數
         const params = new URLSearchParams();
         params.append('uid', txb_uid);
         params.append('sig_position2', sig_position2);
         params.append('txb_noname', txb_noname);
         params.append('txb_name', txb_name);
         params.append('txb_lname', txb_lname);
         params.append('txb_under', txb_under);
         params.append('step1', step1);
         params.append('step2', step2);
         params.append('step3', step3);
         params.append('txb_phone', txb_phone);
         params.append('booklist_kk_name', booklist_kk_name);
         params.append('txb_province', txb_province);

         // 發送請求
         fetch(url, {
               method: 'POST',
               body: params
            })
            .then(response => {
               if (!response.ok) {
                  throw new Error('Network response was not ok');
               }
               return response.json();
               alert(response);
            })
            .then(data => {
               // 插入成功，顯示提示消息
               // alert('บันทึกข้อมูลเรียบร้อยแล้ว!');


               //             liff.closeWindow();

               var msg = "ขอบคุณสำหรับการอัพเดทข้อมูล\n สามารถใช้งานได้ปกติ";

               //把訊息以用戶的身分發送給LINE Bot
               liff.sendMessages([{
                     type: 'text',
                     text: msg
                  }])
                  .then(() => {
                     //建立成功，關閉視窗
                     liff.closeWindow();
                  });

            })
            .catch(error => {
               // 處理錯誤
               console.error('Error:', error);
               alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล ');
            });



      }


      $(document).ready(function() {
         //init LIFF
         liff.init(function(data) {
            initializeApp(data);
         });


         //當選擇的消費分類改變時
         // $('#sel_type').change(function() {
         //     //把值填入textbox
         //     $('#txb_type').val($('#sel_type').find(":selected").text().trim());
         // });

         //按下新增鈕
         $('#btn_addRecord').click(function(e) {
            //新增
            AddRecord($('#txb_noname').val(), $('#txb_name').val(), $('#txb_lname').val(), $(
               '#txb_under').val(), $('#step1').val(), $('#step2').val(), $('#step3').val(), $('#txb_phone').val(), $('#booklist_kk_name').val(), $('#txb_province').val(), $('#txb_uid').val(), $('#sig_position2').val());
         });
      });
   </script>


   <style type="text/css">
      /* css กำหนดความกว้าง ความสูงของแผนที่ */
      #map_canvas {
         width: auto;
         height: 200px;
         margin: auto;
         /*  margin-top:100px;*/
      }
   </style>

</head>

<body>
   <div class="row" style="margin: 10px">
      <div class="col-12" style="margin: 10px">
         <div class="form-group">

            <input type="text" id="txb_noname" name="txb_noname">



            <label for="name" class="col-form-label">ยศ</label>
            <!-- <input type="text" class="form-control" id="sig_position2" name="sig_position2" required> -->
            <select name="sig_position2" id="sig_position2" onChange="getname(this);" class="form-control" required>
               <option value="">โปรดเลือก</option>
            </select>


            <label>ชื่อ</label>
            <input type="text" id="txb_name" name="txb_name" class="form-control" required>

            <label>สกุล</label>
            <input type="text" id="txb_lname" name="txb_name" class="form-control" required>
            <label>ตำแหน่ง</label>
            <input type="text" id="txb_under" class="form-control" required>


            <div class="card-body register-card-body" id="org_select">



               <div class="form-group">
                  <div class="col-md-12">
                     <select name="step1" id="step1" class="form-control" required>
                        <option value="">กองบัญชาการ</option>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-md-12">
                     <select name="step2" id="step2" class="form-control" required>
                        <option value="">กองบังคับการ</option>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-md-12">
                     <select name="step3" id="step3" class="form-control" required>
                        <option value="">กองกำกับการ</option>
                     </select>
                  </div>
               </div>

            </div>
            <input type="hidden" id="booklist_kk_name" name="booklist_kk_name">
            <input type="hidden" id="txb_uid" name="txb_uid">
            <label>เบอร์โทร</label>
            <input type="text" id="txb_phone" class="form-control" required>


            <label>
               <font color="red">*เลือกจังหวัดที่ท่านสามารถทำงานได้เพื่อรองรับฟีเจอร์ใหม่</font>
            </label>
            <select name="txb_province" id="txb_province" class="form-control" required>
               <option value="" selected>--เลือกจังหวัด --</option>
               <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
               <option value="กระบี่">กระบี่ </option>
               <option value="กาญจนบุรี">กาญจนบุรี </option>
               <option value="กาฬสินธุ์">กาฬสินธุ์ </option>
               <option value="กำแพงเพชร">กำแพงเพชร </option>
               <option value="ขอนแก่น">ขอนแก่น</option>
               <option value="จันทบุรี">จันทบุรี</option>
               <option value="ฉะเชิงเทรา">ฉะเชิงเทรา </option>
               <option value="ชัยนาท">ชัยนาท </option>
               <option value="ชัยภูมิ">ชัยภูมิ </option>
               <option value="ชุมพร">ชุมพร </option>
               <option value="ชลบุรี">ชลบุรี </option>
               <option value="เชียงใหม่">เชียงใหม่ </option>
               <option value="เชียงราย">เชียงราย </option>
               <option value="ตรัง">ตรัง </option>
               <option value="ตราด">ตราด </option>
               <option value="ตาก">ตาก </option>
               <option value="นครนายก">นครนายก </option>
               <option value="นครปฐม">นครปฐม </option>
               <option value="นครพนม">นครพนม </option>
               <option value="นครราชสีมา">นครราชสีมา </option>
               <option value="นครศรีธรรมราช">นครศรีธรรมราช </option>
               <option value="นครสวรรค์">นครสวรรค์ </option>
               <option value="นราธิวาส">นราธิวาส </option>
               <option value="น่าน">น่าน </option>
               <option value="นนทบุรี">นนทบุรี </option>
               <option value="บึงกาฬ">บึงกาฬ</option>
               <option value="บุรีรัมย์">บุรีรัมย์</option>
               <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์ </option>
               <option value="ปทุมธานี">ปทุมธานี </option>
               <option value="ปราจีนบุรี">ปราจีนบุรี </option>
               <option value="ปัตตานี">ปัตตานี </option>
               <option value="พะเยา">พะเยา </option>
               <option value="พระนครศรีอยุธยา">พระนครศรีอยุธยา </option>
               <option value="พังงา">พังงา </option>
               <option value="พิจิตร">พิจิตร </option>
               <option value="พิษณุโลก">พิษณุโลก </option>
               <option value="เพชรบุรี">เพชรบุรี </option>
               <option value="เพชรบูรณ์">เพชรบูรณ์ </option>
               <option value="แพร่">แพร่ </option>
               <option value="พัทลุง">พัทลุง </option>
               <option value="ภูเก็ต">ภูเก็ต </option>
               <option value="มหาสารคาม">มหาสารคาม </option>
               <option value="มุกดาหาร">มุกดาหาร </option>
               <option value="แม่ฮ่องสอน">แม่ฮ่องสอน </option>
               <option value="ยโสธร">ยโสธร </option>
               <option value="ยะลา">ยะลา </option>
               <option value="ร้อยเอ็ด">ร้อยเอ็ด </option>
               <option value="ระนอง">ระนอง </option>
               <option value="ระยอง">ระยอง </option>
               <option value="ราชบุรี">ราชบุรี</option>
               <option value="ลพบุรี">ลพบุรี </option>
               <option value="ลำปาง">ลำปาง </option>
               <option value="ลำพูน">ลำพูน </option>
               <option value="เลย">เลย </option>
               <option value="ศรีสะเกษ">ศรีสะเกษ</option>
               <option value="สกลนคร">สกลนคร</option>
               <option value="สงขลา">สงขลา </option>
               <option value="สมุทรสาคร">สมุทรสาคร </option>
               <option value="สมุทรปราการ">สมุทรปราการ </option>
               <option value="สมุทรสงคราม">สมุทรสงคราม </option>
               <option value="สระแก้ว">สระแก้ว </option>
               <option value="สระบุรี">สระบุรี </option>
               <option value="สิงห์บุรี">สิงห์บุรี </option>
               <option value="สุโขทัย">สุโขทัย </option>
               <option value="สุพรรณบุรี">สุพรรณบุรี </option>
               <option value="สุราษฎร์ธานี">สุราษฎร์ธานี </option>
               <option value="สุรินทร์">สุรินทร์ </option>
               <option value="สตูล">สตูล </option>
               <option value="หนองคาย">หนองคาย </option>
               <option value="หนองบัวลำภู">หนองบัวลำภู </option>
               <option value="อำนาจเจริญ">อำนาจเจริญ </option>
               <option value="อุดรธานี">อุดรธานี </option>
               <option value="อุตรดิตถ์">อุตรดิตถ์ </option>
               <option value="อุทัยธานี">อุทัยธานี </option>
               <option value="อุบลราชธานี">อุบลราชธานี</option>
               <option value="อ่างทอง">อ่างทอง </option>
            </select>



            <!-- 


            
            <div class="form-group">
                <label>ข้อมูลตำแหน่ง</label>
                <button onclick="getLocation2()" class="btn btn-success btn-block">กดรับตำแหน่ง</button>


                <div id="map_canvas" class="border border-success"></div>


                <input type="text" id="txb_lat" class="form-control" placeholder="Latitude" disabled />
                <input type="text" id="txb_log" class="form-control" placeholder="Longitude" disabled />
               
            </div>
            <div class="form-group">
            <label>วันที่สำรวจ</label>
            <input type="date" id="txb_datetime" value="" class="form-control" />
            </div>
            <div class="form-group">
            <label >ประเภทสำรวจ</label> <br />
                <label>
                    <input type="checkbox" class="form-control" value="1" name="fooby[1][]" />บ้าน/ที่พัก  </label>
                <label>
                    <input type="checkbox" class="form-control" value="1" name="fooby[1][]" />บุคคลพ้นโทษ  </label>
                <label>
                    <input type="checkbox" class="form-control" value="1" name="fooby[1][]" />อาวุธปืน</label>
            </div>

            <div class="form-group">
            <label>รายละเอียดเพิ่มเติม</label>
          
            <input type="text" id="txb_memo" class="form-control" />
            </div> -->
            <br />
            <button class="btn btn-primary btn-block" id="btn_addRecord">สมัคร-อัพเดทข้อมูล</button>

         </div>
      </div>


      <!-- <script>
    var lat = document.getElementById("txb_lat");
    var log = document.getElementById("txb_log");
    lat.setAttribute("value", position.coords.latitude);
    log.setAttribute("value", position.coords.longitude);


    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        lat.innerHTML = "Latitude: " + position.coords.latitude;
        lat.setAttribute("value", position.coords.latitude);
        log.innerHTML = "Longitude: " + position.coords.longitude;
        log.setAttribute("value", position.coords.longitude);


    }
    </script> -->




      <!-- <script type="text/javascript">
    var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
    var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
    function initialize() { // ฟังก์ชันแสดงแผนที่
        GGM = new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
        // กำหนดจุดเริ่มต้นของแผนที่
        var my_Latlng = new GGM.LatLng(13.761728449950002, 100.6527900695800);
        var my_mapTypeId = GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง
        // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
        var my_DivObj = $("#map_canvas")[0];
        // กำหนด Option ของแผนที่
        var myOptions = {
            zoom: 17, // กำหนดขนาดการ zoom
            center: my_Latlng, // กำหนดจุดกึ่งกลาง
            mapTypeId: my_mapTypeId // กำหนดรูปแบบแผนที่
        };
        map = new GGM.Map(my_DivObj, myOptions); // สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map



        // เรียกใช้คุณสมบัติ ระบุตำแหน่ง ของ html 5 ถ้ามี
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = new GGM.LatLng(position.coords.latitude, position.coords.longitude);
                var infowindow = new GGM.InfoWindow({
                    map: map,
                    position: pos,
                    content: 'ตำแหน่ง อยู่ที่นี่.'
                });

                var my_Point = infowindow.getPosition(); // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย
                map.panTo(my_Point); // ให้แผนที่แสดงไปที่ตัว marker       
                $("#latitude").val(my_Point.lat()); // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
                $("#longitude").val(my_Point.lng()); // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value 
                lat.innerHTML = "Latitude: " + position.coords.latitude;
                lat.setAttribute("value", position.coords.latitude);
                log.innerHTML = "Longitude: " + position.coords.longitude;
                log.setAttribute("value", position.coords.longitude);




                map.setCenter(pos);
            }, function() {
                // คำสั่งทำงาน ถ้า ระบบระบุตำแหน่ง geolocation ผิดพลาด หรือไม่ทำงาน
            });
        } else {
            // คำสั่งทำงาน ถ้า บราวเซอร์ ไม่สนับสนุน ระบุตำแหน่ง
        }

        // กำหนด event ให้กับตัวแผนที่ เมื่อมีการเปลี่ยนแปลงการ zoom
        GGM.event.addListener(map, 'zoom_changed', function() {
            $("#zoom_value").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value  
        });

    }


    function getLocation2() {
        // โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
        // ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
        // v=3.2&sensor=false&language=th&callback=initialize
        //  v เวอร์ชัน่ 3.2
        //  sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
        //  language ภาษา th ,en เป็นต้น
        //  callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize
        $("<script/>", {
            "type": "text/javascript",
            src: "//maps.google.com/maps/api/js?v=3.2&sensor=false&language=th&callback=initialize"
        }).appendTo("body");
    }



    $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    }); -->

      <script>
         $(document).ready(function() {
            $("#step3").change(function() {
               var selectedOption = $(this).children("option:selected").text();
               $("#booklist_kk_name").val(selectedOption);
            });
         });
      </script>
      <script>
         $('#org_select').cascadingDropdown({
            selectBoxes: [{
                  selector: '#step1',
                  source: function(request, response) {
                     // $.getJSON('_service.php?s=get_bureaus', request, function(data) {
                     $.getJSON('get_bureaus.json', request, function(data) {
                        var selectOnlyOption = data.length <= 1;
                        response($.map(data, function(item, index) {
                           //console.log(item);
                           return {
                              label: item.ORG,
                              value: item.ORG_CODE,
                              selected: selectOnlyOption // Select if only option
                           };
                        }));

                     });
                  }
               },
               {
                  selector: '#step2',
                  requires: ['#step1'],
                  source: function(request, response) {
                     $.getJSON('tb_policestations.json', request, function(data) {
                        var selectOnlyOption = data.length <= 1;
                        response($.map(data, function(item, index) {
                           return {
                              label: item.ORG_ABBR,
                              value: item.ORG_CODE,
                              selected: selectOnlyOption // Select if only option
                           };
                        }));

                     });
                  }
               },
               {
                  selector: '#step3',
                  requires: ['#step1', '#step2'],
                  requireAll: true,
                  source: function(request, response) {
                     $.getJSON('tb_policestations.json', request, function(data) {
                        response($.map(data, function(item, index) {
                           return {
                              label: item.ORG_ABBR,
                              value: item.ORG_CODE,
                              selected: index == 0 // Select first available option
                           };
                        }));

                     });
                  },

               }
            ]
         });
      </script>


</body>

</html>