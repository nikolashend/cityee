{{-- Trust-agent: agent photo + trust theses + social links --}}
@props(['locale'])
@php
    $cfg   = config("cityee-v3.agent_trust.{$locale}");
    $links = config('cityee-v3.social_links');
    $agent = config('cityee.agent');
    $photo = $agent['photo'] ?? '/assets/templates/offshors/img/ap1.png';
@endphp

<section class="v3-trust-agent" aria-label="{{ $cfg['name'] }}">
    <div class="container">
        <div class="v3-trust-agent__inner">
            <div class="v3-trust-agent__photo-col">
                <img src="{{ $photo }}" alt="{{ $cfg['name'] }}" class="v3-trust-agent__img" width="240" height="300" loading="lazy">
            </div>
            <div class="v3-trust-agent__info">
                <h2 class="v3-trust-agent__name">{{ $cfg['name'] }}</h2>
                <p class="v3-trust-agent__role">{{ $cfg['role'] }}</p>
                <p class="v3-trust-agent__location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $cfg['location'] }}</p>

                <ul class="v3-trust-agent__points">
                    @foreach($cfg['points'] as $pt)
                    <li><span class="v3-trust-agent__check">&#10003;</span> {{ $pt }}</li>
                    @endforeach
                </ul>

                <div class="v3-trust-agent__socials">
                    <a href="{{ $links['linkedin'] }}" target="_blank" rel="noopener" aria-label="LinkedIn" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
                    <a href="{{ $links['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram" title="Instagram"><i class="fa fa-instagram"></i></a>
                    <a href="{{ $links['facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook" title="Facebook"><i class="fa fa-facebook"></i></a>
                    <a href="{{ $links['tg_channel'] }}" target="_blank" rel="noopener" aria-label="Telegram" title="Telegram"><i class="fa fa-telegram"></i></a>
                    <a href="{{ $links['whatsapp_audit'] }}" target="_blank" rel="noopener" aria-label="WhatsApp" title="WhatsApp"><i class="fa fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
