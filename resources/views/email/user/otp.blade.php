@extends('email.vendor.layout')
@section('content')
<div id="wrapper" dir="ltr"
    style="background-color: #f7f7f7; margin: 0; padding: 70px 0; width: 100%; -webkit-text-size-adjust: none;">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container"
                    style="background-color: #ffffff; border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); border-radius: 3px;">
                    <tr>
                        <td align="center" valign="top">
                            <!-- Header -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600"
                                style='background-color: #000; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; border-radius: 3px 3px 0 0;'>
                                <tr>
                                    <td id="header_wrapper" style="padding: 36px 48px; display: block;">
                                        <h1
                                            style='font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #753368; color: #ffffff;'>
                                        Account Verification Code</h1>
                                    </td>
                                </tr>
                            </table>
                            <!-- End Header -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- Body -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600">
                                <tr>
                                    <td valign="top" id="body_content" style="background-color: #ffffff;">
                                        <!-- Content -->
                                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                            <tr>
                                                <td valign="top" style="padding: 48px 48px 0;">
                                                    <div id="body_content_inner"
                                                        style='color: #303030; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;'>
                                                        <p style="margin: 0 0 16px;">Hello,</p>
                                                        <p style="margin: 0 0 16px;"> Please use the verification code below to verifiy your account</p>
                                                        <p style="margin: 0 0 16px;"> {{ $otp }}</p>
                                                        <p>&nbsp; <br />
                                                        </p>
                                                        <p> If you did'nt request, you can ignore this mail or let us know.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- End Content -->
                                    </td>
                                </tr>
                            </table>
                            <!-- End Body -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- Footer -->
                            <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                                <tr>
                                    <td valign="top" style="padding: 0; border-radius: 6px;">
                                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                            <tr>
                                                <td colspan="2" valign="middle" id="credit"
                                                    style='border-radius: 6px; border: 0; color: #303030; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 12px; line-height: 125%; text-align: center; padding: 0 48px 48px 48px;'>
                                                    <p style="text-align:center ">
                                                        <img src="{{ asset('assets/supplier/images/logo.png') }}"
                                                            style="width:100px">
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- End Footer -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
@endsection