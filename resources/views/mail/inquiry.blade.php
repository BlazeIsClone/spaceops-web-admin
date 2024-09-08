@extends('mail.template')

@section('body')
    <table width="100%">
        <thead>
            <tr>
                <th colspan="2" style="text-align: center; margin: 30px 0; padding: 20px 0; font-size: 18px;">
                    {{ __('Inquiry') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @isset($body['name'])
                <tr>
                    <th width="40%"
                        style="text-align: left; background-color: #eee; padding: 10px 14px; border: 1px solid #e3e3e3;">
                        {{ __('Name') }}
                    </th>
                    <td style="border: 1px solid #e3e3e3; padding: 10px 14px;">
                        {{ $body['name'] }}
                    </td>
                </tr>
            @endisset

            @isset($body['email'])
                <tr>
                    <th style="text-align: left; background-color: #eee;padding: 10px 14px; border: 1px solid #e3e3e3;">
                        {{ __('Email Address') }}
                    </th>
                    <td style="border: 1px solid #e3e3e3; padding: 10px 14px;">
                        {{ $body['email'] }}
                    </td>
                </tr>
            @endisset

            @isset($body['phone'])
                <tr>
                    <th style="text-align: left; background-color: #eee;padding: 10px 14px; border: 1px solid #e3e3e3;">
                        {{ __('Contact Number') }}
                    </th>
                    <td style="border: 1px solid #e3e3e3; padding: 10px 14px;">
                        {{ $body['phone'] }}
                    </td>
                </tr>
            @endisset

            @isset($body['message'])
                <tr>
                    <th style="text-align: left; background-color: #eee; padding: 10px 14px; border: 1px solid #e3e3e3;"
                        valign="top">
                        {{ __('Message') }}
                    </th>
                    <td style="border: 1px solid #e3e3e3; padding: 10px 14px;">
                        {{ $body['message'] }}
                    </td>
                </tr>
            @endisset
        </tbody>
    </table>
@endsection()
