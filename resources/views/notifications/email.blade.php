<x-mail::message>
    {{-- Greeting --}}
    @if (!empty($greeting))
        # {{ $greeting }}
    @else
        @if ($level === 'error')
            <div style="color: #FF4D4F; font-size: 24px; font-weight: bold;">@lang('Oops!')</div>
        @else
            <div style="color: #52C41A; font-size: 24px; font-weight: bold;">@lang('Hello!')</div>
        @endif
    @endif

    {{-- Introductory Text --}}
    @foreach ($introLines as $line)
        <div style="color: #333; font-size: 16px; line-height: 1.5; margin-bottom: 15px;">
            {{ $line }}
        </div>
    @endforeach

    {{-- Call-to-Action Button --}}
    @isset($actionText)
        <x-mail::button :url="$actionUrl" color="green">
            {{ $actionText }}
        </x-mail::button>
    @endisset


    {{-- Outro Text --}}
    @foreach ($outroLines as $line)
        <div style="color: #666; font-size: 14px; line-height: 1.5; margin-top: 15px;">
            {{ $line }}
        </div>
    @endforeach

    {{-- Closing --}}
    @if (!empty($salutation))
        <div style="margin-top: 20px; font-size: 16px; font-weight: bold;">
            {{ $salutation }}
        </div>
    @else
        <div style="margin-top: 20px; font-size: 16px; font-weight: bold; color: #333;">
            @lang('Best regards,')<br>
            <span style="color: #1890FF;">{{ config('app.name') }}</span>
        </div>
    @endif

    {{-- Subcopy --}}
    @isset($actionText)
        <x-slot:subcopy>
            <div style="font-size: 12px; color: #999; margin-top: 20px;">
                @lang("If you're having trouble clicking the \":actionText\" button, copy and paste this URL into your browser:", [
                    'actionText' => $actionText,
                ])
                <a href="{{ $actionUrl }}" style="color: #1890FF; text-decoration: underline;">{{ $actionUrl }}</a>
            </div>
        </x-slot:subcopy>
    @endisset
</x-mail::message>
