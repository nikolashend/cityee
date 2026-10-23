{{-- Bank appraisal act request — paid LP only.
     Uses the shared [data-v3-form] handler, so the exactly-once
     generate_lead contract is identical to every other CityEE form. --}}
@props(['locale', 'ppc'])
@php
    $fc = $ppc['form_copy'];
@endphp

<section class="v3-form-section" id="v3-form-bank" aria-labelledby="v3-form-bank-title">
    <div class="container">
        <h2 id="v3-form-bank-title" class="v3-section-title">{{ $fc['title'] }}</h2>

        <form class="v3-form" data-v3-form="bank-appraisal" action="/contact/bank-appraisal" method="POST">
            @csrf
            <input type="hidden" name="locale" value="{{ $locale }}">

            <div class="v3-form__group">
                <label for="bank_address">{{ $fc['address'] }}</label>
                <input type="text" id="bank_address" name="address" required class="v3-form__input">
            </div>

            <div class="v3-form__group">
                <label for="bank_bank">{{ $fc['bank'] }}</label>
                <input type="text" id="bank_bank" name="bank" class="v3-form__input">
            </div>

            <div class="v3-form__group">
                <label for="bank_purpose">{{ $fc['purpose'] }}</label>
                <select id="bank_purpose" name="purpose" class="v3-form__input">
                    @foreach($fc['purposes'] as $purpose)
                    <option value="{{ $purpose }}">{{ $purpose }}</option>
                    @endforeach
                </select>
            </div>

            <div class="v3-form__group">
                <label for="bank_contact">{{ $fc['contact'] }}</label>
                <input type="text" id="bank_contact" name="contact" required class="v3-form__input">
            </div>

            <button type="submit" class="v3-btn v3-btn--primary v3-btn--full">{{ $fc['submit'] }}</button>

            <p class="v3-form__note" style="margin:.85rem 0 0;font-size:.92rem;line-height:1.5;color:#555">{{ $fc['note'] }}</p>

            <p class="v3-form__success" style="display:none;" role="status">{{ $fc['success'] }}</p>
        </form>
    </div>
</section>
