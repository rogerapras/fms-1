<? 
    require_once("inc/global.php"); 
    require_once(MODEL_PATH . SESSION_MODEL);
    require_once(MODEL_PATH . USERMENU_MODEL);
    require_once(MODEL_PATH . OPENREMINDERS_MODEL);
    require_once(MODEL_PATH . CONTROLNO_MODEL);
    require_once(CONTROLLER_PATH . CONTROLNO_CONTROLLER);
    require_once(MODEL_PATH . NOTIFICATION_MODEL);
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>FMS - Fleet Management System</title>
    <meta name="keywords" content="Fleet Management System" />
    <meta name="description" content="FMS - Fleet Management System">
    <meta name="author" content="FMS">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <? require_once(INCLUDE_PATH . "_font.php"); ?>
    <? require_once(INCLUDE_PATH . "_theme_css.php"); ?>
    <? require_once(INCLUDE_PATH . "_adminform_css.php"); ?>
    <? require_once(INCLUDE_PATH . "_favicon.php"); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <html dir="ltr" lang="en-US" class="no-js ie8">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>

<body class="admin-elements-page" data-spy="scroll" data-target="#nav-spy" data-offset="300">

    <? require_once(INCLUDE_PATH . "_theme.php"); ?>

    <!-- Start: Main -->
    <div id="main">

        <? require_once(INCLUDE_PATH . "_header.php"); ?>

        <? require_once(INCLUDE_PATH . "_sidebar.php"); ?>

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">

            <? //require_once(INCLUDE_PATH . "_topbarDropdown.php"); ?>

            <? //require_once(INCLUDE_PATH . "_topbar.php"); ?>

            <!-- Begin: Content -->
            <section id="content" class="table-layout animated fadeIn">

                <!-- begin: .tray-center -->
                <div class="tray tray-center ph30 va-t posr animated-delay animated-long" data-animate='["<?=$data_animate_time;?>","<?=$data_animate_type;?>"]'>
                    <div class="mw1100 center-block">

                        <? require_once(VIEW_PATH . V_CONTROLNOADD); ?>

                    </div>
                </div>
                <!-- end: .tray-center -->

            </section>
            <!-- End: Content -->

        </section>

        <? require_once(INCLUDE_PATH . "_sidebarRight.php"); ?>

    </div>
    <!-- End: Main -->

    <? require_once(INCLUDE_PATH . "_pageScript.php");?>
    <script type="text/javascript" src="assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#txtNoOfDigit').keyup(function () {
                if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                   this.value = this.value.replace(/[^0-9\.]/g, '');
                }
            });

            $('#txtLastDigit').keyup(function () {
                if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                   this.value = this.value.replace(/[^0-9\.]/g, '');
                }
            });

            $( "#controlno-form" ).validate({
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",

                rules: {
                    txtDescription: {
                            required: true
                    },
                    txtControlType: {
                            required: true
                    },
                    txtControlCode: {
                            required: true
                    },
                    txtNoOfDigit: {
                            required: true,
                            min: 1
                    },
                    txtLastDigit: {
                            required: true
                    }
                },

                messages:{
                    txtDescription: {
                            required: 'Please enter description!'
                    },
                    txtControlType: {
                            required: 'Please enter control type!'
                    },
                    txtControlCode: {
                            required: 'Please enter control code/prefix!'
                    },
                    txtNoOfDigit: {
                            required: 'Please enter no of digit',
                            min: 'Zero(0) is not allowed!'
                    },
                    txtLastDigit: {
                            required: 'Please enter last digit!'
                    }
                }
            });     
        });
    </script>

</body>
</html>
