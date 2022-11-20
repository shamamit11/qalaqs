@extends('email.admin.layout')
@section('content')
<table align="center" cellpadding="0" cellspacing="0" class="force-full-width" height="100%" width="100%">
    <tbody>
        <tr>
            <td align="center" class="" valign="top" width="100%" style="background: black; padding: 30px 0">
                <center class="">
                    <table cellpadding="0" cellspacing="0" class="w350" style="margin: 0 auto" width="600">
                        <tbody>
                            <tr>
                                <!-- header part -->
                                <td align="left" class="" valign="top">
                                    <table bgcolor="#fff" width="100%" cellpadding="0" cellspacing="0"
                                        class="force-full-width"
                                        style="margin: 0 auto; border-radius: 16px 16px 0px 0px">
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <table class="force-width-90" width="100%" style="margin: 0 auto">
                                                        <tbody>
                                                            <tr>
                                                                <td class="center" align="center" style="">
                                                                    <br />
                                                                    <br />
                                                                    <a id="darkLogo" data-click-track-id="8768"
                                                                        href="{{ url('') }}" target="_blank">
                                                                        <img class="" width="52" height="auto"
                                                                            alt="GRO app"
                                                                            src="{{ asset('images/gro-logo.png') }}" />
                                                                    </a>
                                                                    <br />
                                                                    <br />
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
                                    <table cellpadding="0" cellspacing="0" class="w350" style="margin: 0 auto"
                                        width="100%">
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
                                                                            class="force-width-90"
                                                                            style="margin: 0 auto">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td width="100%" style="
                                                  text-align: center;
                                                  font-size: 14px;
                                                  color: #181818;
                                                  line-height: 24px;
                                                  font-weight: normal;
                                                  padding-bottom: 15px;
                                                " class="aligncenter"><br />
                                                                                        You can reset password from
                                                                                        bellow link:<br />
                                                                                      <a
    href="{{ url('/admin/reset-password/'.$token)}}">Click
                                                                                            Here</a>.
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
                                        style="
                          margin: 0 auto;
                          margin: 0 auto;
                          border-radius: 0 0 16px 16px;

                          background: white;
                        ">
                                        <tbody>
                                            <tr>
                                                <td align="left" class="" valign="top">
                                                    <table cellpadding="0" cellspacing="0" class="force-width-90"
                                                        style="margin: 0 auto">
                                                        <tbody>
                                                            <tr>
                                                                <td style="
                                        font-family: 'Rubik', sans-serif;
                                        font-size: 14px;
                                        color: #181818;
                                        text-align: center;
                                        line-height: 24px;
                                        font-weight: normal;
                                        padding-bottom: 15px;
                                      " class="aligncenter">
                                                                    Thank you,
                                                                    <br />
                                                                    <a style="color: #fa0992 ;"
                                                                        href="{{ url('') }}"   >     GRO App</a>
                                                                    <br />
                                                                    <br />
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
