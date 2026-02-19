{{-- Audit request form --}}
@props(['locale'])
@php
    $f = config("cityee-v3.forms.{$locale}");
@endphp

<section class="v3-form-section" id="v3-form-audit" aria-labelledby="v3-form-audit-title">
    <div class="container">
        <h2 id="v3-form-audit-title" class="v3-section-title">{{ $f['audit_title'] }}</h2>

        <form class="v3-form" data-v3-form="audit-request" action="/contact/audit-request" method="POST">
            @csrf
            <input type="hidden" name="locale" value="{{ $locale }}">

            <div class="v3-form__group">
                <label for="audit_link">{{ $f['audit_link'] }}</label>
                <input type="url" id="audit_link" name="link" placeholder="https://" class="v3-form__input">
            </div>

            <div class="v3-form__group">
                <label for="audit_district">{{ $f['audit_district'] }}</label>
                <input type="text" id="audit_district" name="district" class="v3-form__input">
            </div>

            <div class="v3-form__row">
                <div class="v3-form__group v3-form__group--half">
                    <label for="audit_type">{{ $f['audit_type'] }}</label>
                    <select id="audit_type" name="type" class="v3-form__input">
                        <option value="apartment">{{ $f['type_apartment'] }}</option>
                        <option value="house">{{ $f['type_house'] }}</option>
                        <option value="commercial">{{ $f['type_commercial'] }}</option>
                    </select>
                </div>
                <div class="v3-form__group v3-form__group--half">
                    <label for="audit_goal">{{ $f['audit_goal'] }}</label>
                    <select id="audit_goal" name="goal" class="v3-form__input">
                        <option value="sell">{{ $f['goal_sell'] }}</option>
                        <option value="rent">{{ $f['goal_rent'] }}</option>
                    </select>
                </div>
            </div>

            <div class="v3-form__group">
                <label for="audit_contact">{{ $f['audit_contact'] }}</label>
                <input type="text" id="audit_contact" name="contact" required class="v3-form__input">
            </div>

            <div class="v3-form__group">
                <label for="audit_lang">{{ $f['audit_lang'] }}</label>
                <select id="audit_lang" name="language" class="v3-form__input">
                    <option value="et">{{ $f['lang_et'] }}</option>
                    <option value="ru" @if($locale==='ru') selected @endif>{{ $f['lang_ru'] }}</option>
                    <option value="en" @if($locale==='en') selected @endif>{{ $f['lang_en'] }}</option>
                </select>
            </div>

            <button type="submit" class="v3-btn v3-btn--primary v3-btn--full">{{ $f['audit_submit'] }}</button>

            <p class="v3-form__success" style="display:none;" role="status">{{ $f['success_msg'] }}</p>
        </form>
    </div>
</section>
