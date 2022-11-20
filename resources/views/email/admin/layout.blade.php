<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <style type="text/css"></style>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />

    <title>Gro App</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,900;1,400&display=swap"
        rel="stylesheet" />
    <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap);

    /* Take care of image borders and formatting */
    img {
        max-width: 600px;
        outline: none;
        text-decoration: none;
        -ms-interpolation-mode: bicubic;
        position: relative;
    }

    .left {
        text-align: left;
    }

    a {
        text-decoration: none;
        border: 0;
        outline: none;
        color: #bbbbbb;
    }

    a img {
        border: none;
    }

    /* General styling */
    td,
    h1,
    h2,
    h3 {
        font-family: "Rubik", sans-serif;
        font-weight: 400;
    }

    td {
        text-align: center;
    }

    body {
        -webkit-font-smoothing: antialiased;
        -webkit-text-size-adjust: none;
        width: 100%;
        height: 100%;
        color: #37302d;
        background: #ffffff;
        font-size: 14px;
    }

    table {
        border-collapse: collapse !important;
    }

    .headline {
        color: #ffffff;
        font-size: 30px;
    }

    .force-full-width {
        width: 100% !important;
    }

    .force-width-80 {
        width: 80% !important;
    }

    .force-width-90 {
        width: 90% !important;
    }

    .aligncenter {
        text-align: center;
    }

    .alighleft {
        text-align: left !important;
    }

    :root {
        color-scheme: light dark;
        supported-color-schemes: light dark;
    }

    @media (prefers-color-scheme: dark) {
        #darkLogo {
            display: none !important;
        }

        #lightLogo {
            display: block !important;
        }
    }
    </style>
    <style media="screen" type="text/css">
    @media screen {

        /*Thanks Outlook 2013! https://goo.gl/XLxpyl*/
        td,
        h1,
        h2,
        h3 {
            font-family: "Rubik", sans-serif !important;
        }
    }
    </style>
    <style media="only screen and (max-width: 480px)" type="text/css">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {
        table[class="w350"] {
            width: 350px !important;
        }

        td[class="mobile-block"] {
            width: 100% !important;
            display: block !important;
        }

        .force-width-80 {
            width: 90% !important;
        }

        .force-full-width {
            margin-left: 5px !important;
            margin-right: 5px !important;
            width: calc(100% - 10px) !important;

            background: #fff !important;
        }
    }
    </style>
</head>

<body bgcolor="#FFFFFF" style="
      padding: 0;
      margin: 0;
      display: block;
      background: #ffffff;
      -webkit-text-size-adjust: none;
    ">
  @yield('content')
</body>

</html>
