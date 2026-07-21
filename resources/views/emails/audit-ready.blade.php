@php
    $score = $overallScore;
    $scoreColour = $score === null ? '#9ca3af'
        : ($score >= 90 ? '#166534'
        : ($score >= 75 ? '#16a34a'
        : ($score >= 50 ? '#c2410c' : '#b91c1c')));
    $scoreLabel = $score === null ? 'Not scored'
        : ($score >= 90 ? 'Excellent'
        : ($score >= 75 ? 'Good'
        : ($score >= 50 ? 'Needs work' : 'Poor')));
    $greeting = $leadName ? "Hi " . explode(' ', $leadName)[0] . "," : "Hi,";
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your website audit for {{ $domain }} is ready</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #111; background: #f4f4f6; margin: 0; padding: 32px;">
    <div style="max-width: 620px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden;">

        {{-- Header banner in the We Are Jungle brand navy --}}
        <div style="padding: 28px 32px; background: #0F1B2D; color: #fff;">
            <p style="margin: 0 0 6px; font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.6);">Website audit ready</p>
            <h1 style="margin: 0; font-size: 24px; letter-spacing: -0.02em;">{{ $domain }}</h1>
        </div>

        <div style="padding: 28px 32px;">
            <p style="margin: 0 0 20px; font-size: 15px; line-height: 1.6; color: #1f2937;">
                {{ $greeting }} your website audit for <strong>{{ $domain }}</strong> is ready to view. It covers technical setup, page structure, content quality, and how quickly your site loads on mobile and desktop.
            </p>

            {{-- Score summary --}}
            @if($score !== null || $criticalIssues !== null)
                <table cellpadding="0" cellspacing="0" style="width: 100%; margin: 24px 0; border-collapse: separate; border-spacing: 8px 0;">
                    <tr>
                        @if($score !== null)
                            <td style="text-align: center; padding: 20px 12px; background: #f4f4f6; border-radius: 12px; width: 50%;">
                                <div style="font-size: 32px; font-weight: 800; color: {{ $scoreColour }}; line-height: 1;">{{ $score }}</div>
                                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin-top: 6px; font-weight: 700;">Overall · {{ $scoreLabel }}</div>
                            </td>
                        @endif
                        @if($criticalIssues !== null)
                            <td style="text-align: center; padding: 20px 12px; background: #f4f4f6; border-radius: 12px; width: 50%;">
                                <div style="font-size: 32px; font-weight: 800; color: {{ $criticalIssues > 0 ? '#b91c1c' : '#166534' }}; line-height: 1;">{{ $criticalIssues }}</div>
                                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin-top: 6px; font-weight: 700;">Critical issues found</div>
                            </td>
                        @endif
                    </tr>
                </table>
            @endif

            <p style="margin: 24px 0 0; text-align: center;">
                <a href="{{ $publicUrl }}" style="display: inline-block; background: #B9FD33; color: #0F1B2D; text-decoration: none; padding: 14px 32px; border-radius: 999px; font-weight: 700; font-size: 15px;">View your full report</a>
            </p>

            <p style="margin: 24px 0 0; font-size: 14px; line-height: 1.6; color: #4b5563;">
                Every issue in the report is explained in plain English — no technical jargon. It'll tell you what each problem means, why it matters for your business, and how to fix it.
            </p>

            <p style="margin: 24px 0 0; font-size: 14px; line-height: 1.6; color: #4b5563;">
                Want us to walk you through the results and quote on fixing them? Just reply to this email.
            </p>

            <p style="margin: 28px 0 0; font-size: 14px; color: #4b5563;">
                — The We Are Jungle team
            </p>
        </div>

    </div>

    <p style="max-width: 620px; margin: 16px auto 0; text-align: center; font-size: 11px; color: #9ca3af;">
        You requested this audit from wearejungle.co.uk. If you didn't, ignore this email — no further messages will follow.
    </p>
</body>
</html>
