@extends('email.supplier.layout')
@section('content')
<table align="center" cellpadding="0" cellspacing="0" class="force-full-width" height="100%" width="100%">
    <tbody>
        <tr>
            <td align="center" class="" valign="top" width="100%">
                <center class="">
                    <table cellpadding="0" cellspacing="0" class="w350" style="margin: 0 auto" width="650">
                        <tbody>
                            <tr>
                                <!-- header part -->
                                <td align="left" class="" valign="top">
                                    <table bgcolor="#fff" width="100%" cellpadding="0" cellspacing="0"
                                        class="force-full-width"
                                        style="margin: 0 auto; border-radius: 16px 16px 0px 0px">
                                        <tbody class="">
                                            <tr class="">
                                                <td style="">
                                                    <table class="force-width-95" width="100%" style="margin: 0 auto">
                                                        <tbody>
                                                            <tr>
                                                                <td class="left" align="center" style="
                                        padding-top: 25px;
                                        padding-bottom: 10px;
                                      ">
                                                                    <a href="{{ env('APP_URL') }}" target="_blank">
                                                                        <img class="" width="90px" height="auto"
                                                                            src="{{ asset('images/logo.png') }}" />
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <!-- body part -->
                            <tr>
                                <td align="left">
                                    <table cellpadding="0" cellspacing="0" width="100%" class="w350"
                                        style="margin: 0 auto">
                                        <tbody>
                                            <tr>
                                                <td align="left" class="" valign="top">
                                                    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0"
                                                        class="force-full-width" style="margin: 0 auto">
                                                        <tbody>
                                                            <tr class="">
                                                                <td class="" style="
                                        background-color: #ffffff;
                                        color: #e6e6e6;
                                      ">
                                                                    <center class="">
                                                                        <table cellpadding="0" cellspacing="0"
                                                                            class="force-width-95"
                                                                            style="margin: 0 auto">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td width="100%" style="
                                                  font-family: 'Poppins',
                                                    sans-serif;
                                                  color: #181818;
                                                  text-align: left;
                                                  font-weight: normal;
                                                " class="aligncenter">
                                                                                   
                                                                                        <br />
                                                                                        <h3 class="fs26" style="
                                                    margin-top: 0;
                                                    margin-bottom: 0;
                                                    font-weight: 400;
                                                    color: #000;
                                                    text-align: center;
                                                  ">
                                                                                            Please use the verification code below
                                                                                        </h3>

                                                                                        <br />
                                                                                        <br />
                                                                                        <p class="fs62" style="
                                                    margin-top: 5px;
                                                    line-height: 20px;
                                                    color: #000;
                                                    text-align: center;
                                                    letter-spacing: 15px;
                                                  ">
                                                                                            {{ $otp }}
                                                                                        </p>
                                                                                        <br />
                                                                                        <br />
                                                                                        <br />
                                                                                        <div style="
                                                    background-color: #f1f1f1;
                                                    padding: 15px;
                                                  ">
                                                                                            <h3 class="fs16" style="
                                                      margin-top: 0;
                                                      margin-bottom: 0;
                                                      font-weight: 400;
                                                      color: #000;
                                                      text-align: center;
                                                    ">
                                                                                                If you did'nt request,
                                                                                                you
                                                                                                can ignore this mail or
                                                                                                let
                                                                                                us know.
                                                                                            </h3>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- End body -->
                            <!-- footer start -->
                            <tr>
                                <td align="left" class="" valign="top">
                                    <table bgcolor="#fff" class="force-full-width" cellpadding="0" cellspacing="0"
                                        style="margin: 0 auto">
                                        <tbody>
                                            <tr>
                                                <td align="left" class="" valign="top">
                                                    <table cellpadding="0" cellspacing="0" class="force-width-95"
                                                        style="margin: 0 auto">
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color: #fd9d8c"
                                                                    class="aligncenter">
                                                                    <p class="fs20" style="
                                          color: #fff;
                                          padding: 15px;
                                          font-weight: 600;
                                        ">
                                                                        “.......”
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </td>
        </tr>
    </tbody>
</table>
@endsection