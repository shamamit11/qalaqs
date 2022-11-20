@extends('email.app.layout')
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
                                                                            src="{{ asset('images/gro-logo.png') }}" />
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
                                                  font-size: 14px;
                                                  color: #181818;
                                                  text-align: center;
                                                  line-height: 24px;
                                                  font-weight: normal;
                                                " class="aligncenter">
                                                                                        <!-- @yield('content') -->

                                                                                        <div style="
                                                    background-color: #63d1d9;
                                                    padding: 15px;
                                                  ">
                                                                                            <br />
                                                                                            <br />
                                                                                            <p class="fs26" style="
                                                      font-weight: 400;
                                                      font-size: 16px;
                                                      margin: 0;
                                                      margin-bottom: 6px;
                                                      color: #fff;
                                                    ">
                                                                                                Welcome to
                                                                                            </p>

                                                                                            <br />
                                                                                            <img src="{{ asset('images/gro_white.png') }}"
                                                                                                width="100px" />
                                                                                            <br />
                                                                                            <br />
                                                                                            <p class="fs20" style="
                                                      font-weight: 400;
                                                      font-size: 12px;
                                                      color: #fff;
                                                      display: inline-block;
                                                      line-height: 1.4;
                                                      padding-bottom: 15px;
                                                    ">
                                                                                                {{ $parent_name }}.
                                                                                                Thanks for registering
                                                                                                with us. We are looking
                                                                                                forward to be the guide
                                                                                                in your child's growth
                                                                                                tracking.
                                                                                            </p>
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
                                                                        “The best way to track your kid’s
                                                                        growth”
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