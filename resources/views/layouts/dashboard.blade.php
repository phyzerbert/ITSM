<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Open Graph Meta-->
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Emirates IT Help Desk">
        <meta property="og:title" content="ITSM - IT HelpDesk">
        <meta property="og:image" content="{{asset('images/favicon.png')}}>
        <meta property="og:description" content="Emirates IT Help Desk is a game changer in turning IT teams from daily fire-fighting to delivering awesome customer service. It provides great visibility and central control in dealing with IT issues to ensure that businesses suffer no downtime.">
        <title>Emirates IT Help Desk</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{asset('front/img/favicon.png')}}" rel="icon">
        <!-- Font-icon css-->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{asset('main/css/daterangepicker.min.css')}}">
        <!-- Main CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('main/css/main.css') }}">
    </head>
    <body class="app sidebar-mini rtl">
        <header class="app-header">
            @include('layouts.header')            
        </header>
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar">
            @include('layouts.aside')
        </aside>
        <main class="app-content">
            <input type="hidden" id="role" value="{{Auth::user()->role_id}}" />
            @yield('content')
        </main>

        <!-- Essential javascripts for application to work-->
        <script src="{{ asset('main/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('main/js/popper.min.js') }}"></script>
        <script src="{{ asset('main/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('main/js/main.js') }}"></script>
        <script src="{{ asset('main/js/pusher.min.js') }}"></script>
        <script src="{{ asset('main/js/notification.js') }}"></script>
        <script src="{{ asset('main/js/plugins/pace.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('main/js/plugins/bootstrap-notify.min.js') }}"></script>

            @yield('script')
        
        <!-- Google analytics script-->
        <script type="text/javascript">
            var notification = '<?php echo session()->get("success"); ?>';
            if(notification != ''){
                $.notify({
                    title: "Message : ",
                    message: notification,
                    icon: 'fa fa-check' 
                },{
                    type: "success"
                });
            }
            var errors_string = '<?php echo json_encode($errors->all()); ?>';
            errors_string=errors_string.replace("[","").replace("]","").replace(/\"/g,"");
            var errors = errors_string.split(",");
            if (errors_string != "") {
                for (let i = 0; i < errors.length; i++) {
                    const element = errors[i];
                    $.notify({
                        title: "Error : ",
                        message: element,
                        icon: 'fa fa-exclamation-circle' 
                    },{
                        type: "danger"
                    });                
                } 
            }
        </script>
    </body>
</html>