<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Message' }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; line-height: 1.6; color: #1f2933; }
        .wrapper { max-width: 640px; margin: 0 auto; padding: 24px; background-color: #ffffff; border: 1px solid #e4e7eb; border-radius: 8px; }
        h1 { font-size: 22px; margin-bottom: 16px; color: #101840; }
        p { margin: 0 0 12px; }
        .footer { margin-top: 24px; font-size: 12px; color: #7b8794; }
    </style>
</head>
<body>
    <div class="wrapper">
        @if(!empty($title))
            <h1>{{ $title }}</h1>
        @endif

        <p>{!! nl2br(e($messageBody)) !!}</p>

        <div class="footer">
            @if(!empty($fromAddress))
                <p>From: {{ $fromAddress }}</p>
            @endif
            @if(!empty($sentDate))
                <p>Sent: {{ \Illuminate\Support\Carbon::parse($sentDate)->toDayDateTimeString() }}</p>
            @endif
        </div>
    </div>
</body>
</html>

