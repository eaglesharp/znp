@extends('admin.layouts.email_template')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%; border-bottom: solid 1px #ccc;">
    <tr>
        <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
            <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: left; padding-top: 20px;">Employer Help &amp; Support Request</div>
        </td>
    </tr>
    <tr>
        <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">
            <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                <tr>
                    <td class="row" valign="top" style="padding:12px">
                        <p style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;color:#333;">
                            <strong>Company:</strong> {{ $company_name }}<br>
                            <strong>Contact email:</strong> {{ $company_email }}<br>
                            @if(!empty($company_phone))
                            <strong>Phone:</strong> {{ $company_phone }}<br>
                            @endif
                            @if(!empty($job_title))
                            <strong>Job context:</strong> {{ $job_title }} (ID #{{ $job_id }})<br>
                            @endif
                            <strong>Topic:</strong> {{ $category ?: 'Not specified' }}<br>
                            <br>
                            <strong>Message:</strong><br>
                            {!! nl2br(e($message_body)) !!}
                        </p>
                        <p style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#666;">
                            Reply directly to this email to reach the employer.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
