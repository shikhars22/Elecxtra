<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Welcome Admin</title>
<link rel="stylesheet" href="<?php echo base_url('admin_assets/css/dashboard.css'); ?>">
<link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
<?php echo $link_script; ?>
<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>

</head>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section  id="_wtBdySec" class="_wtWdArea _wtThmSec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h6 class="adminHead d_flex_evr py-3 m-0">Dashboard<small class="fs_13 ms-auto">Admin / Dashboar</small></h6>
            </div>

            <?php if($session_data['admin_role']=="superadmin"){ ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="order_user_info bg-info">
                    <div class="flex">
                        <div class="dig_info">
                            <h4>Total Website Visitor</h4>
                            <h1><?php echo $total_homepage_visitor; ?></h1>
                        </div>
                        <div class="icon_rnd text-center">
                            <i class="fa fa-eye"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="order_user_info bg_green">
                    <div class="flex">
                        <a href="<?php echo base_url('admin/approved-products'); ?>" class="dig_info text-white">
                            <h4>Approved Products</h4>
                            <h1><?php echo $total_approved_product; ?></h1>
                        </a>
                        <div class="icon_rnd text-center">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="order_user_info bg-warning">
                    <div class="flex">
                        <a href="<?php echo base_url('admin/pending-products'); ?>" class="dig_info text-dark">
                            <h4>Pending Products</h4>
                            <h1><?php echo $total_hold_product; ?></h1>
                        </a>
                        <div class="icon_rnd text-center">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="order_user_info bg-danger">
                    <div class="flex">
                        <a href="<?php echo base_url('admin/rejected-products'); ?>" class="dig_info text-white">
                            <h4>Rejected Products</h4>
                            <h1><?php echo $total_rejected_product; ?></h1>
                        </a>
                        <div class="icon_rnd text-center">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                <div class="order_user_info bg_purple">
                    <div class="flex">
                        <a href="<?php echo base_url('admin/hold-order'); ?>" class="dig_info text-white">
                            <h4>New Order</h4>
                            <h1><?php echo $total_hold_order; ?></h1>
                        </a>
                        <div class="icon_rnd text-center">
                            <i class="fa fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <h6 class="adminHead d_flex_evr py-3 m-0">New Orders <a href="<?php echo base_url('admin/hold-order'); ?>" class="fs_13 ms-auto"><u>Take Action</u></a></h6>
                <div class="table-responsive _scrollDx">
                    <table class="table" id="order_datatable">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Product</th>
                                <th>Product Info</th>
                                <th>Qty & Price</th>
                                <th>Order On</th>
                                <?php if($this->session->userdata('admin_role')=="superadmin"){ ?>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Seller</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tfoot style="display: none;">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php if($this->session->userdata('admin_role')=="superadmin"){ ?>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php } ?>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            
            <div class="col-lg-7 col-md-7 col-sm-12 col-12 mt-3">
                <div class="ui calendar" id="datePicker"></div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 col-12 mt-3">
                <div class="weatherBox">
                    <h3>Live Weather Forecast</h3>
                    <div class="description">
                        <h4 id="temp" class="d-inline-block"></h4>
                        <div id="icon" class="d-inline-block"></div>
                        <p class="current">Location:</p>
                        <div id="city"></div>
                        <br>
                        <p class="current">Current Status:</p>
                        <div id="status"></div>
                        <br/>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary fahrenheit active">
                            <input type="radio" name="options" id="Fahrenheit" autocomplete="off" checked> Fahrenheit
                            </label>
                            <label class="btn btn-primary celcius">
                            <input type="radio" name="options" id="Celcius" autocomplete="off"> Celcius
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
           <div class="col-lg-9 col-md-8 col-sm-12 col-12 mt-3">
                <div class="mapMarker" id="map_data">
                    <iframe id="mapDemo" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3316.0514112713463!2d151.19532321491974!3d-33.785170522153926!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12a922b8abb673%3A0x87ce0f54b6e0a821!2s2%2F72-74%20Lower%20Gibbes%20St%2C%20Chatswood%20NSW%202067%2C%20Australia!5e0!3m2!1sen!2sin!4v1622575772258!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy">
                        
                    </iframe>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 col-sm-12 col-12 mt-3">
                <div class="clockBg">
                    <div class="webina_clock"></div>
                </div>
            </div>

            
        </div>
    </div>

</section>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<!-- LOCATION JS -->
<script type="text/javascript">
var base_url="<?php echo base_url(); ?>";
var csrfName="<?php echo $csrfName; ?>";
var csrfHash="<?php echo $csrfHash; ?>";

var is_superadmin="<?php if($session_data['admin_role']=='superadmin'){echo "yes";}else{echo "no";} ?>";
var is_seller="<?php if($session_data['admin_role']=='seller'){echo "yes";}else{echo "no";} ?>";

var x = document.getElementById("mapDemo");
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}
function showPosition(position) {
  $("#map_data").html("<iframe width='100%' height='450' style='border:0;' allowfullscreen='' loading='lazy' src='https://maps.google.com/maps?q="+position.coords.latitude+","+position.coords.longitude+"&hl=en&z=14&amp;output=embed'></iframe>");
}
</script>

<!-- CLOCK JS -->
<script type="text/javascript">
var clock = document.createElement('div');
clock.setAttribute('class', 'clock');
$('.webina_clock').append(clock);

var minute_hand = document.createElement('div');
minute_hand.setAttribute('class', 'minute-hand');
$('.clock').append(minute_hand);

var hour_hand = document.createElement('div');
hour_hand.setAttribute('class', 'hour-hand');
$('.clock').append(hour_hand);

var second_hand = document.createElement('div');
second_hand.setAttribute('class', 'second-hand');
$('.clock').append(second_hand);

var pin = document.createElement('div');
pin.setAttribute('class', 'pin');
$('.clock').append(pin);

var time = document.createElement('div');
time.setAttribute('class', 'time');
$('.clock').append(time);


$(function() {
  setInterval(function(){
    var dt = new Date();
    //$('.time').text(dt);
  
    var sec_deg = dt.getSeconds() * (360/60);
    var min_deg = dt.getMinutes() * (360/60);
    var hr_deg = dt.getHours() * (360/12) + dt.getMinutes() * (360/60/12); //Edit thanks to Chris Neale: https://codepen.io/onion2k/

    $('.clock .second-hand').css({'-webkit-transform':'translate(-50%,-100%) rotate(' + sec_deg + 'deg)',   '-moz-transform':'translate(-50%,-100%) rotate(' + sec_deg + 'deg)', '-o-transform':'translate(-50%,-100%) rotate(' + sec_deg + 'deg)', '-ms-transform':'translate(-50%,-100%) rotate(' + sec_deg + 'deg)', 'transform':'translate(-50%,-100%) rotate(' + sec_deg  + 'deg)'});

    $('.clock .minute-hand').css({'-webkit-transform':'translate(-50%,-100%) rotate(' + min_deg + 'deg)', '-moz-transform':'translate(-50%,-100%) rotate(' + min_deg + 'deg)', '-o-transform':'translate(-50%,-100%) rotate(' + min_deg + 'deg)', '-ms-transform':'translate(-50%,-100%) rotate(' + min_deg + 'deg)', 'transform':'translate(-50%,-100%) rotate(' + min_deg + 'deg)'});

    $('.clock .hour-hand').css({'-webkit-transform':'translate(-50%,-100%) rotate(' + hr_deg + 'deg)', '-moz-transform':'translate(-50%,-100%) rotate(' + hr_deg + 'deg)', '-o-transform':'translate(-50%,-100%) rotate(' + hr_deg + 'deg)', '-ms-transform':'translate(-50%,-100%) rotate(' + hr_deg + 'deg)', 'transform':'translate(-50%,-100%) rotate(' + hr_deg + 'deg)'});
  
  }, 1000);
});

//WEATHER JS
$(function() {
  $.ajax({
    url: "https://geoip-db.com/jsonp",
    jsonpCallback: "callback",
    dataType: "jsonp",
    success: function(location) {
      var city = location.city,
        state = location.state,
        country = location.country_name,
        lat = location.latitude,
        long = location.longitude;

      $("#city").html(city + ", " + state + ", " + country);
      getWeather(lat, long);
    }
  });
});

function getWeather(lat, long) {
  $.ajax({
    url:
      "https://fcc-weather-api.glitch.me/api/current?lat=" +
        lat +
        "&lon=" +
        long,
    type: "get",
    success: function(data) {
      var temp = data.main.temp,
        tempC = Math.round(data.main.temp) + "&#8451;",
        tempF = Math.round(temp * 9 / 5 + 32) + "&#8457;",
        status = data.weather[0].main + " / " + data.weather[0].description,
        icon = data.weather[0].icon,
        humidity = data.main.humidity + "%";
      console.log(data, humidity);
      $("#icon").html("<img src='" + icon + "' />");
      $("#status").html(status + " / " + humidity + " humidity");
      $("#temp").html(tempF);

      $(".btn-primary").on("click", function(e) {
        e.preventDefault();
        $(this).addClass("active").siblings().removeClass("active");
        $(".celcius").hasClass("active")
          ? $("#temp").html(tempC)
          : $("#temp").html(tempF);
      });
    },
    error: function(error) {
      console.log(JSON.stringify(error));
    }
  });
}
</script>

<!-- CALENDAR JS -->
<script type="text/javascript">
$('#datePicker').calendar({
  inline: true
});

$(document).ready(function() {
    $('#order_datatable').DataTable({
        "pageLength" : 50,
        "lengthMenu" : [10, 20, 50, 100, 200],
        "language": {
            "lengthMenu": '_MENU_',
            "sSearch": "",
            "searchPlaceholder": "Search records"
        },
        "processing" : true,
        "serverSide" : true,
        "ajax":{
            url:base_url+"/elecxtra_admin/Admin_view_order/fetch_all_order",  
            type:"POST",
            data:{[csrfName]:csrfHash, status:"hold"}
        },
        "columnDefs":[
            (is_seller=="yes")?{"orderable":false, "targets":[1,4]}:{"orderable":false, "targets":[1,6]},
        ], 
    });
});
</script>
</body>
</html>